<?php

namespace Aladser\Core\DB;

use Aladser\Models\ConnectionsDBTableModel;
use Aladser\Models\ContactsDBTableModel;
use Aladser\Models\MessageDBTableModel;
use Aladser\Models\UserModel;

/** Класс модели таблицы БД */
class DBCtl
{
    private DBQueryClass $dbQueryCtl;

    public function __construct($dbAddr, $dbName, $dbUser, $dbPassword)
    {
        $this->dbQueryCtl = new DBQueryClass($dbAddr, $dbName, $dbUser, $dbPassword);
    }

    /** Возвращает таблицу пользователей.
     * @return UsersDBTableModel
     */
    public function getUsers(): UserModel
    {
        return new UserModel($this->dbQueryCtl);
    }

    /** Возвращает таблицу контактов.
     */
    public function getContacts(): ContactsDBTableModel
    {
        return new ContactsDBTableModel($this->dbQueryCtl);
    }

    /** Возвращает таблицу соединений.
     */
    public function getConnections(): ConnectionsDBTableModel
    {
        return new ConnectionsDBTableModel($this->dbQueryCtl);
    }

    /** Возвращает таблицу сообщений.
     */
    public function getMessageDBTable(): MessageDBTableModel
    {
        return new MessageDBTableModel($this->dbQueryCtl);
    }
}
