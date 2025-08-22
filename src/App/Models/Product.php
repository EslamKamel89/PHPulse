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
}
