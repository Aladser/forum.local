<?php

namespace Aladser\Models;

/** класс БД таблицы пользователей */
class Article extends DBTableModel
{
    // список статей
    public function all()
    {
        $sql = 'select * from articles';

        return $this->db->query($sql, false);
    }
}
