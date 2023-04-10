<?php

namespace App\Services\Account;

use App\Enums\PaymentTypesEnum;
use App\Models\User;
use App\Repositories\CategoryRepository;

class AccountService
{
    public function __construct(
        public CategoryRepository $categoryRepository,
    )
    {}

    public function getAccountData(User $user): array
    {
        $categories = $this->categoryRepository->getAllWithPayments($user);

        $total = $this->getTotalValue($categories['incomes'], $categories['expenses']);

        $payedAnalytic = $this->getAnalytics($categories['expenses']);
        $receivedAnalytic = $this->getAnalytics($categories['incomes']);

        return [
            'account' => [
                'main' => [
                    'total' => $total,
                    'categories' => $categories,
                ],
                'analytics' => [
                    'payed' => $payedAnalytic,
                    'received' => $receivedAnalytic,
                ]
            ]
        ];
    }

    public function getTotalValue(array $incomes = [], array $expenses = []): int
    {
        $totalIncomes = $this->sumValueInCategories($incomes);
        $totalExpenses = $this->sumValueInCategories($expenses);

        return $totalIncomes - $totalExpenses;
    }

    public function sumValueInCategories($categories): int
    {
        $total = 0;
        foreach ($categories as $category) {
            $total += $this->sumValueInCategory($category);
        }

        return $total;
    }

    public function sumValueInCategory($category): int
    {
        return $category->payments->reduce(function ($acc, $payment) {
            return $acc + $payment->value;
        }, 0);
    }

    public function getAnalytics(array $categories): array
    {
        $analytics = [];

        foreach ($categories as $category) {
            $analytics[] = [
                'name' => $category->name,
                'total' => $this->sumValueInCategory($category),
            ];
        }

        return $analytics;
    }
}
