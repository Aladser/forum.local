<?php

namespace Aladser\Controllers;

use Aladser\Core\Controller;
use Aladser\Core\DB\DBCtl;
use Aladser\Models\UserModel;

/** контрллер проверки уникальности никнейма */
class UserController extends Controller
{
    private UserModel $users;

    public function __construct(DBCtl $dbCtl = null)
    {
        parent::__construct($dbCtl);
        $this->users = $dbCtl->getUsers();
    }

    // регистрация пользователя
    public function register()
    {
        if (!$this->users->exists($_POST['login'])) {
            $email = $_POST['login'];
            $password = $_POST['password'];
            $isRegUser = $this->users->add($email, $password) === 1;
            $data = $isRegUser ? 'user_registered' : 'add_user_error';
        } else {
            $data['result'] = 'user_exists';
        }

        echo json_encode($data);
    }

    // авторизация
    public function login()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        // проверка аутентификации
        if ($this->users->exists($login)) {
            // проверка введенных данных
            $isValidLogin = $this->users->check($login, $password) == 1;
            if ($isValidLogin) {
                // сессия
                $_SESSION['auth'] = 1;
                $_SESSION['login'] = $login;
                // куки
                setcookie('auth', 1, time() + 60 * 60 * 24, '/');
                setcookie('login', $login, time() + 60 * 60 * 24, '/');

                echo json_encode(['result' => 1]);
            } else {
                echo 'Неправильный пароль';
            }
        } else {
            echo 'Пользователь не существует';
        }
    }

    public function isUniqueNickname()
    {
        // проверка CSRF
        if ($_POST['CSRF'] !== $_SESSION['CSRF']) {
            echo 'Подмена URL-адреса';

            return;
        }

        $nickname = htmlspecialchars($_POST['nickname']);
        $response = $this->users->isUniqueNickname($nickname) ? 1 : 0;
        echo json_encode(['response' => $response]);
    }

    public function update()
    {
        // проверка на подмену адреса
        if ($_POST['CSRF'] !== $_SESSION['CSRF']) {
            echo 'подделка URL-адреса';

            return;
        }

        $email = Controller::getUserMailFromClient();
        $data['user_email'] = $email;
        $nickname = trim($_POST['user_nickname']);
        $data['user_nickname'] = $nickname == '' ? null : $nickname;
        $data['user_hide_email'] = $_POST['user_hide_email'];

        // перемещение изображения профиля из временой папки в папку изображений профилей
        $tempDirPath = dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
        $dwlDirPath = dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'profile_photos'.DIRECTORY_SEPARATOR;

        $filename = $_POST['user_photo'];
        // вырезает название файла
        $filename = mb_substr($filename, 0, mb_strripos($filename, '?'));

        $fromPath = $tempDirPath.$filename;
        $toPath = $dwlDirPath.$filename;

        // если загружено новое изображение
        if (file_exists($fromPath)) {
            foreach (glob($dwlDirPath.$email.'*') as $file) {
                unlink($file); // удаление старых файлов профиля
            }
            if (rename($fromPath, $toPath)) {
                $data['user_photo'] = $filename;
                echo $this->users->setUserData($data) ? 1 : 0;
            } else {
                echo 0;
            }
        } else {
            $data['user_photo'] = $filename;
            echo $this->users->setUserData($data) ? 1 : 0;
        }
    }

    /** получить логин из сессии или куки */
    public static function getLoginFromClient()
    {
        if (isset($_COOKIE['login'])) {
            return $_COOKIE['login'];
        } elseif (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        } else {
            return null;
        }
    }
}
