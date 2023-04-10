<?php

namespace App\Repositories;

use App\DTO\CategoryDTO;
use App\Enums\PaymentTypesEnum;
use App\Models\Category;
use App\Models\User;
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

    public function getAllWithPayments(User $user): array
    {
        $categories = $user->categories->load('payments');
        $incomeCategories = [];
        $expenseCategories = [];

        foreach ($categories as $category) {
            $isIncome = $category->type === PaymentTypesEnum::Income->name;

            $isIncome ?
                $incomeCategories[] = $category:
                $expenseCategories[] = $category;
        }

        return [
            'incomes' => $incomeCategories,
            'expenses' => $expenseCategories,
        ];
    }
}
