<?php

namespace App\Services\Category;

use App\DTO\CategoryDTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryService
{
    public function save(CategoryDTO $categoryDTO): array
    {
        $category = Category::where(function (Builder $query) use ($categoryDTO){
            $query->where('user_id', $categoryDTO->user_id);
            $query->where('type', $categoryDTO->type);
            $query->where('name', $categoryDTO->name);
        })->first();

        throw_if(!is_null($category), new \Exception('Category has exist!'));

        $category = Category::create($categoryDTO->all());

        return [
            'category' => $category,
        ];
    }

    public function update(CategoryDTO $categoryDTO): array
    {
        $category = Category::find($categoryDTO->id);

        throw_if(is_null($category), new \Exception('Category has not exist!'));

        $category->name = $categoryDTO->name;

        $category->save();

        return [
            'category' => $category,
        ];
    }

    public function delete(int $categoryId): void
    {
        $category = Category::find($categoryId);

        throw_if(is_null($category), new \Exception('Category has not exist!'));

        $category->delete();
    }
}
