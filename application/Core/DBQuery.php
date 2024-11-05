<?php

namespace App\Core;

use PDO;

/** Класс запросов в БД на основе PDO */
class DBQuery
{
    private string $host;
    private string $nameDB;
    private string $userDB;
    private string $passwordDB;
    private string $db_type;

    private $isPermanentConnection;
    private $dbConnection;
    // массив поддерживаемых СУБД
    private static $DB_TYPE = ['mysql', 'pgsql', 'mssql', 'sqlite', 'sybase'];

    /**
     * @param string $host                  хост
     * @param string $nameDB                имя бд
     * @param string $userDB                пользователь
     * @param string $passwordDB            пароль
     * @param string $db_type               тип БД: mysql, pgsql, mssql, sqlite, sybase
     * @param bool   $isPermanentConnection флаг постоянного подключения
     */
    public function __construct(string $host, string $nameDB, string $userDB, string $passwordDB, string $db_type, bool $isPermanentConnection = false)
    {
        if (!in_array($db_type, DBQuery::$DB_TYPE)) {
            throw new \Exception("указанный тип БД ($db_type) не поддерживается");
        }

        $this->host = $host;
        $this->nameDB = $nameDB;
        $this->userDB = $userDB;
        $this->passwordDB = $passwordDB;
        $this->db_type = $db_type;
        $this->isPermanentConnection = $isPermanentConnection;

        if ($isPermanentConnection) {
            $this->connect();
        }
    }

    /** подключение к БД */
    private function connect()
    {
        try {
            $this->dbConnection = new \PDO(
                "$this->db_type:dbname=$this->nameDB; host=$this->host",
                $this->userDB,
                $this->passwordDB
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /** отключение от БД */
    private function disconnect()
    {
        $this->dbConnection = null;
    }

    /** insert операции */
    public function insert(string $sql, array $args): int
    {
        if (!$this->isPermanentConnection) {
            $this->connect();
        }

        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($args);
        $id = $this->dbConnection->lastInsertId();

        if (!$this->isPermanentConnection) {
            $this->disconnect();
        }

        return $id;
    }

    /** update операции */
    public function update(string $sql, array $args): bool
    {
        if (!$this->isPermanentConnection) {
            $this->connect();
        }

        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($args);
        $rowCount = $stmt->rowCount();

        if (!$this->isPermanentConnection) {
            $this->disconnect();
        }

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
    public function queryPrepared(string $sqlExpession, ?array $arguments = null, bool $isOneValue = true)
    {
        if (!$this->isPermanentConnection) {
            $this->connect();
        }

        $stmt = $this->dbConnection->prepare($sqlExpession);
        if (!empty($arguments)) {
            $stmt->execute($arguments);
        } else {
            $stmt->execute();
        }

        if (!$this->isPermanentConnection) {
            $this->disconnect();
        }

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
        if (!$this->isPermanentConnection) {
            $this->connect();
        }

        $query = $this->dbConnection->query($sql);

        if (!$this->isPermanentConnection) {
            $this->disconnect();
        }

        return $isOneValue ? $query->fetch(\PDO::FETCH_ASSOC) : $query->fetchAll();
    }

    /** выполняет изменения данных.
     * @param string $sql запрос
     *
     * @return false|int число измененных строк
     */
    public function exec(string $sql)
    {
        if (!$this->isPermanentConnection) {
            $this->connect();
        }

        $numRows = $this->dbConnection->exec($sql);

        if (!$this->isPermanentConnection) {
            $this->disconnect();
        }

        return $numRows;
    }

    /** выполняет процедуру с возвращаемым результатом
     * @param mixed $sql выражение
     * @param mixed $out выходная переменная, куда будет возвращен результат
     */
    public function executeProcedure($sql, $out)
    {
        if (!$this->isPermanentConnection) {
            $this->connect();
        }

        $stmt = $this->dbConnection->prepare("call $sql");
        $stmt->execute();
        $stmt->closeCursor();
        $procRst = $this->dbConnection->query("select $out as info");

        if (!$this->isPermanentConnection) {
            $this->disconnect();
        }

        return $procRst->fetch(\PDO::FETCH_ASSOC)['info'];
    }
}
