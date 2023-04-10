<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Services\Account\AccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        public AccountService $service
    )
    {}

    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $account = $this->service->getAccountData($user);

            return response()->json([
                'success' => true,
                'message' => 'Data given!',
                'data' => $account
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
