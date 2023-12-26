<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\DBCtl;
use App\Models\User;

// пользователи
class UserController extends Controller
{
    private User $users;

    public function __construct(DBCtl $dbCtl = null)
    {
        parent::__construct($dbCtl);
        $this->users = $dbCtl->getUsers();
    }

    // регистрация пользователя
    public function store()
    {
        // проверить существование пользователя
        if (!$this->users->exists($_POST['login'])) {
            $email = $_POST['login'];
            $password = $_POST['password'];
            $isRegUser = $this->users->add($email, $password) === 1;
            $data = $isRegUser ? 'user_registered' : 'add_user_error';
            echo json_encode($data);
        } else {
            header('Location: /register?error=usrexsts&user='.$_POST['login']);
        }
    }

    // форма входа
    public function login()
    {
        $data = ['csrfToken' => Controller::createCSRFToken()];
        // ошибки авторизации
        $data['user'] = '';
        if (isset($_GET['error'])) {
            $data['user'] = $_GET['user'];
            if ($_GET['error'] == 'wp') {
                $data['error'] = 'Неверный пароль';
            } elseif ($_GET['error'] == 'wu') {
                $data['error'] = 'Пользователь не существует';
            } else {
                $data['error'] = $_GET['error'];
            }
        }

        $this->view->generate(
            'Форум - войти',
            'template_view.php',
            'login_view.php',
            $data
        );
    }

    // авторизация
    public function auth()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        // проверка аутентификации
        if ($this->users->exists($login)) {
            // проверка введенных данных
            $isAuth = $this->users->is_correct_password($login, $password);
            if ($isAuth) {
                // сессия
                $_SESSION['auth'] = 1;
                $_SESSION['login'] = $login;
                // куки
                setcookie('auth', 1, time() + 60 * 60 * 24, '/');
                setcookie('login', $login, time() + 60 * 60 * 24, '/');

                header('Location: /');
            } else {
                header("Location: /login?user=$login&error=wp");
            }
        } else {
            header("Location: /login?user=$login&error=wu");
        }
    }

    // форма регистрации
    public function register()
    {
        $data = ['csrf' => Controller::createCSRFToken()];

        // ошибки авторизации
        $data['error'] = '';
        if (isset($_GET['error'])) {
            $data['user'] = $_GET['user'];
            if ($_GET['error'] == 'usrexsts') {
                $data['error'] = 'Пользователь существует';
            } else {
                $data['error'] = $_GET['error'];
            }
        }

        $this->view->generate(
            'Форум - регистрация',
            'template_view.php',
            'register_view.php',
            $data,
            null,
            'reg.css'
        );
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
