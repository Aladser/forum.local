<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

/** статьи */
class ArticleController extends Controller
{
    // csrf
    private string $csrf;
    // аутентифицированный пользователь
    private string $authUser;

    public function __construct(int $articlesToPage = 10)
    {
        parent::__construct();

        $this->users = new User();
        $this->articles = new Article();
        $this->comments = new Comment();

        $this->authUser = UserController::getAuthUser();
        $this->csrf = Controller::createCSRFToken();

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
    public function index(mixed $args): void
    {
        $data['login'] = $this->authUser;
        // индекс текущей страницы
        $data['page-index'] = isset($args['list']) ? $args['list'] - 1 : 0;
        // число страниц
        $data['page-count'] = $this->pageCount;
        // порция статей из БД
        $offset = $data['page-index'] * $this->articlesToPage;

        $data['articles'] = $this->articles->all($this->articlesToPage, $offset);

        $this->view->generate(
            page_name: 'Форум - статьи',
            template_view: 'template_view.php',
            content_view: 'articles/articles_view.php',
            data: $data,
            content_css: 'articles.css'
        );
    }

    // показать статью
    public function show(mixed $args): void
    {
        $articleId = $args['id'];
        // проверка существования id
        $articleExisted = $this->articles->exists('id', $articleId);
        if (!$articleExisted) {
            header('Location: /');

            return;
        }

        $data['login'] = $this->authUser;
        $data['csrf'] = $this->csrf;

        $data['article'] = $this->articles->get($articleId);
        $data['comments'] = $this->comments->getCommentsOfArticle($articleId);

        $head = '<meta name="csrf" content="'.$this->csrf.'">';
        $this->view->generate(
            "Форум. Статья: {$data['article']['title']}",
            'template_view.php',
            'articles/show-article_view.php',
            $data,
            [
                'ServerRequest.js',
                'DBLocalTime.js',
                'article/ArticleClientController.js',
                'CommentClientController.js',
                'article/show-article.js',
            ],
            'show-article.css',
            $head
        );
    }

    // форма создания
    public function create(mixed $args): void
    {
        $data['login'] = $this->authUser;
        $data['csrf'] = $this->csrf;

        // проверка ошибок
        if (isset($args['error'])) {
            if ($args['error'] == 'ttlexst') {
                $data['error'] = 'Заголок занят';
                $data['title'] = $args['title'];
            }
        } else {
            $data['error'] = '';
            $data['title'] = '';
        }

        $this->view->generate(
            'Форум - создать статью',
            'template_view.php',
            'articles/create-article_view.php',
            $data
        );
    }

    // сохранить статью
    public function store(mixed $args): void
    {
        $title = $args['title'];
        $summary = $args['summary'];
        $content = $args['content'];
        $authorId = $this->users->getId($this->authUser);

        if (!$this->articles->exists('title', $title)) {
            $id = $this->articles->add($authorId, $title, $summary, $content);
            $url = "show/$id";
        } else {
            $url = "create?error=ttlexst&title=$title";
        }

        header('Location: /article/'.$url);
    }

    // форма редактирования
    public function edit(mixed $args): void
    {
        $id = $args['id'];
        $articleExisted = $this->articles->exists('id', $id);
        if (!$articleExisted) {
            header('Location: /');

            return;
        }

        // проверка автора статьи
        $authorName = $this->articles->get($id)['username'];
        if ($authorName !== $this->authUser) {
            header('Location: /article/show/'.$id);
        }

        // данные о статье
        $data = $this->articles->get($id);

        // проверка ошибок
        if (isset($args['error'])) {
            if ($args['error'] === 'title_exists') {
                $data['error'] = 'Заголовок занят';
                $data['title'] = $args['title'];
            } elseif ($args['error'] === 'system_error') {
                $data['error'] = 'Системная ошибка. Попробуйте позже';
            }
        } else {
            $data['error'] = '';
        }

        $data['login'] = $this->authUser;
        $data['csrf'] = $this->csrf;

        $this->view->generate(
            'Форум - изменить статью',
            'template_view.php',
            'articles/edit-article_view.php',
            $data
        );
    }

    // обновить статью
    public function update(mixed $args): void
    {
        $id = $args['id'];
        $title = $args['title'];
        $summary = $args['summary'];
        $content = $args['content'];
        // заголовок изменяемой статьи
        $articleTitle = $this->articles->get($id)['title'];

        if (!$this->articles->exists('title', $title) || $title === $articleTitle) {
            $isUpdated = $this->articles->update($id, $title, $summary, $content);
            if ($isUpdated) {
                $url = "show/$id";
            } else {
                $url = "edit/$id?error=system_error";
            }
        } else {
            $url = "edit/$id?error=title_exists&title=".rawurlencode($title);
        }

        header("Location: /article/$url");
    }

    // удалить статью
    public function remove(mixed $args): void
    {
        $id = $args['id'];
        $isRemoved = $this->articles->remove($id);
        $url = $isRemoved ? '\\' : '\system_error';
        header('Location: '.$url);
    }
}
