<?php

namespace App\Services\Auth;

use App\Repositories\User\UserRepositoryInterface;
use App\Services\Auth\GenerateAccessToken;

class RegisterUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private GenerateAccessToken $generateAccessToken
    ) {}

    public function execute(array $data): array
    {
        try {
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            $auth = $this->generateAccessToken->execute([
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            if (!$auth) {
                throw new \Exception('Failed to authenticate user', 401);
            }

            return [
                'data' => $auth,
                'status' => 201
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
