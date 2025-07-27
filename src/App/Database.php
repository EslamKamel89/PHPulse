<?php

namespace App;

use PDO;

class Database {
    public function __construct(
        private string $host,
        private string $dbname,
        private string $username,
        private string $password,
    ) {
    }
    function getConnection(): PDO {
        // $host = 'localhost';
        // $dbname = 'product_db';
        // $username = 'root';
        // $password = '';
        $dsn  = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4;port=3306";
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
