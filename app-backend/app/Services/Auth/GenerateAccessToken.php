<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class GenerateAccessToken
{
    public function execute($credentials = null)
    {
        try {
            if ($credentials) {
                $token = Auth::attempt($credentials);
            } else {
                $token = Auth::refresh();
            }

            if (!$token) {
                return null;
            }

            return [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => Auth::user()
            ];
        } catch (JWTException $e) {
            throw $e;
        }
    }
}
