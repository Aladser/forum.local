<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    // удаление данных об авторизации
    public static function removeAuthData(): void
    {
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, '', time() - 3600, '/');
        }
        session_destroy();
    }

    // возвращает авторизованного пользователя
    public static function getAuthUser(): ?object
    {
        $authuser = null;
        if (isset($_SESSION['login'])) {
            $authuser = User::where('login', $_SESSION['login']);
        } elseif (isset($_COOKIE['login'])) {
            $authuser = User::where('login', $_COOKIE['login']);
        }

        return $authuser;
    }
}
