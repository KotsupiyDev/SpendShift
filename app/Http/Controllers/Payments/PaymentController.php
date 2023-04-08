<?php

namespace App\Http\Controllers\Payments;

use App\DTO\PaymentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Services\Payment\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        public PaymentService $paymentService
    )
    {}

    public function store(StorePaymentRequest $request): JsonResponse
    {
        try {
            $userId = $request->user()->id;
            $paymentDTO = PaymentDTO::from([
                ...$request->all(),
                'user_id' => $userId,
            ]);

            $paymentResponse = $this->paymentService->save($paymentDTO);

            return response()->json([
                'success' => true,
                'message' => 'Payment added to list.',
                'data' => $paymentResponse,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function update(UpdateCategoryRequest $request): JsonResponse
    {
//        try {
//            $categoryDTO = CategoryDTO::from($request->all());
//
//            $categoryResponse = $this->categoryService->update($categoryDTO);
//
//            return response()->json([
//                'success' => true,
//                'message' => 'Category updated.',
//                'data' => $categoryResponse,
//            ]);
//        } catch (\Exception $exception) {
//            $duplicateRecord = '23505';
//            $message = $exception->getCode() === $duplicateRecord ?
//                'Category with this name has exist.' :
//                $exception->getMessage();
//
//            return response()->json([
//                'success' => false,
//                'message' => $message,
//            ], 400);
//        }
    }

    public function delete(DeleteCategoryRequest $request): JsonResponse
    {
//        try {
//            $this->categoryService->delete($request->get('id'));
//
//            return response()->json([
//                'success' => true,
//                'message' => 'Category deleted.',
//            ]);
//        } catch (\Exception $exception) {
//            return response()->json([
//                'success' => false,
//                'message' => $exception->getMessage(),
//            ], 400);
//        }
    }
}
