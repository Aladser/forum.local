<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Comment;
use App\Services\UserService;

/** комментарии */
class CommentController extends Controller
{
    private $authuser;

    public function __construct()
    {
        $this->authuser = UserService::getAuthUser();
    }

    // сохранить комментарий
    public function store(mixed $args)
    {
        $params = [
            'author_id' => $this->authuser->id,
            'article_id' => $args['article_id'],
            'content' => $args['content'],
        ];
        Comment::insert($params);

        echo json_encode([
            'author' => $this->authuser->login,
            'id' => Comment::max('id'),
            'content' => $args['content'],
            'CSRF' => UserService::CSRF(),
        ]);
    }

    // удалить комментарий
    public function remove(mixed $args)
    {
        $comment = Comment::where('id', $args['id']);
        if ($this->authuser != $comment->first()->author) {
            echo json_encode(['result' => 403]);
        }
        echo json_encode(['result' => $comment->delete()]);
    }
}
