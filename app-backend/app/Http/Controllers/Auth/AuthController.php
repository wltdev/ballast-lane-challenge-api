<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\Auth\AuthenticateUserService;
use App\Services\Auth\RegisterUserService;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints of Authentication"
 * )
 */
class AuthController extends Controller
{
    public function __construct(
        private RegisterUserService $registerUserService,
        private AuthenticateUserService $authenticateUserService
    ) {}

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
            ], $e->getCode());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="authenticateUser",
     *     tags={"Auth"},
     *     summary="Authenticate user",
     *     description="Authenticates a user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AuthenticateUserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User authenticated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/AuthUser"),
     *             @OA\Property(property="message", type="string", example="User authenticated successfully"),
     *             @OA\Property(property="status", type="string", example="success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Failed to authenticate user"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function authenticate(AuthenticateUserRequest $request)
    {
        try {
            $result = $this->authenticateUserService->execute($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'User authenticated successfully',
                'data' => $result['data']
            ], $result['status']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/me",
     *     operationId="getUser",
     *     tags={"Auth"},
     *     security={"bearerAuth": {}},
     *     summary="Get user",
     *     description="Retrieves the currently authenticated user",
     *     @OA\Response(
     *         response=200,
     *         description="User retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/User"),
     *             @OA\Property(property="message", type="string", example="User retrieved successfully"),
     *             @OA\Property(property="status", type="string", example="success")
     *         )
     *     )
     * )
     */
    public function me()
    {
        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully',
            'data' => Auth::user()
        ], 200);
    }
}
