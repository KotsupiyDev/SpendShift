<?php

namespace App\Repositories;

use App\DTO\CategoryDTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends Repository
{
    protected $eloquent = Category::class;

    public function getByParams(CategoryDTO $categoryDTO)
    {
        return $this->model()
            ->where('user_id', $categoryDTO->user_id)
            ->where('type', $categoryDTO->type)
            ->where('name', $categoryDTO->name)
            ->first();
    }
}
