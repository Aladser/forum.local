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
    public function is_correct_password($login, $password): bool
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

    // получить ID пользователя
    public function getId(string $login)
    {
        $sql = 'select id from users where login = :login';

        return $this->db->queryPrepared($sql, ['login' => $login])['id'];
    }
}
