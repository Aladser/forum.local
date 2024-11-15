<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    // форма регистрации
    public function register(mixed $args): void
    {
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

        $this->render(
            page_name: 'Регистрация',
            template_view: 'template_view.php',
            content_view: 'users/register_view.php',
            data: $args,
            content_css: 'form.css',
        );
    }

    // сохранение нового пользователя
    public function store(mixed $args): void
    {
        $login = $args['login'];
        $password = $args['password'];
        $passwordConfirm = $args['password_confirm'];
        $isUser = User::where('login', $login)->exists();

        $url = null;
        if ($password !== $passwordConfirm) {
            $url = "/register?error=dp&user=$login";
        } elseif (strlen($password) < 3) {
            $url = "/register?error=sp&user=$login";
        } elseif (!$isUser) {
            $params = [
                'login' => $login,
                'password' => $password,
            ];
            User::insert($params);
            UserService::saveAuth($login);
            $url = '/';
        } else {
            $url = "/register?error=usrexsts&user=$login";
        }

        self::redirect($url);
    }

    // форма входа
    public function login(mixed $args): void
    {
        // ошибки авторизации
        if (isset($args['error'])) {
            $args['error'] = 'Неверные логин или пароль';
        } else {
            $args['user'] = '';
        }

        $this->render(
            page_name: 'Войти в систему',
            template_view: 'template_view.php',
            content_view: 'users/login_view.php',
            content_css: 'form.css',
            data: $args,
        );
    }

    // аутентификация
    public function auth(mixed $args): void
    {
        $login = $args['login'];
        $password = $args['password'];
        $isUser = User::where('login', $login)->where('password', $password)->exists();

        $url = null;
        // проверка аутентификации
        if ($isUser) {
            UserService::saveAuth($login);
            $url = '/';
        } else {
            $url = "/login?user=$login&error=1";
        }

        self::redirect($url);
    }

    // выйти из системы
    public function logout(): void
    {
        UserService::removeAuth();

        self::redirect('/');
    }
}
