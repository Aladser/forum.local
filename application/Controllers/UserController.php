<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

// пользователи
class UserController extends Controller
{
    private User $userModel;
    private string $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->csrf = Controller::createCSRFToken();
    }

    // форма регистрации
    public function register(): void
    {
        $data['csrf'] = $this->csrf;
        // ошибки регистрации
        $data['error'] = '';
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'usrexsts') {
                $data['user'] = $_GET['user'];
                $data['error'] = 'Пользователь существует';
            } elseif ($_GET['error'] == 'system_error') {
                $data['error'] = 'Системная ошибка. Попробуйте позже';
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

    // регистрация пользователя
    public function store(): void
    {
        $email = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        // проверить существование пользователя
        if (!$this->userModel->exists($email)) {
            $isUserRegistered = $this->userModel->add($email, $password) === 1;
            if ($isUserRegistered) {
                $this->saveAuth($email);
                header('Location: /');
            } else {
                header('Location: /register?error=system_error');
            }
        } else {
            header("Location: /register?error=usrexsts&user=$email");
        }
    }

    // форма входа
    public function login(): void
    {
        $data['csrfToken'] = $this->csrf;
        // ошибки авторизации
        $data['user'] = '';
        if (isset($_GET['error'])) {
            $data['user'] = htmlspecialchars($_GET['user']);
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
    public function auth(): void
    {
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        // проверка аутентификации
        if ($this->userModel->exists($login)) {
            // проверка введенных данных
            $isAuth = $this->userModel->is_correct_password($login, $password);
            if ($isAuth) {
                $this->saveAuth($login);
                header('Location: /');
            } else {
                header("Location: /login?user=$login&error=wp");
            }
        } else {
            header("Location: /login?user=$login&error=wu");
        }
    }

    /** Сохранить авторизацию в куки и сессии.
     *
     * @param [string] $user имя пользователя
     */
    private function saveAuth(string $user): void
    {
        // сессия
        $_SESSION['auth'] = 1;
        $_SESSION['login'] = $user;
        // куки
        setcookie('auth', 1, time() + 60 * 60 * 24, '/');
        setcookie('login', $user, time() + 60 * 60 * 24, '/');
    }

    /** получить логин из сессии или куки */
    public static function getAuthUser(): string
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
