<?php

namespace Aladser\Models;

use Aladser\Core\Model;

/** таблица пользователей */
class User extends Model
{
    /** проверить существование пользователя */
    public function exists($login): bool
    {
        return $this->db->queryPrepared(
            'select count(*) as count from users where login = :login',
            ['login' => $login]
        )['count'] == 1;
    }

    // проверка авторизации
    public function check($login, $password): bool
    {
        $passHash = $this->db->queryPrepared(
            'select password from users where login=:login',
            ['login' => $login]
        )['password'];

        return password_verify($password, $passHash);
    }

    // добавить нового пользователя
    public function add($login, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "insert into users(login, password) values('$login', '$password')";

        return $this->db->exec($sql);
    }

    // проверить уникальность никнейма
    public function isUniqueNickname($nickname): bool
    {
        $sql = 'select count(*) as count from users where user_nickname=:nickname';

        return $this->db->queryPrepared($sql, ['nickname' => $nickname])['count'] == 0;
    }

    /** получить публичное имя пользователя из ID */
    public function getPublicUsername(int $userId)
    {
        $sql = "
            select getPublicUserName(user_email, user_nickname, user_hide_email) as username 
            from users 
            where user_id = $userId
        ";

        return $this->db->query($sql)['username'];
    }

    // получить ID пользователя
    public function getUserId(string $login)
    {
        $sql = 'select id from users where login = :login';

        return $this->db->queryPrepared($sql, ['login' => $login])['id'];
    }
}
