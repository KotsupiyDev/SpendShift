<?php

namespace App\Services\Category;

use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Builder;

class CategoryService
{
    public function __construct(
        public CategoryRepository $repository,
    )
    {}

    public function save(CategoryDTO $categoryDTO): array
    {
        $category = $this->repository->getByParams($categoryDTO);

        throw_if(!is_null($category), new \Exception('Category has exist!'));

        $category = Category::create($categoryDTO->all());

        return [
            'category' => $category,
        ];
    }

    public function update(CategoryDTO $categoryDTO): array
    {
        $category =  $this->repository->find($categoryDTO->id);

        throw_if(is_null($category), new \Exception('Category has not exist!'));

        $category->name = $categoryDTO->name;

        $category->save();

        return [
            'category' => $category,
        ];
    }

    public function delete(int $categoryId): void
    {
        $category = $this->repository->find($categoryId);

        throw_if(is_null($category), new \Exception('Category has not exist!'));

        $category->delete();
    }
}
