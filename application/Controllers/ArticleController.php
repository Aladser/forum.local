<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Services\UserService;

/** статьи */
class ArticleController extends Controller
{
    private string $csrf;
    private string $auth_user;

    public function __construct(int $articlesToPage = 5)
    {
        parent::__construct();
        $this->articlesToPage = $articlesToPage;
    }

    // --- INDEX ---
    public function index(mixed $args): void
    {
        // OFFSET
        $data['page-index'] = isset($args['list']) ? $args['list'] - 1 : 0;
        $skipArticles = $data['page-index'] * $this->articlesToPage;
        $data['articles'] = Article::skip($skipArticles)->take($this->articlesToPage)->orderBy('time', 'desc')->get();
        $data['page-count'] = ceil(Article::all()->count() / $this->articlesToPage);

        $this->render(
            page_name: 'Статьи',
            template_view: 'template_view.php',
            content_view: 'articles/articles_view.php',
            content_css: 'articles.css',
            data: $data,
        );
    }

    // --- SHOW ---
    public function show(mixed $args): void
    {
        $data['article'] = Article::find($args['id']);
        $data['comments'] = Comment::where('article_id', $data['article']->id)->get();

        $this->render(
            page_name: 'Статья "'.$data['article']->title.'"',
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
        );
    }

    // --- CREATE ---
    public function create(mixed $args): void
    {
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

        $this->render(
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
            'author_id' => UserService::getAuthUser()->id,
        ];
        Article::insert($params);

        self::redirect('/article/show/'.Article::max('id'));
    }

    // --- EDIT ---
    public function edit(mixed $args): void
    {
        $data['article'] = Article::find($args['id']);
        // проверка автора статьи
        if ($data['article']->author != UserService::getAuthUser()) {
            $data['access_error'] = 'Нет доступа';
        } else {
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
        }

        $this->render(
            page_name: 'Изменить запись',
            template_view: 'template_view.php',
            content_view: 'articles/edit-article_view.php',
            data: $data,
        );
    }

    // --- UPDATE ---
    public function update(mixed $args): void
    {
        $article = Article::where('id', $args['id']);
        $article->update(['title' => $args['title'], 'summary' => $args['summary'], 'content' => $args['content']]);
        self::redirect('/article/show/'.$args['id']);
    }

    // --- REMOVE ---
    public function remove(mixed $args): void
    {
        Article::where('id', $args['id'])->delete();
        self::redirect('/');
    }

    // --- ПОДТВЕРЖДЕНИЕ УДАЛЕНИЯ ---
    public function removeConfirm(mixed $args): void
    {
        $this->render(
            page_name: 'Подтверждение удаления статьи',
            template_view: 'template_view.php',
            content_view: 'articles/article-confirm-delete_view.php',
            data: ['article' => Article::find($args['id'])],
        );
    }
}
