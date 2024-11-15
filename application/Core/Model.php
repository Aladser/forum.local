<?php

namespace App\Core;

class Model
{
    protected DBQuery $dbQuery;

    public function __construct()
    {
        $this->dbQuery = new DBQuery(env('DB_HOST'), env('DB_NAME'), env('DB_USER'), env('DB_PASSWORD'), env('DB_DRIVER'));
    }
}
