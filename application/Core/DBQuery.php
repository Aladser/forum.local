<?php

namespace App\Core;

use PDO;

/** Класс запросов в БД на основе PDO */
class DBQuery
{
    private $dbConnection;
    private string $host;
    private string $nameDB;
    private string $userDB;
    private string $passwordDB;

    public function __construct($host, $nameDB, $userDB, $passwordDB)
    {
        $this->host = $host;
        $this->nameDB = $nameDB;
        $this->userDB = $userDB;
        $this->passwordDB = $passwordDB;
    }

    /** соединение с БД */
    private function connect()
    {
        try {
            $this->dbConnection = new \PDO(
                "mysql:dbname=$this->nameDB; host=$this->host",
                $this->userDB,
                $this->passwordDB
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /** отсоединение от БД */
    private function disconnect()
    {
        $this->dbConnection = null;
    }

    /** insert операции */
    public function insert(string $sql, array $args): int
    {
        $this->connect();
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($args);
        $id = $this->dbConnection->lastInsertId();
        $this->disconnect();

        return $id;
    }

    /** update операции */
    public function update(string $sql, array $args): bool
    {
        $this->connect();
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($args);
        $rowCount = $stmt->rowCount();
        $this->disconnect();

        return $rowCount > 0;
    }

    /** delete операции */
    public function delete(string $sql, array $args): bool
    {
        return $this->update($sql, $args);
    }

    /** выполняет подготовленный запрос
     * @param bool $isOneValue одно или множество запрашиваемых полей
     *
     * @return mixed массив строк или одно значение
     */
    public function queryPrepared(string $sqlExpession, array $arguments = null, bool $isOneValue = true)
    {
        $this->connect();

        $stmt = $this->dbConnection->prepare($sqlExpession);
        if (!empty($arguments)) {
            $stmt->execute($arguments);
        } else {
            $stmt->execute();
        }

        $this->disconnect();

        return $isOneValue ? $stmt->fetch(\PDO::FETCH_ASSOC) : $stmt->fetchAll();
    }

    /** выполняет запрос
     * @param string $sql        запрос
     * @param bool   $isOneValue одно или множество запрашиваемых полей
     *
     * @return mixed массив строк или одно значение
     */
    public function query(string $sql, bool $isOneValue = true)
    {
        $this->connect();
        $query = $this->dbConnection->query($sql);
        $this->disconnect();

        return $isOneValue ? $query->fetch(\PDO::FETCH_ASSOC) : $query->fetchAll();
    }

    /** выполняет изменения данных.
     * @param string $sql запрос
     *
     * @return false|int число измененных строк
     */
    public function exec(string $sql)
    {
        $this->connect();
        $numRows = $this->dbConnection->exec($sql);
        $this->disconnect();

        return $numRows;
    }

    /** выполняет процедуру с возвращаемым результатом
     * @param mixed $sql выражение
     * @param mixed $out выходная переменная, куда будет возвращен результат
     */
    public function executeProcedure($sql, $out)
    {
        $this->connect();
        $stmt = $this->dbConnection->prepare("call $sql");
        $stmt->execute();
        $stmt->closeCursor();
        $procRst = $this->dbConnection->query("select $out as info");
        $this->disconnect();

        return $procRst->fetch(\PDO::FETCH_ASSOC)['info'];
    }
}
