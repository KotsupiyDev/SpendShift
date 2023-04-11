<?php

namespace App\Http\Controllers\Auth;

use App\DTO\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreGuestRequest;
use App\Services\Auth\RegistrationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GuestController extends Controller
{
    public function __construct(
        public RegistrationService $service
    )
    {}

    public function store(StoreGuestRequest $request): JsonResponse
    {
        try {
            $guest = $this->service->makeGuestUser($request->get('email'));

            $userResponse = $this->service->register($guest);

            $userResponse['user']['password'] = $guest->password;

            return response()->json([
                'success' => true,
                'message' => 'User registration in system.',
                'data' => $userResponse
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
