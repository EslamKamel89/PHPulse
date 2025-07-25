<?php

namespace App;

use PDO;

class Database {
    function getConnection(): PDO {
        $host = 'localhost';
        $dbname = 'product_db';
        $username = 'root';
        $password = '';
        $dsn  = "mysql:host=$host;dbname=$dbname;charset=utf8mb4;port=3306";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
