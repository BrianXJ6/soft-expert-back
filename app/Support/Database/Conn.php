<?php

namespace App\Support\Database;

use PDO;
use PDOException;

class Conn
{
    /**
     * Instance of Conn class
     *
     * @var \App\Support\Database\Conn|null
     */
    private static $instance = null;

    /**
     * PDO connection
     *
     * @var \PDO|null
     */
    private ?PDO $connection = null;

    /**
     * Create a new Conn instance
     */
    private function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_DATABASE'];
        $user = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        try {
            $this->connection = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    }

    /**
     * Get the single instance for Conn class
     *
     * @return \App\Support\Database\Conn
     */
    public static function getInstance(): Conn
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get connection for PDO class
     *
     * @return \PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Close connection when finished
     */
    public function __destruct()
    {
        $this->connection = null;
    }
}
