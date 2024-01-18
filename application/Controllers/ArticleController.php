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
        // url отдельных страниц
        $showArticleURL = route('article_show');
        for ($i = 0; $i < count($data['articles']); ++$i) {
            $id = $data['articles'][$i]['id'];
            $data['articles'][$i]['url'] = "$showArticleURL/$id";
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
            header('Location: /');

            return;
        }

        // роуты
        $routes = [
            'home' => route('home'),
            'article' => route('article'),
            'article_show' => route('article_show'),
            'article_edit' => route('article_edit'),
            'article_remove' => route('article_remove'),
        ];

        $data['login'] = $this->authUser;
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
        $data['login'] = $this->authUser;
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
        $authorName = $this->articles->get($id)['author'];
        if ($authorName !== $this->authUser) {
            header('Location: /article/show/'.$id);
        }

        // роуты
        $routes = [
            'home' => route('home'),
            'article_show' => route('article_show'),
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

        $data['login'] = $this->authUser;
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
        $id = $args['id'];
        if (!$this->articles->exists('id', $id)) {
            header("Location: edit/$id?error=system_error");
        }
        unset($args['id']);

        $articleFromDB = $this->articles->get($id);
        // поиск измененных колонок
        $columns_updated = [];
        foreach ($args as $key => $value) {
            if ($value != $articleFromDB[$key]) {
                $columns_updated[$key] = $value;
            }
        }

        if (count($columns_updated) === 0) {
            $url = "show/$id";
        } else {
            $columns_updated['id'] = $id;
            $isUpdated = $this->articles->update($columns_updated);
            $url = $isUpdated ? "show/$id" : "edit/$id?error=system_error";
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
