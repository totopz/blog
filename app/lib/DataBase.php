<?php

class DataBase
{
    /**
     * @var DataBase
     */
    private static $instance;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * DataBase constructor.
     */
    private function __construct()
    {
        $app = \Slim\Slim::getInstance();

        $databaseConfig = $app->config('database');

        $dsn = 'mysql:dbname=' . $databaseConfig['name'] . ';host=' . $databaseConfig['host'];
        $user = $databaseConfig['user'];
        $password = $databaseConfig['password'];

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
    }

    /**
     * Get database instance
     *
     * @return DataBase
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get only first value from the first row of the SQL result
     *
     * @param string $sql
     * @param array $params
     * @throws \InvalidArgumentException
     * @return string|false
     */
    public function getOne($sql, array $params = [])
    {
        if (is_string($sql) == false || empty($sql)) {
            throw new \InvalidArgumentException('Invalid or empty SQL passed');
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Get first row of the SQL result
     *
     * @param string $sql
     * @param array $params
     * @throws \InvalidArgumentException
     * @return array|false
     */
    public function getRow($sql, array $params = [])
    {
        if (is_string($sql) == false || empty($sql)) {
            throw new \InvalidArgumentException('Invalid or empty SQL passed');
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch();
    }

    /**
     * Get all rows of the SQL result
     *
     * @param string $sql
     * @param array $params
     * @throws \InvalidArgumentException
     * @return array
     */
    public function getAll($sql, array $params = [])
    {
        if (is_string($sql) == false || empty($sql)) {
            throw new \InvalidArgumentException('Invalid or empty SQL passed');
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * Insert record
     *
     * @param string $table
     * @param array $params
     * @throws \InvalidArgumentException
     * @return int
     */
    public function insert($table, array $params)
    {
        if (is_string($table) == false || empty($table)) {
            throw new \InvalidArgumentException('Invalid or empty table passed');
        }

        $fields = [];
        $values = [];

        foreach ($params as $field => $value) {
            $fields[] = '`' . $field . '`';
            $values[] = $value;
        }

        $sql  = 'INSERT INTO `' . $table . '` (' . implode(', ', $fields) . ')';
        $sql .= ' VALUES (' . implode(', ', array_fill(0, count($values), '?')) . ')';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);

        return $this->pdo->lastInsertId();
    }

    /**
     * @param string $table
     * @param array $where
     * @param array $params
     * @throws \InvalidArgumentException
     * @return void
     */
    public function update($table, array $where = [], array $params = [])
    {
        if (is_string($table) == false || empty($table)) {
            throw new \InvalidArgumentException('Invalid or empty table passed');
        }

        $fields = [];
        $values = [];

        foreach ($params as $field => $value) {
            $fields[] = '`' . $field . '` = ?';
            $values[] = $value;
        }

        $sql  = 'UPDATE `' . $table . '` SET ';
        $sql .= implode(', ', $fields);

        if (count($where) > 0) {
            $sql .= ' WHERE ';

            $whereFields = [];

            foreach ($where as $field => $value) {
                $whereFields[] = '`' . $field . '` = ?';
                $values[] = $value;
            }

            $sql .= implode(' AND ', $whereFields);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
    }

    /**
     * @param string $table
     * @param array $where
     * @throws \InvalidArgumentException
     * @return void
     */
    public function delete($table, array $where = [])
    {
        if (is_string($table) == false || empty($table)) {
            throw new \InvalidArgumentException('Invalid or empty table passed');
        }

        $sql  = 'DELETE FROM `' . $table . '`';

        $values = [];

        if (count($where) > 0) {
            $sql .= ' WHERE ';

            $whereFields = [];

            foreach ($where as $field => $value) {
                $whereFields[] = '`' . $field . '` = ?';
                $values[] = $value;
            }

            $sql .= implode(' AND ', $whereFields);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
    }
}
