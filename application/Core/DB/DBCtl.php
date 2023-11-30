<?php

namespace Aladser\Core\DB;

use Aladser\Models\Article;
use Aladser\Models\Comment;
use Aladser\Models\User;

/** Класс модели таблицы БД */
class DBCtl
{
    private DBQueryClass $dbQueryCtl;

    public function __construct($dbAddr, $dbName, $dbUser, $dbPassword)
    {
        $this->dbQueryCtl = new DBQueryClass($dbAddr, $dbName, $dbUser, $dbPassword);
    }

    /** Пользователи */
    public function getUsers(): User
    {
        return new User($this->dbQueryCtl);
    }

    /** Статьи */
    public function getArticles(): Article
    {
        return new Article($this->dbQueryCtl);
    }

    /** Комментарии */
    public function getComments(): Comment
    {
        return new Comment($this->dbQueryCtl);
    }
}
