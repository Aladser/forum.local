<?php

namespace Aladser\Controllers;

use Aladser\Core\Controller;
use Aladser\Core\DB\DBCtl;

/** комментарии */
class CommentController extends Controller
{
    public function __construct(DBCtl $dbCtl = null)
    {
        parent::__construct($dbCtl);
        $this->articles = $dbCtl->getArticles();
        $this->users = $dbCtl->getUsers();
        $this->comments = $dbCtl->getComments();
    }

    public function store()
    {
        $author = $_POST['author'];
        $authorId = $this->users->getId($author);
        $articleId = $_POST['article'];
        $content = $_POST['message'];

        echo json_encode([
            'result' => (int) $this->comments->add($authorId, $articleId, $content),
            'comment' => ['author' => $author, 'content' => $content],
        ]);
    }

    public function remove()
    {
        var_dump($_POST);
    }
}
