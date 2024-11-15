<?php

namespace App\Controllers;

use App\Core\Controller;

/** контрллер главной страницы */
class MainController extends Controller
{
    public function index()
    {
        $this->render(
            template_view: 'template_view.php',
            content_view: 'main_view.php',
        );
    }

    public function error($error)
    {
        $this->render(
            'Ошибка',
            'template_view.php',
            'page_error_view.php',
            ['error' => $error]
        );
    }
}
