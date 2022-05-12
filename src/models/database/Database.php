<?php

namespace App\Models\Database;

use PDO;
use PDOException;

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
}