<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegitrationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function registration(RegitrationRequest $request): JsonResponse
    {
        return response()->json($request->all(), 200);
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
