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

    public function add($author, $title, $summary, $content)
    {
        return $this->db->exec("insert into articles(author_id, title, summary, content) values($author, $title, $summary, $content)") == 1;
    }
}
