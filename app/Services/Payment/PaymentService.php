<?php

namespace App\Services\Payment;

use App\DTO\PaymentDTO;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function __construct(
        public PaymentRepository $repository,
        public CategoryRepository $categoryRepository,
    )
    {}

    public function save(PaymentDTO $paymentDTO): array
    {
        DB::transaction(function () use ($paymentDTO){
            $category = $this->categoryRepository->find($paymentDTO->category_id);

            if (is_null($category) || $category->user_id !== $paymentDTO->user_id) {
                throw new \Exception('Category isn`t has exist!');
            }

            $this->repository->create($paymentDTO->toArray());
        });

        return [
            'payment' => $paymentDTO->toArray(),
        ];
    }

    public function update(PaymentDTO $paymentDTO): array
    {
        $payment = $this->repository->find($paymentDTO->id);

        throw_if(is_null($payment), new \Exception('Payment has not exist!'));

        $paymentUpdate = [
            ...$payment->toArray(),
            'value' => $paymentDTO->value,
            'description' => $paymentDTO->description,
        ];

        $this->repository->update($paymentUpdate);

        return [
            'payment' => $paymentUpdate,
        ];
    }

    public function delete(int $paymentId, int $userId): bool|null
    {
        $payment = $this->repository->find($paymentId);

        throw_if(is_null($payment), new \Exception('Payment has not exist!'));

        throw_if(
            $payment->user_id !== $userId,
            new \Exception('Payment does not belong to the user')
        );

        return $this->repository->delete($payment);
    }
}
