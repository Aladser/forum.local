<?php

namespace App\Models;

use App\Core\Model;

/** таблица статей */
class Article extends Model
{
    // список статей
    public function all()
    {
        $sql = 'select articles.id as id, login, title, summary, content from articles join users on articles.author_id = users.id';

        return $this->dbQuery->query($sql, false);
    }

    // список части статей
    public function get_chunk_of_articles(int $limit, int $offset)
    {
        $sql = "select articles.id as id, login as author, title, summary, content from articles join users on articles.author_id = users.id limit $limit offset $offset";

        return $this->dbQuery->query($sql, false);
    }

    // информация о статье
    public function get_article($id)
    {
        $sql = "select articles.id as id,title,summary,content,login as username, time from articles join users on users.id=articles.author_id where articles.id = $id";

        return $this->dbQuery->query($sql);
    }

    // добавить статью
    public function add($author, $title, $summary, $content): bool
    {
        $sql = "insert into articles(author_id, title, summary, content) values('$author', '$title', '$summary', '$content')";

        return $this->dbQuery->exec($sql) == 1;
    }

    // обновить статью
    public function update($id, $title, $summary, $content): bool
    {
        $sql = "update articles set title = '$title', summary = '$summary', content = '$content' where id = $id";

        return $this->dbQuery->exec($sql) == 1;
    }

    // удалить статью
    public function remove($id): bool
    {
        $sql = "delete from articles where id = $id";

        return $this->dbQuery->exec($sql) == 1;
    }

    /** проверка существования заголовока статьи */
    public function exists($fieldName, $value): bool
    {
        $sql = "select count(*) as count from articles where $fieldName = :field";

        return $this->dbQuery->queryPrepared($sql, ['field' => $value])['count'] === 1;
    }

    /** число записей */
    public function count()
    {
        $sql = 'select count(*) as count from articles';

        return $this->dbQuery->query($sql)['count'];
    }
}
