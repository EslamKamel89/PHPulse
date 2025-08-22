<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database {
    private ?PDO $pdo = null;
    public function __construct(
        private string $host,
        private string $dbname,
        private string $username,
        private string $password,
    ) {
        // echo "New database object is created";
    }
    function getConnection(): PDO {
        if ($this->pdo !== null) return $this->pdo;
        $dsn  = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4;port=3306";
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo = $pdo;
        return $pdo;
    }
}
