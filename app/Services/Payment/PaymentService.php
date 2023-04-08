<?php

namespace App\Services\Payment;

use App\DTO\PaymentDTO;
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

        $payment =  $this->repository->find($paymentDTO->value);

        throw_if(is_null($payment), new \Exception('Payment has not exist!'));

        $paymentUpdate = [
            ...$payment->toArray(),
//            'name' => $paymentDTO->name
        ];

        $this->repository->update($paymentUpdate);

        return [
            'category' => $paymentUpdate,
        ];
    }

    public function delete(int $paymentId): bool|null
    {
        $payment = $this->repository->delete($paymentId);

        throw_if(is_null($payment), new \Exception('Category has not exist!'));

        return $payment;
    }
}
