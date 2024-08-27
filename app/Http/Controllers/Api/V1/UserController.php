<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

/**
 * @method authorize(string $string, $user)
 */
class UserController extends Controller
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    public function store(StoreUserRequest $request): UserResource
    {
        $validatedData = $request->validated();
        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::create($validatedData);

        return new UserResource($user);
    }

    public function show(string $id): UserResource
    {
        return new UserResource(User::findOrFail($id));
    }

    public function updateUserRole(Request $request, $id): JsonResponse
    {
        $adminUser = auth()->user();

        if ($adminUser->role !== 'admin') {
            return response()->json(['message' => 'This action is unauthorized.'], 403);
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role' => ['required', Rule::in(UserRoleEnum::cases())],
        ]);

        $user->role = $validated['role'];
        $user->save();

        return response()->json([
            'message' => 'User role updated successfully',
            'user' => new UserResource($user)
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
