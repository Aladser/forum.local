<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use Illuminate\Database\Capsule\Manager;

use function App\Core\route;

/** статьи */
class ArticleController extends Controller
{
    private string $csrf;
    private string $auth_user;

    public function __construct(int $articlesToPage = 5)
    {
        parent::__construct();
        $this->auth_user = UserController::getAuthUser();
        $this->csrf = Controller::createCSRFToken();
        $this->articlesToPage = $articlesToPage;
    }

    // список статей
    public function index(mixed $args): void
    {
        // OFFSET
        $data['page-index'] = isset($args['list']) ? $args['list'] - 1 : 0;
        $skipArticles = $data['page-index'] * $this->articlesToPage;

        $data['articles'] = Article::skip($skipArticles)->take($this->articlesToPage)->get();
        $data['page-count'] = Article::all()->count() / $this->articlesToPage;
        $data['login'] = $this->auth_user;

        $this->view->generate(
            page_name: 'Статьи',
            template_view: 'template_view.php',
            content_view: 'articles/articles_view.php',
            data: $data,
            content_css: 'articles.css',
        );
    }

    // показать статью
    public function show(mixed $args): void
    {
        $test = Article::find(1);
        var_dump($test);

        $data['login'] = $this->auth_user;
        $data['csrf'] = $this->csrf;
        $data['article'] = $article;
        $data['article']->author = Manager::table('users')->where('id', $article->author_id)->first();
        $data['comments'] = $this->comments->getCommentsOfArticle($article->id);

        // роуты
        $routes = [
            'home' => $this->home_url,
            'article_edit' => "$this->article_edit_url/$article->id",
            'article_remove' => route('article_remove')."/$article->id",
        ];

        $head = '<meta name="csrf" content="'.$this->csrf.'">';
        $this->view->generate(
            page_name: "{$this->site_name}: {$article->title}",
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
            'home' => $this->home_url,
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
            $url = "{$this->article_create_url}?error=ttlexst&title=$title";
        }

        header("Location: $url");
    }

    // форма редактирования
    public function edit(mixed $args): void
    {
        $id = $args['id'];
        $articleExisted = $this->articles->exists('id', $id);
        if (!$articleExisted) {
            header("Location: $this->home_url");

            return;
        }

        // проверка автора статьи
        $authorName = $this->articles->get($id)['author'];
        if ($authorName !== $this->auth_user) {
            header("Location: {$this->article_show_url}/$id");
        }

        // роуты
        $routes = [
            'home' => $this->home_url,
            'article_show' => $this->article_show_url,
            'article_update' => route('article_update'),
        ];

        // данные о статье
        $data = $this->articles->get($id);
        $data['show_url'] = "$this->article_show_url/$id";

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
        $url = $isRemoved ? $this->home_url : "{$this->article_show_url}/$id?error=system_error";
        header("Location: $url");
    }
}
