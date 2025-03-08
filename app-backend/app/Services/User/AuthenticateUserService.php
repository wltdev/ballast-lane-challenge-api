<?php

namespace App\Services\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Services\Auth\GenerateAccessToken;
use Illuminate\Support\Facades\Validator;

class AuthenticateUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private GenerateAccessToken $generateAccessToken
    ) {}

    public function execute(array $data): array
    {
        try {
            $validator = Validator::make($data, [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return ['errors' => $validator->errors(), 'status' => 422];
            }

            $credentials = [
                'email' => $data['email'],
                'password' => $data['password']
            ];

            $auth = $this->generateAccessToken->execute($credentials);

            if (!$auth) {
                throw new \Exception('Failed to authenticate user', 401);
            }

            return ['data' => $auth, 'status' => 200];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
