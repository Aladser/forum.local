<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Services\UserService;

// пользователи
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

        $this->view->generate(
            page_name: "{$this->site_name} - регистрация пользователя",
            template_view: 'template_view.php',
            content_view: 'users/register_view.php',
            data: $args,
            content_css: 'form.css',
        );
    }

    // регистрация пользователя
    public function store(mixed $args): void
    {
        $login = $args['login'];
        $password = $args['password'];
        $passwordConfirm = $args['password_confirm'];
        $isUser = User::where('login', $login)->exists();

        if ($password !== $passwordConfirm) {
            header("Location: /register?error=dp&user=$login");
        } elseif (strlen($password) < 3) {
            header("Location: /register?error=sp&user=$login");
        } elseif (!$isUser) {
            $params = [
                'login' => $login,
                'password' => $password,
            ];
            User::insert($params);
            UserService::saveAuth($login);
            header('Location: /');
        } else {
            header("Location: /register?error=usrexsts&user=$login");
        }
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

        $this->view->generate(
            page_name: 'Авторизация',
            template_view: 'template_view.php',
            content_view: 'users/login_view.php',
            content_css: 'form.css',
            data: $args,
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
            UserService::saveAuth($login);
            header('Location: /');
        } else {
            header("Location: /login?user=$login&error=1");
        }
    }

    public function logout()
    {
        UserService::removeAuth();
        header('Location: /');
    }
}
