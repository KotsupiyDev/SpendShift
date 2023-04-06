<?php

namespace App\DTO;

use App\Enums\PaymentTypesEnum;
use Spatie\LaravelData\Data;

class CategoryDTO extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $type,
        public ?int $user_id
    )
    {}
}
