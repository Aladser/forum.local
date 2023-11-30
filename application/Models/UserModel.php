<?php

namespace Aladser\Models;

/** класс БД таблицы пользователей */
class UserModel extends DBTableModel
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

    // список пользователей по шаблону почты или никнейма
    public function getUsers($phrase, $email)
    {
        $phrase = "%$phrase%";
        // список пользователей, подходящие по шаблону
        $sql = '
            select user_id as user, user_nickname as name, user_photo as photo 
            from users 
            where user_nickname  != \'\' and user_nickname is not null 
            and user_email != :email and user_nickname  like :phrase
            and user_email not in (select * from unhidden_emails where user_email  like :phrase)
            union 
            select user_id as user, user_email as name, user_photo as photo 
            from users 
            where user_hide_email  = 0 and user_email != :email and user_email like :phrase;
        ';

        return $this->db->queryPrepared($sql, ['email' => $email, 'phrase' => $phrase], false);
    }

    // получить пользовательские данные
    public function getUserData($email): array
    {
        $dbData = $this->db->queryPrepared(
            '
            select user_nickname, user_hide_email, user_photo 
            from users 
            where user_email = :email
            ',
            ['email' => $email],
            false
        );
        $data['user-email'] = $email;
        $data['user_nickname'] = $dbData[0]['user_nickname'];
        $data['user_hide_email'] = $dbData[0]['user_hide_email'];
        $data['user_photo'] = $dbData[0]['user_photo'];

        return $data;
    }

    // изменить пользовательские данные в Бд
    public function setUserData($data): bool
    {
        $rslt = false;
        $email = $data['user_email'];

        // запись никнейма
        $nickname = $data['user_nickname'];
        $rslt |= $this->isEqualData($nickname, 'user_nickname', $email) ?
            true :
            $this->db->exec("update users set user_nickname = '$nickname' where user_email='$email'");

        // запись скрытия почты
        $hideEmail = $data['user_hide_email'];
        $rslt |= $this->isEqualData($hideEmail, 'user_hide_email', $email) ?
            true :
            $this->db->exec("update users set user_hide_email = '$hideEmail' where user_email='$email'");

        // запись фото
        $photo = $data['user_photo'];
        $rslt |= $this->isEqualData($photo, 'user_photo', $email) ?
            true :
            $this->db->exec("update users set user_photo = '$photo' where user_email='$email'");

        return $rslt;
    }

    // сравнение новых данных и в БД
    private function isEqualData($data, $field, $email): bool
    {
        $dbData = $this->db->queryPrepared(
            "select $field from users WHERE user_email=:email",
            ['email' => $email]
        )[$field];

        return $data === $dbData;
    }
}
