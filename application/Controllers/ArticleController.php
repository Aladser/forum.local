<?php

namespace Aladser\Controllers;

use Aladser\Core\Controller;

/** диалоги */
class ArticleController extends Controller
{
    public function index()
    {
        $data['login'] = UserController::getLoginFromClient();
        $this->view->generate('template_view.php', 'articles_view.php', 'articles.css', '', 'Форум - главная', $data);
    }
}
