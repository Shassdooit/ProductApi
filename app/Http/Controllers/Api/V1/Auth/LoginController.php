<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Your e-mail address or password is incorrect'
            ], 401);
        }

        $refreshToken = auth()
            ->guard('api')
            ->claims([
                'exp' => now()->addDays(30)->timestamp
            ])
            ->attempt($credentials);

        return response()->json([
            'success' => true,
            'user' => new UserResource(auth()->guard('api')->user()),
            'token' => $token,
            'refresh_token' => $refreshToken,
        ], 200);
    }
}
