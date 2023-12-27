<?php

namespace App\Controllers;

use App\Core\Controller;

/** контрллер главной страницы */
class MainController extends Controller
{
    public function index()
    {
        // разлогирование
        if (isset($_GET['logout'])) {
            setcookie('email', '', time() - 3600, '/');
            setcookie('auth', '', time() - 3600, '/');
            session_destroy();
        }

        $this->view->generate(
            'Форум',
            'template_view.php',
            'main_view.php',
            null,
            null,
            'main.css');
    }

    public function error($errorName)
    {
        $this->view->generate(
            'Ошибка',
            'template_view.php',
            'page_error_view.php',
            ['error' => $errorName]);
    }
}
