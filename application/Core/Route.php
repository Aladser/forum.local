<?php

namespace App\Core;

use App\Controllers\MainController;

class Route
{
    public static function start()
    {
        session_start();

        // проверка ошибки access_denied из Javascript
        if ($_SERVER['REQUEST_URI'] === '/access_denied') {
            $controller = new MainController();
            $controller->error('Access denied');

            return;
        }

        // проверка CSRF
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['CSRF'])) {
                if ($_POST['CSRF'] !== $_SESSION['CSRF']) {
                    http_response_code(419);
                    $controller = new MainController();
                    $controller->error('Access is denied');

                    return;
                }
            } else {
                http_response_code(419);
                $controller = new MainController();
                $controller->error('No csrf');

                return;
            }
        }

        // URL - /контроллер/функция/аргумент
        $url = mb_substr($_SERVER['REQUEST_URI'], 1);
        $url = explode('?', $url)[0];

        if ($url === 'login') {
            // форма входа
            $controller_name = 'User';
            $action = 'login';
            $funcParam = false;
        } elseif ($url === 'register') {
            // форма регистрации
            $controller_name = 'User';
            $action = 'register';
            $funcParam = false;
        } else {
            // URL как массив
            $urlAsArray = explode('/', $url);
            // получение контроллера
            $controller_name = !empty($url) ? ucfirst($urlAsArray[0]) : 'main';
            // получение функции
            if (count($urlAsArray) > 1) {
                $action = $urlAsArray[1];
                $actionArr = explode('-', $action);
                for ($i = 1; $i < count($actionArr); ++$i) {
                    $actionArr[$i] = ucfirst($actionArr[$i]);
                }
                $action = implode('', $actionArr);
            } else {
                $action = 'index';
            }
            // функция аргумента
            $funcParam = count($urlAsArray) == 3 ? $urlAsArray[2] : false;
        }

        // преобразовать url в название класса
        $controller_name = str_replace('-', ' ', $controller_name);
        $controller_name = ucwords($controller_name);
        $controller_name = str_replace(' ', '', $controller_name);

        // авторизация сохраняется в куки и сессии. Если авторизация есть, то / -> /article
        if ($controller_name === 'Main'
            && (isset($_SESSION['auth']) || isset($_COOKIE['auth']))
            && !isset($_GET['logout'])
        ) {
            $controller_name = 'Article';
        }

        // редирект /article без авторизации -> /
        if (($controller_name === 'Article')
            && !(isset($_SESSION['auth']) || isset($_COOKIE['auth']))
        ) {
            $controller_name = 'Main';
        }

        // создаем контроллер
        $controller_name .= 'Controller';
        $controller_path = dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$controller_name.'.php';
        if (file_exists($controller_path)) {
            require_once $controller_path;
            $controller_name = '\\App\\Controllers\\'.$controller_name;
            $controller = new $controller_name();
        } else {
            $controller = new MainController();
            $controller->error("not found $controller_path");

            return;
        }

        // вызов метода
        if (method_exists($controller, $action)) {
            // проверка наличия аргумента функции
            $funcParam = $funcParam ? $funcParam : null;

            $controller->$action($funcParam);
        } else {
            $controller = new MainController();
            $controller->error('Controller not exists');
        }
    }

    private static function convertName($name)
    {
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        return $name;
    }
}
