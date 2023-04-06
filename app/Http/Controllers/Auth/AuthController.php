<?php

namespace App\Http\Controllers\Auth;

use App\DTO\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegitrationRequest;
use App\Services\Auth\LoginService;
use App\Services\Auth\RegistrationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        public RegistrationService $registrationService,
        public LoginService $loginService
    )
    {}

    public function registration(RegitrationRequest $request): JsonResponse
    {
        try {
            $userDTO = UserDTO::from($request->all());

            $userResponse = $this->registrationService->register($userDTO);

            return response()->json([
                'success' => true,
                'message' => 'User registration in system.',
                'data' => $userResponse
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $userDTO = UserDTO::from($request->all());

            $userResponse = $this->loginService->login($userDTO);

            return response()->json([
                'success' => true,
                'message' => 'User login in system.',
                'data' => $userResponse
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()?->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'User logout.'
            ]);
        }catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' =>'User does have not found!',
            ], 400);
        }
    }
}
