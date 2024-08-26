<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function refresh(Request $request): JsonResponse
    {
        try {
            $refreshToken = $request->input('refresh_token');
            JWTAuth::setToken($refreshToken);
            $newToken = JWTAuth::refresh($refreshToken);

            return response()->json([
                'success' => true,
                'token' => $newToken,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not refresh token',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
