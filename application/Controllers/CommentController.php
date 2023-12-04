<?php

namespace Aladser\Controllers;

use Aladser\Core\Controller;
use Aladser\Core\DBCtl;

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

        $id = $this->comments->add($authorId, $articleId, $content);
        echo json_encode([
            'result' => $id,
            'comment' => ['author' => $author, 'content' => $content, 'id' => $id],
        ]);
    }

    public function remove()
    {
        $id = $_POST['id'];
        $isRemoved = $this->comments->remove($id);
        echo json_encode(['result' => (int) $isRemoved]);
    }
}
