<?php

namespace App\Services\Auth;

use App\Repositories\User\UserRepositoryInterface;
use App\Services\Auth\GenerateAccessToken;

class AuthenticateUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private GenerateAccessToken $generateAccessToken
    ) {}

    public function execute(array $data): array
    {
        try {
            $user = $this->userRepository->findByField('email', $data['email']);

            if (!$user) {
                throw new \Exception('User not found', 404);
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
