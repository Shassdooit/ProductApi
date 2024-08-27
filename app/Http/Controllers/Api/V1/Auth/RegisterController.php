<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'role' => $validatedData['role'] ?? 'user',
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'password' => bcrypt($validatedData['password']),
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }
}
