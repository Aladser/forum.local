<?php

namespace Aladser\Core\DB;

use Aladser\Models\Article;
use Aladser\Models\UserModel;

/** Класс модели таблицы БД */
class DBCtl
{
    private DBQueryClass $dbQueryCtl;

    public function __construct($dbAddr, $dbName, $dbUser, $dbPassword)
    {
        $this->dbQueryCtl = new DBQueryClass($dbAddr, $dbName, $dbUser, $dbPassword);
    }

    /** Таблица пользователей */
    public function getUsers(): UserModel
    {
        return new UserModel($this->dbQueryCtl);
    }

    public function getArticle(): Article
    {
        return new Article($this->dbQueryCtl);
    }
}
