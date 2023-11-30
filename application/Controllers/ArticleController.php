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
        $this->article = $dbCtl->getArticles();
        $this->user = $dbCtl->getUsers();
    }

    // список статей
    public function index()
    {
        // логин пользователя
        $data['login'] = UserController::getLoginFromClient();
        // статьи
        $data['articles'] = $this->article->all();

        $this->view->generate('template_view.php', 'articles_view.php', 'articles.css', 'articles.js', 'Форум - главная', $data);
    }

    // форма создания статей
    public function create()
    {
        // логин пользователя
        $data['login'] = UserController::getLoginFromClient();

        $this->view->generate('template_view.php', 'create-article_view.php', null, 'create-article.js', 'Форум - создать тему', $data);
    }

    // сохранить статью в бд
    public function store()
    {
        $author = $this->user->getUserId($_POST['author']);
        $title = $_POST['title'];
        $summary = $_POST['summary'];
        $content = $_POST['content'];
        echo (int) $this->article->add($author, $title, $summary, $content);
    }

    // удалить статью из бд
    public function remove()
    {
        $id = $_POST['id'];
        echo json_encode(['result' => (int) $this->article->remove($id)]);
    }
}
