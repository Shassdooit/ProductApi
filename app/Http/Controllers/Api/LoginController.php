<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

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

        return response()->json([
            'success' => true,
            'user' => new UserResource(auth()->guard('api')->user()),
            'token' => $token,
        ], 200);
    }
}
