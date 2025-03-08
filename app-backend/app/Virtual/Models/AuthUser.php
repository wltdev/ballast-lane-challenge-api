<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="AuthUser",
 *     description="AuthUser",
 *     @OA\Xml(
 *         name="AuthUser"
 *     )
 * )
 */
class AuthUser
{
    /**
     * @OA\Property(
     *     title="user",
     *     description="User object",
     *     type="object",
     *     @OA\Property(ref="#/components/schemas/User")
     * )
     *
     * @var \App\Models\User
     */
    private $user;

    /**
     * @OA\Property(
     *     title="access_token",
     *     description="Access token string",
     *     type="string",
     *     example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
     * )
     * @var string
     */
    private $access_token;

    /**
     * @OA\Property(
     *     title="token_type",
     *     description="Token_type string",
     *     type="string",
     *     example="bearer"
     * )
     * @var string
     */
    private $token_type;

    /**
     * @OA\Property(
     *     title="success",
     *     description="success string",
     *     type="boolean",
     *     example=true
     * )
     * @var boolean
     */
    private $success;
}
