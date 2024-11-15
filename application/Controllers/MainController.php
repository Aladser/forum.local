<?php

namespace App\Controllers;

use App\Core\Controller;

/** контрллер главной страницы */
class MainController extends Controller
{
    public function index()
    {
        $this->view->generate(
            page_name: 'Форум',
            template_view: 'template_view.php',
            content_view: 'main_view.php',
        );
    }

    public function error($error)
    {
        $data = ['error' => $error];
        $this->view->generate(
            'Ошибка',
            'template_view.php',
            'page_error_view.php',
            $data
        );
    }
}
