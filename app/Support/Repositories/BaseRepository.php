<?php

namespace App\Support\Repositories;

use PDO;
use App\Support\Database\Conn;

abstract class BaseRepository
{
    /**
     * Connection with database
     *
     * @var \PDO|null
     */
    protected ?PDO $connection = null;

    /**
     * Create a new Base Repository instance
     */
    public function __construct()
    {
        $this->connection = Conn::getInstance()->getConnection();
    }
}
