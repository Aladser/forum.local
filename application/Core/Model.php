<?php

namespace App\Core;

/** Класс модели таблицы БД */
class Model
{
    protected DBQueryClass $db;

    public function __construct(DBQueryClass $db)
    {
        $this->db = $db;
    }
}
