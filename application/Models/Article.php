<?php

namespace Aladser\Models;

use Aladser\Core\Model;

/** таблица статей */
class Article extends Model
{
    // список статей
    public function all()
    {
        $sql = 'select articles.id as id, login, title, summary, content from articles join users on articles.author_id = users.id';

        return $this->db->query($sql, false);
    }

    // информация о статье
    public function get_article($id)
    {
        $sql = "select articles.id as id,title,summary,content,login as username, time from articles join users on users.id=articles.author_id where articles.id = $id";

        return $this->db->query($sql);
    }

    // добавить статью
    public function add($author, $title, $summary, $content)
    {
        return $this->db->exec("insert into articles(author_id, title, summary, content) values($author, $title, $summary, $content)") == 1;
    }

    // обновить статью
    public function update($id, $title, $summary, $content)
    {
        return $this->db->exec("update articles set title = '$title', summary = '$summary', content = '$content' where id = $id") == 1;
    }

    // удалить статью
    public function remove($id)
    {
        return $this->db->exec("delete from articles where id = $id") == 1;
    }
}
