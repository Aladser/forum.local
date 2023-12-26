<?php

namespace App\Models;

use App\Core\Model;

/** таблица комментариев */
class Comment extends Model
{
    // добавляет комментарий
    public function add($authorId, $articleId, $content)
    {
        return $this->db->insert("insert into comments(author_id, article_id, content) values($authorId, $articleId, '$content')");
    }

    // удаляет комментарий
    public function remove($id)
    {
        return $this->db->exec("delete from comments where id = $id") == 1;
    }

    // список комментариев статьи
    public function getCommentsOfArticle($articleId)
    {
        return $this->db->query("select comments.id as id, login, content, time from comments join users on users.id=comments.author_id where article_id = $articleId order by time", false);
    }

    // удалить комментарии статьи
    public function removeCommentsOfArticle($articleId)
    {
        return $this->db->exec("delete from comments where article_id = $articleId") > 0;
    }
}
