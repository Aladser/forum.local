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

    // список статей
    public function get_article($id)
    {
        $sql = "select * from articles where id = $id";

        return $this->db->query($sql);
    }

    public function add($author, $title, $summary, $content)
    {
        return $this->db->exec("insert into articles(author_id, title, summary, content) values($author, $title, $summary, $content)") == 1;
    }

    public function update($id, $author, $title, $summary, $content)
    {
        return $this->db->exec("update articles set author = $author, title = $title, summary = $summary, content = $content where id = $id") == 1;
    }

    public function remove($id)
    {
        return $this->db->exec("delete from articles where id = $id") == 1;
    }
}
