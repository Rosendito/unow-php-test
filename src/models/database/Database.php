<?php

namespace App\Models\Database;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    /**
     * Database host.
     *
     * @var string
     */
    private string $host;

    /**
     * Database name.
     *
     * @var string
     */
    private string $dbname;

    /**
     * Database user.
     *
     * @var string
     */
    private string $user;
    
    /**
     * Database password.
     *
     * @var string
     */
    private string $password;

    /**
     * Database handler.
     *
     * @var PDO
     */
    private PDO $handler;

    /**
     * Current statement.
     *
     * @var PDOStatement
     */
    private PDOStatement $statement;

    public function __construct()
    {
        $this->setDSNFromEnv();
        $this->setHandler();
    }

    /**
     * Set database dsn properties from environment vars.
     *
     * @return void
     */
    public function setDSNFromEnv(): void
    {
        $this->host = env('DB_HOST');
        $this->dbname = env('DB_DATABASE');
        $this->user = env('DB_USERNAME');
        $this->password = env('DB_PASSWORD');
    }

    /**
     * Set database handler (PDO)
     *
     * @return void
     */
    public function setHandler(): void
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        try {
            $this->handler = new PDO(
                $dsn,
                $this->user,
                $this->password,
                $options
            );
        } catch (PDOException $error) {
            error_log('Error during PDO init. Message: ' . $error->getMessage());
            die($error);
        }
    }

    /**
     * Prepare query.
     *
     * @param string $query
     * @return void
     */
    public function prepare(string $query): void
    {
        $this->statement = $this->handler->prepare($query);
    }

    /**
     * Get bind value type.
     *
     * @param mixed $value
     * @return integer
     */
    public function getBindValueType(mixed $value): int
    {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
            case is_null($value):
                $type= PDO::PARAM_NULL;
            default:
                $type = PDO::PARAM_STR;
        }

        return $type;
    }

    /**
     * Bind value to the current statement.
     *
     * @param string $param
     * @param mixed $value
     * @return void
     */
    public function bindValue(string $param, mixed $value): void
    {
        $this->statement->bindValue(
            $param,
            $value,
            $this->getBindValueType($value)
        );
    }

    /**
     * Bind param to the current statement.
     *
     * @param string $param
     * @param mixed $value
     * @return void
     */
    public function bindParam(string $param, mixed $value): void
    {
        $this->statement->bindParam(
            $param,
            $value,
            $this->getBindValueType($value)
        );
    }

    /**
     * Execute the current statement.
     *
     * @return void
     */
    public function execute(): void
    {
        $this->statement->execute();
    }

    /**
     * Select statement.
     *
     * @param string $table
     * @param string $fields
     * @param string $where
     * @param array $whereValues
     * @param string $aditional
     * @return self
     */
    public function select(
        string $table,
        string $fields = '*',
        string $where = '',
        array $whereValues = [],
        string $aditional = ''
    ): self
    {
        $query = 'SELECT ' . $fields . 'FROM ' . $table
            . ($where ? ' WHERE ' . $where : '')
            . ($aditional ? ' ' . $aditional : '');

        $this->prepare($query);

        foreach ($whereValues as $param => $value) {
            $this->bindParam($param, $value);
        }

        return $this;
    }

    /**
     * Insert statement.
     *
     * @param string $table
     * @param array $data
     * @return self
     */
    public function insert(string $table, array $data): void
    {
        $fieldNames = implode(',', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO {$table} ({$fieldNames}) VALUES ($fieldValues)";

        $this->prepare($query);

        foreach ($data as $key => $value) {
            $this->bindValue(":{$key}", $value);
        }

        $this->execute();
    }

    /**
     * Get results from the current statement.
     *
     * @return array
     */
    public function get(): array
    {
        $this->execute();
        
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}