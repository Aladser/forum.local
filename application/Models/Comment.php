<?php

namespace Aladser\Models;

use Aladser\Core\Model;

/** таблица комментариев */
class Comment extends Model
{
    // список комментариев статьи
    public function all($id)
    {
        return $this->db->query('select * from articles', false);
    }

    // добавляет комментарий
    public function add($author, $content)
    {
        return $this->db->exec("insert into articles(author_id, title, summary, content) values($author, $title, $summary, $content)") == 1;
    }

    // удаляет комментарий
    public function remove($id)
    {
        return $this->db->exec("delete from articles where id = $id") == 1;
    }
}
