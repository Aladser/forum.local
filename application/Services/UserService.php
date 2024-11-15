<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    // Возвращает авторизованного пользователя
    public static function getAuthUser(): ?object
    {
        $authuser = null;
        if (isset($_SESSION['login'])) {
            $authuser = User::where('login', $_SESSION['login'])->first();
        } elseif (isset($_COOKIE['login'])) {
            $authuser = User::where('login', $_COOKIE['login'])->first();
        }

        return $authuser;
    }

    /** Возвращает CSRF-токен.
     * @throws \Exception
     */
    public static function createCSRFToken(): string
    {
        $csrfToken = hash('gost-crypto', random_int(0, 999999));
        $_SESSION['CSRF'] = $csrfToken;

        return $csrfToken;
    }

    /** Сохраняет авторизацию в куки и сессии.
     *
     * @param string $login логин
     */
    public static function saveAuth(string $login): void
    {
        $_SESSION['auth'] = 1;
        $_SESSION['login'] = $login;
        setcookie('auth', 1, time() + 60 * 60 * 24, '/');
        setcookie('login', $login, time() + 60 * 60 * 24, '/');
    }

    // Удаляет данные авторизации
    public static function removeAuth(): void
    {
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, '', time() - 3600, '/');
        }
        session_destroy();
    }
}
