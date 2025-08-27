<?php

declare(strict_types=1);

namespace FrameWork;

use App\Database;
use PDO;

abstract class Model {
    protected  $table;
    public function __construct(protected Database $database) {
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
        $this->validate($data);
        if (!empty($this->errors)) return false;
        $columns = implode(' , ', array_keys($data));
        $placeholders = implode(' , ', array_fill(0, count(array_keys($data)), '?'));
        $sql = "INSERT INTO {$this->getTable()} ($columns) VALUES ( $placeholders)";
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);
        $values = array_values($data);
        foreach ($values as $index => $value) {
            $stmt->bindValue(
                $index + 1,
                $value,
                $this->pdoType($value)
            );
        }
        return $stmt->execute();
    }
    public function update(string $id, array $data) {
        $this->validate($data);
        if (!empty($this->errors)) return false;
        unset($data['id']);
        $sql = "UPDATE  {$this->getTable()} ";
        $assignments = array_keys($data);
        array_walk($assignments, function (&$value) {
            $value = "$value = ?";
        });
        $sql .= " SET " . implode(' , ', $assignments);
        $sql .= " WHERE id = ? ";
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);
        $values = array_values($data);
        $index = 1;
        foreach ($values as  $value) {
            $stmt->bindValue(
                $index++,
                $value,
                $this->pdoType($value)
            );
        }
        $stmt->bindValue(
            $index,
            $id,
            $this->pdoType($id)
        );
        return $stmt->execute();
    }
    protected function pdoType($value) {
        return match (getType($value)) {
            'boolean' => PDO::PARAM_BOOL,
            'integer' => PDO::PARAM_INT,
            'NULL' => PDO::PARAM_NULL,
            default => PDO::PARAM_STR,
        };
    }
    abstract protected  function validate(array $array): void;
    protected  function addError(string $field, string $message): void {
        $this->errors[$field] = $message;
    }
    protected array $errors = [];
    public function getErrors() {
        return $this->errors;
    }
    public function getInsertId(): string {
        $pdo = $this->database->getConnection();
        return $pdo->lastInsertId();
    }
    public function delete(string $id): bool {
        $sql = " DELETE FROM {$this->getTable()} 
        WHERE id = :id ";
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
