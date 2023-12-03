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

    // список статей
    public function get_chunk_of_articles(int $limit, int $offset)
    {
        $sql = "select articles.id as id, login, title, summary, content from articles join users on articles.author_id = users.id limit $limit offset $offset";

        return $this->db->query($sql, false);
    }

    // информация о статье
    public function get_article($id)
    {
        $sql = "select articles.id as id,title,summary,content,login as username, time from articles join users on users.id=articles.author_id where articles.id = $id";

        return $this->db->query($sql);
    }

    // добавить статью
    public function add($author, $title, $summary, $content): bool
    {
        $sql = "insert into articles(author_id, title, summary, content) values($author, $title, $summary, $content)";

        return $this->db->exec($sql) == 1;
    }

    // обновить статью
    public function update($id, $title, $summary, $content): bool
    {
        $sql = "update articles set title = '$title', summary = '$summary', content = '$content' where id = $id";

        return $this->db->exec($sql) == 1;
    }

    // удалить статью
    public function remove($id): bool
    {
        $sql = "delete from articles where id = $id";

        return $this->db->exec($sql) == 1;
    }

    /** проверка существования заголовока статьи */
    public function title_exsists($title): bool
    {
        $sql = 'select count(*) as count from articles where title = :title';

        return $this->db->queryPrepared($sql, ['title' => $title])['count'] == 1;
    }

    /** число записей */
    public function count()
    {
        $sql = 'select count(*) as count from articles';

        return $this->db->query($sql)['count'];
    }
}
