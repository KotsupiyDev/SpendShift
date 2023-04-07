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

        $category = $this->repository->create($categoryDTO->all());

        return [
            'category' => $category,
        ];
    }

    public function update(CategoryDTO $categoryDTO): array
    {

        $category =  $this->repository->find($categoryDTO->id);

        throw_if(is_null($category), new \Exception('Category has not exist!'));

        $categoryUpdate = [
            ...$category->toArray(),
            'name' => $categoryDTO->name
        ];

        $this->repository->update($categoryUpdate);

        return [
            'category' => $categoryUpdate,
        ];
    }

    public function delete(int $categoryId): void
    {
        $category = $this->repository->delete($categoryId);

        throw_if(is_null($category), new \Exception('Category has not exist!'));
    }
}
