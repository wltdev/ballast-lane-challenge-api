<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Services\User\RegisterUserService;

class RegisterController extends Controller
{
    public function __construct(private RegisterUserService $registerUserService) {}

    public function register(RegisterUserRequest $request)
    {
        try {
            $result = $this->registerUserService->execute($request->validated());

            return response()->json([
                'success' => true,
                'data' => $result['data']
            ], $result['status']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
