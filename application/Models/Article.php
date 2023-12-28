<?php

namespace App\Models;

use App\Core\Model;

/** таблица статей */
class Article extends Model
{
    public function exists($fieldName, $value): bool
    {
        $sql = "select count(*) as count from articles where $fieldName = :field";
        $args = ['field' => $value];
        $isExisted = $this->dbQuery->queryPrepared($sql, $args)['count'] === 1;

        return $isExisted;
    }

    public function all()
    {
        $sql = 'select articles.id as id, login, title, summary, content ';
        $sql .= 'from articles join users on articles.author_id = users.id order by';
        $articles = $this->dbQuery->queryPrepared(sql: $sqlExpession, isOneValue: false);

        return $articles;
    }

    // список(chunk) части статей
    public function get_chunk_of_articles(int $limit, int $offset)
    {
        $sql = 'select articles.id as id, login as author, title, summary, content from articles ';
        $sql .= "join users on articles.author_id = users.id order by title limit $limit offset $offset ";

        return $this->dbQuery->query($sql, false);
    }

    // информация о статье
    public function get($id)
    {
        $sql = 'select articles.id as id, title, summary, content, login as username, time from articles ';
        $sql .= 'join users on users.id=articles.author_id where articles.id = :id';
        $args = [':id' => $id];
        $article = $this->dbQuery->queryPrepared($sql, $args);

        return $article;
    }

    // добавить статью
    public function add($author, $title, $summary, $content)
    {
        $sql = 'insert into articles(author_id, title, summary, content) values(:author, :title, :summary, :content)';
        $args = [':author' => $author, ':title' => $title, ':summary' => $summary, ':content' => $content];
        $id = $this->dbQuery->insert($sql, $args);

        return $id;
    }

    public function update($id, $title, $summary, $content): bool
    {
        $sql = 'update articles set title = :title, summary = :summary, content = :content where id = :id';
        $args = [':title' => $title, ':summary' => $summary, ':content' => $content, ':id' => $id];

        return $this->dbQuery->update($sql, $args);
    }

    public function remove($id): bool
    {
        $sql = 'delete from articles where id = :id';
        $args = [':id' => $id];

        return $this->dbQuery->delete($sql, $args);
    }

    /** число записей */
    public function count()
    {
        $sql = 'select count(*) as count from articles';

        return $this->dbQuery->query($sql)['count'];
    }
}
