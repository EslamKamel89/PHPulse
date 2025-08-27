<?php

declare(strict_types=1);

namespace App\Models;

use FrameWork\Model;

class Product  extends Model {
    protected function validate(array $data): void {
        if (empty($data['name'])) {
            $this->addError('name', 'The name field is required');
        }
    }
    public function getTotal(): int {
        $sql = "SELECT COUNT(*) AS total FROM product";
        $pdo = $this->database->getConnection();
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int) $row['total'];
    }
}
