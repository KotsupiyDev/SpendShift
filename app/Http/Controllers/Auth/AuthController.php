<?php

namespace App\Http\Controllers\Auth;

use App\DTO\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegitrationRequest;
use App\Services\Auth\RegistrationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        public RegistrationService $registrationService
    )
    {}

    public function registration(RegitrationRequest $request): JsonResponse
    {
        try {
            $userDTO = UserDTO::from($request->all());

            $userResponse = $this->registrationService->register($userDTO);

            return response()->json($userResponse);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json($request->all(), 200);
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        return response()->json($request->all(), 200);
    }
}
