<?php

namespace App\Core;

use App\Controllers\MainController;

class Route
{
    // специфичные роуты
    //  $specificRoutes[роут] - контроллер, роут - действие
    private static $specificRoutes = [
        'login' => 'User',
        'register' => 'User',
       ];

    public static function start()
    {
        session_start();

        // проверка ошибки access_denied из Javascript-класса ServerRequest
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
                $controller->error('Не отправлен csrf-токен');

                return;
            }
        }

        $url = mb_substr($_SERVER['REQUEST_URI'], 1);
        $url = explode('?', $url)[0];

        if (array_key_exists($url, self::$specificRoutes)) {
            $controller_name = self::$specificRoutes[$url];
            $action = self::convertName($url);
            $funcParam = false;
        } else {
            // URL - [контроллер, функция, аргумент]
            $urlAsArray = explode('/', $url);
            // получение контроллера
            $controller_name = !empty($url) ? ucfirst($urlAsArray[0]) : 'main';
            // получение функции
            if (count($urlAsArray) > 1) {
                $action = self::convertName($urlAsArray[1]);
            } else {
                $action = 'index';
            }
            // функция аргумента
            $funcParam = count($urlAsArray) == 3 ? $urlAsArray[2] : false;
        }
        // преобразовать url в название класса
        $controller_name = self::convertName($controller_name);
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
