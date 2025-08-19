<?php

declare(strict_types=1);

namespace FrameWork;

use App\Database;
use PDO;

abstract class Model {
    protected  $table;
    public function __construct(private Database $database) {
    }
    private function getTable() {
        $parts = explode('\\', $this::class);
        return $this->table ?? strtolower(array_pop($parts));
    }
    public function findAll(): array {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->query("SELECT * FROM {$this->getTable()}");
        return  $stmt->fetchAll();
    }
    public function find(string $id): array|bool {
        $pdo = $this->database->getConnection();
        $sql = "
        SELECT *
        FROM {$this->getTable()}
        WHERE id = :id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function insert(array $data): bool {
        $sql = "INSERT INTO {$this->table} (name , description) VALUES (? , ?)";
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(1, $data['description'], PDO::PARAM_STR);
        return $stmt->execute();
    }
}
