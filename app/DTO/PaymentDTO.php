<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class PaymentDTO extends Data
{
    public function __construct(
        public int $value,
        public string $description,
        public string $type,
        public int $user_id,
        public int $category_id
    )
    {}
}
