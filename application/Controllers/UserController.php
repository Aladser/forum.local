<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Services\UserService;

use function App\Core\route;

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
    public function register(mixed $args): void
    {
        $args['csrf'] = $this->csrf;
        $routes = [
            'home' => route('home'),
            'store' => route('store'),
        ];
        // ошибки регистрации
        if (isset($args['error'])) {
            if ($args['error'] == 'usrexsts') {
                $args['error'] = 'Пользователь существует';
            } elseif ($args['error'] == 'system_error') {
                $args['error'] = 'Системная ошибка. Попробуйте позже';
            } elseif ($args['error'] == 'sp') {
                $args['error'] = 'Пароль не менее трех символов';
            } elseif ($args['error'] == 'dp') {
                $args['error'] = 'Пароли не совпадают';
            }
        } else {
            $args['error'] = '';
            $args['user'] = '';
        }

        $this->view->generate(
            page_name: "{$this->site_name} - регистрация пользователя",
            template_view: 'template_view.php',
            content_view: 'users/register_view.php',
            data: $args,
            content_css: 'form.css',
            routes: $routes
        );
    }

    // регистрация пользователя
    public function store(mixed $args): void
    {
        $login = $args['login'];
        $password = $args['password'];
        $passwordConfirm = $args['password_confirm'];
        $isUser = User::where('login', $login)->exists();

        // проверка паролей
        if ($args['password'] !== $args['password_confirm']) {
            // проверка совпадения паролей
            header("Location: /register?error=dp&user=$login");
        } elseif (strlen($password) < 3) {
            // длина пароля
            header("Location: /register?error=sp&user=$login");
        } elseif (!$isUser) {
            $params = [
                'login' => $login,
                'password' => $password,
            ];
            User::insert($params);
            $this->saveAuth($login);
            header('Location: /');
        } else {
            header("Location: /register?error=usrexsts&user=$login");
        }
    }

    // форма входа
    public function login(mixed $args): void
    {
        $args['csrf'] = $this->csrf;
        $routes = [
            'home' => route('home'),
            'auth' => route('auth'),
        ];

        // ошибки авторизации
        if (isset($args['error'])) {
            if ($args['error'] == 'wp') {
                $args['error'] = 'Неверный пароль';
            } elseif ($args['error'] == 'wu') {
                $args['error'] = 'Пользователь не существует';
            }
        } else {
            $args['user'] = '';
        }

        $this->view->generate(
            page_name: "{$this->site_name} - авторизация",
            template_view: 'template_view.php',
            content_view: 'users/login_view.php',
            content_css: 'form.css',
            data: $args,
            routes: $routes,
        );
    }

    // авторизация
    public function auth(mixed $args): void
    {
        $login = $args['login'];
        $password = $args['password'];
        $isUser = User::where('login', $login)->where('password', $password)->exists();

        // проверка аутентификации
        if ($isUser) {
            $this->saveAuth($login);
            header('Location: /');
        } else {
            header("Location: /login?user=$login&error=wu");
        }
    }

    public function logout()
    {
        UserService::removeAuthData();
        header('Location: /');
    }

    // Сохранить авторизацию в куки и сессии.
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
        if (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        } elseif (isset($_COOKIE['login'])) {
            return $_COOKIE['login'];
        } else {
            return false;
        }
    }
}
