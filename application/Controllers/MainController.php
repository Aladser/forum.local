<?php

namespace Aladser\Controllers;

use Aladser\Core\Controller;

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

        $this->view->generate('template_view.php', 'main_view.php', 'main.css', '', 'Форум');
    }

    public function page404()
    {
        $this->view->generate('template_view.php', 'page404_view.php', '', '', 'Ошибка 404');
    }
}
