<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

/** статьи */
class ArticleController extends Controller
{
    // аутентифицированный пользователь
    private string $authUser;

    public function __construct(int $articlesToPage = 10)
    {
        parent::__construct();

        $this->users = new User();
        $this->articles = new Article();
        $this->comments = new Comment();
        $this->authUser = UserController::getAuthUser();

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
        $data['login'] = $this->authUser;
        // индекс текущей страницы
        $data['page-index'] = isset($_GET['list']) ? $_GET['list'] - 1 : 0;
        // число страниц
        $data['page-count'] = $this->pageCount;
        // порция статей из БД
        $offset = $data['page-index'] * $this->articlesToPage;
        $data['articles'] = $this->articles->get_chunk_of_articles($this->articlesToPage, $offset);
        $this->view->generate(
            'Форум - статьи',
            'template_view.php',
            'articles_view.php',
            $data,
            null,
            'articles.css'
        );
    }

    // показать статью
    public function show($articleId): void
    {
        $data['login'] = $this->authUser;
        $data['article'] = $this->articles->get_article($articleId);
        $data['comments'] = $this->comments->getCommentsOfArticle($articleId);

        $this->view->generate(
            "Форум. Статья: {$data['article']['title']}",
            'template_view.php',
            'show-article_view.php',
            $data,
            'article/show-article.js',
            'show-article.css'
        );
    }

    // форма создания статьи
    public function create(): void
    {
        $data['login'] = $this->authUser;
        $data['csrf'] = Controller::createCSRFToken();

        $this->view->generate(
            'Форум - создать статью',
            'template_view.php',
            'create-article_view.php',
            $data,
            'article/create-article.js'
        );
    }

    // сохранить статью в бд
    public function store(): void
    {
        $title = $_POST['title'];
        $summary = $_POST['summary'];
        $content = $_POST['content'];
        $authorId = $this->users->getId($this->authUser);

        if (!$this->articles->title_exsists($title)) {
            $isAdded = $this->articles->add($authorId, $title, $summary, $content);
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

        $data['login'] = $this->authUser;
        $data['csrf'] = Controller::createCSRFToken();

        $this->view->generate(
            'Форум - изменить статью',
            'template_view.php',
            'edit-article_view.php',
            $data,
            'article/edit-article.js'
        );
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
