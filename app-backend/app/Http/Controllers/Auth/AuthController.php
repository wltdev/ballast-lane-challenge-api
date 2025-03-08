<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Services\Auth\RegisterUserService;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints of Authentication"
 * )
 */
class AuthController extends Controller
{
    public function __construct(private RegisterUserService $registerUserService) {}

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Register new user",
     *     description="Registers a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterUserRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/AuthUser"),
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="status", type="string", example="success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function register(RegisterUserRequest $request)
    {
        try {
            $result = $this->registerUserService->execute($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
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
