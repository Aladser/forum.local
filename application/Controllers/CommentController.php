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
        $this->user = $dbCtl->getUsers();
        $this->comments = $dbCtl->getComments();
    }

    public function store()
    {
        var_dump($_POST);
    }

    public function remove()
    {
        var_dump($_POST);
    }
}
