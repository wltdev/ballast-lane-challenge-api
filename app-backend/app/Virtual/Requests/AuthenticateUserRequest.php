<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *     title="Authenticate User Request",
 *     description="Authenticate user request",
 *     type="object",
 *     required={"email", "password"}
 * )
 */
class AuthenticateUserRequest
{
    /**
     * @OA\Property(
     *     title="email",
     *     description="Email of the user",
     *     type="string",
     *     example="john@example.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="password",
     *     description="Password of the user",
     *     type="string",
     *     example="password123"
     * )
     *
     * @var string
     */
    public $password;
}
