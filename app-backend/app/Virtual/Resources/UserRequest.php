<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="Register User Request",
 *     description="Register user request",
 *     type="object",
 *     required={"name", "email", "password"}
 * )
 */
class UserRequest
{
    /**
     * @OA\Property(
     *     title="name",
     *     description="Name of the user",
     *     type="string",
     *     example="John"
     * )
     *
     * @var string
     */
    public $name;

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

    /**
     * @OA\Property(
     *     title="password_confirmation",
     *     description="Confirm password of the user",
     *     type="string",
     *     example="password123"
     * )
     *
     * @var string
     */
    public $passwor_confirmationd;
}
