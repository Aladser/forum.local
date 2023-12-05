<?php

namespace Aladser\Controllers;

use Aladser\Core\Controller;
use Aladser\Core\DBCtl;
use Aladser\Models\User;

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
    public function auth()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        // проверка аутентификации
        if ($this->users->exists($login)) {
            // проверка введенных данных
            $isValidLogin = $this->users->is_correct_password($login, $password);
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

    // форма регистрации
    public function register()
    {
        $data = ['csrfToken' => Controller::createCSRFToken()];
        $this->view->generate('template_view.php', 'reg_view.php', 'reg.css', 'reg.js', 'Форум - регистрация', $data);
    }

    // форма входа
    public function login()
    {
        $data = ['csrfToken' => Controller::createCSRFToken()];
        $this->view->generate('template_view.php', 'login_view.php', '', 'login.js', 'Форум - войти', $data);
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
