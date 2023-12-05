<?php

namespace Aladser\Controllers;

use Aladser\Core\Controller;
use Aladser\Core\DBCtl;

/** статьи */
class ArticleController extends Controller
{
    public function __construct(DBCtl $dbCtl = null, int $articlesToPage = 5)
    {
        parent::__construct($dbCtl);

        $this->user = $dbCtl->getUsers();
        $this->articles = $dbCtl->getArticles();
        $this->comments = $dbCtl->getComments();

        // данные для пагинации
        // число статей на странице
        $this->articlesToPage = $articlesToPage;
        // число статей
        $this->articleCount = $this->articles->count();
        // число страниц
        if ($this->articleCount <= $this->articlesToPage) {
            $this->pageCount = 1;
        } else {
            $this->pageCount = intdiv($this->articleCount, $this->articlesToPage);

            if ($this->articleCount % $this->articlesToPage != 0) {
                ++$this->pageCount;
            }
        }
    }

    // список статей
    public function index(): void
    {
        $data['login'] = UserController::getLoginFromClient();
        // индекс текущей страницы
        $data['page-index'] = isset($_GET['list']) ? $_GET['list'] - 1 : 0;
        // число страниц
        $data['page-count'] = $this->pageCount;
        // порция статей из БД
        $offset = $data['page-index'] * $this->articlesToPage;
        $data['articles'] = $this->articles->get_chunk_of_articles($this->articlesToPage, $offset);
        $this->view->generate('template_view.php', 'articles_view.php', 'articles.css', null, 'Форум - статьи', $data);
    }

    // показать статью
    public function show($articleId): void
    {
        $data['article'] = $this->articles->get_article($articleId);
        $data['login'] = UserController::getLoginFromClient();
        $data['comments'] = $this->comments->getCommentsOfArticle($articleId);

        $this->view->generate('template_view.php', 'show-article_view.php', 'show-article.css', 'article/show-article.js', "Форум. Статья: {$data['article']['title']}", $data);
    }

    // форма создания статьи
    public function create(): void
    {
        $data['login'] = UserController::getLoginFromClient();

        $this->view->generate('template_view.php', 'create-article_view.php', null, 'article/create-article.js', 'Форум - создать статью', $data);
    }

    // сохранить статью в бд
    public function store(): void
    {
        $author = $this->user->getId($_POST['author']);
        $title = $_POST['title'];
        $summary = $_POST['summary'];
        $content = $_POST['content'];

        if (!$this->articles->title_exsists($title)) {
            $isAdded = $this->articles->add($author, $title, $summary, $content);
            $result = ['result' => (int) $isAdded];
        } else {
            $result = ['result' => 0, 'description' => 'заголовок занят'];
        }
        echo json_encode($result);
    }

    // форма редактирования статьи
    public function edit($id): void
    {
        // данные о статье
        $data = $this->articles->get_article($id);
        // логин пользователя
        $data['login'] = UserController::getLoginFromClient();

        $this->view->generate('template_view.php', 'edit-article_view.php', null, 'article/edit-article.js', 'Форум - изменить статью', $data);
    }

    // обновить статью в бд
    public function update(): void
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $summary = $_POST['summary'];
        $content = $_POST['content'];
        echo (int) $this->articles->update($id, $title, $summary, $content);
    }

    // удалить статью из бд
    public function remove($id): void
    {
        $this->comments->removeCommentsOfArticle($id);
        $isRemoved = $this->articles->remove($id);
        $url = $isRemoved ? 'Location: \\' : 'Location: \404';
        header($url);
    }
}
