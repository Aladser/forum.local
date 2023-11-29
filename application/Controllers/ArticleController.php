<?php

namespace Aladser\Controllers;

use Aladser\Core\Controller;
use Aladser\Core\DB\DBCtl;

/** диалоги */
class ArticleController extends Controller
{
    public function __construct(DBCtl $dbCtl = null)
    {
        parent::__construct($dbCtl);
        $this->article = $dbCtl->getArticle();
    }

    public function index()
    {
        // логин пользователя
        $data['login'] = UserController::getLoginFromClient();
        // статьи
        $data['articles'] = $this->article->all();

        $this->view->generate('template_view.php', 'articles_view.php', 'articles.css', 'articles.js', 'Форум - главная', $data);
    }
}
