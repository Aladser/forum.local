<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

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

    // --- INDEX ---
    public function index(mixed $args): void
    {
        // OFFSET
        $data['page-index'] = isset($args['list']) ? $args['list'] - 1 : 0;
        $skipArticles = $data['page-index'] * $this->articlesToPage;

        $data['articles'] = Article::skip($skipArticles)->take($this->articlesToPage)->get();
        $data['page-count'] = ceil(Article::all()->count() / $this->articlesToPage);
        $data['login'] = $this->auth_user;

        $this->view->generate(
            page_name: 'Статьи',
            template_view: 'template_view.php',
            content_view: 'articles/articles_view.php',
            data: $data,
            content_css: 'articles.css',
        );
    }

    // --- SHOW ---
    public function show(mixed $args): void
    {
        $article = Article::find($args['id']);

        $data['login'] = $this->auth_user;
        $data['csrf'] = $this->csrf;
        $data['article'] = $article;
        $data['comments'] = Comment::where('article_id', $article->id)->get();

        $head = '<meta name="csrf" content="'.$this->csrf.'">';
        $this->view->generate(
            page_name: $article->title,
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
        );
    }

    // --- CREATE ---
    public function create(mixed $args): void
    {
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
            page_name: 'Добавить статью',
            template_view: 'template_view.php',
            content_view: 'articles/create-article_view.php',
            data: $data,
        );
    }

    // --- STORE ---
    public function store(mixed $args): void
    {
        $params = [
            'title' => $args['title'],
            'summary' => $args['summary'],
            'content' => $args['content'],
            'author_id' => User::where('login', $this->auth_user)->first()->id,
        ];
        Article::insert($params);

        header('Location: /article/show/'.Article::max('id'));
    }

    // --- EDIT ---
    public function edit(mixed $args): void
    {
        $authuser = User::where('login', $this->auth_user)->first();
        $data['article'] = Article::findOr($args['id'], function () {
            header("Location: $this->home_url");
        });

        $author = User::find($data['article']->author_id);
        // проверка автора статьи
        if ($author != $authuser) {
            header("Location: /article/show/$id");
        }

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

        $this->view->generate(
            page_name: 'Изменить запись',
            template_view: 'template_view.php',
            content_view: 'articles/edit-article_view.php',
            data: $data,
        );
    }

    // --- UPDATE ---
    public function update(mixed $args): void
    {
        Article::where('id', $args['id'])->update(['title' => $args['title'], 'summary' => $args['summary'], 'content' => $args['content']]);

        header('Location: /article/show/'.$args['id']);
    }

    // --- REMOVE ---
    public function remove(mixed $args): void
    {
        $isRemoved = Article::where('id', $args['id'])->delete();
        $url = $isRemoved ? '/' : "/article/show/{$args['id']}?error=system_error";
        header("Location: $url");
    }

    // --- ПОДТВЕРЖДЕНИЕ УДАЛЕНИЯ ---
    public function removeConfirm(mixed $args): void
    {
        $this->view->generate(
            page_name: 'Подтверждение удаления статьи',
            template_view: 'template_view.php',
            content_view: 'articles/article-confirm-delete_view.php',
            data: ['article' => Article::find($args['id']), 'csrf' => $this->csrf],
        );
    }
}
