<?php

namespace App\Core;

class Model
{
    protected DBQuery $dbQuery;

    public function __construct()
    {
        $this->dbQuery = new DBQuery(env('HOST_DB'), env('NAME_DB'), env('USER_DB'), env('PASS_DB'), env('DB_TYPE'));
    }
}
