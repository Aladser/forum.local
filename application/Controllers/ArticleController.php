<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

use function App\route;

/** статьи */
class ArticleController extends Controller
{
    private string $csrf;
    private string $auth_user;
    private string $article_show_url;
    private string $article_edit_url;

    public function __construct(int $articlesToPage = 10)
    {
        parent::__construct();
        $this->article_show_url = route('article_show');
        $this->article_edit_url = route('article_edit');

        $this->users = new User();
        $this->articles = new Article();
        $this->comments = new Comment();

        $this->auth_user = UserController::getAuthUser();
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
        $data['login'] = $this->auth_user;
        // индекс текущей страницы
        $data['page-index'] = isset($args['list']) ? $args['list'] - 1 : 0;
        // число страниц
        $data['page-count'] = $this->pageCount;
        // порция статей из БД
        $offset = $data['page-index'] * $this->articlesToPage;

        $data['articles'] = $this->articles->all($this->articlesToPage, $offset);
        // url отдельных страниц
        for ($i = 0; $i < count($data['articles']); ++$i) {
            $id = $data['articles'][$i]['id'];
            $data['articles'][$i]['url'] = "{$this->article_show_url}/$id";
        }

        // роуты
        $routes = [
            'article_create' => route('article_create'),
            'article' => route('article'),
        ];

        $this->view->generate(
            page_name: $this->site_name,
            template_view: 'template_view.php',
            content_view: 'articles/articles_view.php',
            data: $data,
            content_css: 'articles.css',
            routes: $routes,
        );
    }

    // показать статью
    public function show(mixed $args): void
    {
        $articleId = $args['id'];
        // проверка существования id
        $articleExisted = $this->articles->exists('id', $articleId);
        if (!$articleExisted) {
            header('Location: '.route('home'));

            return;
        }

        // роуты
        $routes = [
            'home' => route('home'),
            'article' => route('article'),
            'article_show' => $this->article_show_url,
            'article_edit' => $this->article_edit_url,
            'article_remove' => route('article_remove'),
        ];

        $data['login'] = $this->auth_user;
        $data['csrf'] = $this->csrf;

        $data['article'] = $this->articles->get($articleId);
        $data['comments'] = $this->comments->getCommentsOfArticle($articleId);

        $head = '<meta name="csrf" content="'.$this->csrf.'">';
        $this->view->generate(
            page_name: "{$this->site_name}: {$data['article']['title']}",
            template_view: 'template_view.php',
            content_view: 'articles/show-article_view.php',
            data: $data,
            content_js: [
                'ServerRequest.js',
                'DBLocalTime.js',
                'article/ArticleClientController.js',
                'CommentClientController.js',
                'article/show-article.js',
            ],
            content_css: 'show-article.css',
            add_head: $head,
            routes: $routes
        );
    }

    // форма создания
    public function create(mixed $args): void
    {
        $data['login'] = $this->auth_user;
        $data['csrf'] = $this->csrf;

        // роуты
        $routes = [
            'home' => route('home'),
            'article_store' => route('article_store'),
        ];

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
            page_name: "{$this->site_name} - добавить статью",
            template_view: 'template_view.php',
            content_view: 'articles/create-article_view.php',
            data: $data,
            routes: $routes,
        );
    }

    // сохранить статью
    public function store(mixed $args): void
    {
        $title = $args['title'];
        $summary = $args['summary'];
        $content = $args['content'];
        $authorId = $this->users->getId($this->auth_user);

        if (!$this->articles->exists('title', $title)) {
            $id = $this->articles->add($authorId, $title, $summary, $content);
            $url = "{$this->article_show_url}/$id";
        } else {
            $url = route('article_create')."?error=ttlexst&title=$title";
        }

        header("Location: $url");
    }

    // форма редактирования
    public function edit(mixed $args): void
    {
        $id = $args['id'];
        $articleExisted = $this->articles->exists('id', $id);
        if (!$articleExisted) {
            header('Location: '.route('home'));

            return;
        }

        // проверка автора статьи
        $authorName = $this->articles->get($id)['author'];
        if ($authorName !== $this->auth_user) {
            header("Location: {$this->article_show_url}/$id");
        }

        // роуты
        $routes = [
            'home' => route('home'),
            'article_show' => $this->article_show_url,
            'article_update' => route('article_update'),
        ];

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

        $data['login'] = $this->auth_user;
        $data['csrf'] = $this->csrf;
        $title = $data['title'];

        $this->view->generate(
            page_name: "{$this->site_name}: $title - редактирование",
            template_view: 'template_view.php',
            content_view: 'articles/edit-article_view.php',
            data: $data,
            routes: $routes,
        );
    }

    // обновить статью
    public function update(mixed $args): void
    {
        // поиск статьи в БД
        $id = $args['id'];
        if (!$this->articles->exists('id', $id)) {
            header("Location: {$this->article_edit_url}/$id?error=system_error");
        }
        unset($args['id']);

        // поиск измененных колонок
        $articleFromDB = $this->articles->get($id);
        $columns_updated = [];
        foreach ($args as $key => $value) {
            if ($value != $articleFromDB[$key]) {
                $columns_updated[$key] = $value;
            }
        }

        // обновление данных
        if (count($columns_updated) === 0) {
            $url = "{$this->article_show_url}/$id";
        } else {
            $columns_updated['id'] = $id;
            $isUpdated = $this->articles->update($columns_updated);
            $url = $isUpdated ? "{$this->article_show_url}/$id" : "{$this->article_edit_url}/$id?error=system_error";
        }
        header("Location: $url");
    }

    // удалить статью
    public function remove(mixed $args): void
    {
        $id = $args['id'];
        $isRemoved = $this->articles->remove($id);
        $url = $isRemoved ? route('home') : "{$this->article_show_url}/$id?error=system_error";
        header("Location: $url");
    }
}
