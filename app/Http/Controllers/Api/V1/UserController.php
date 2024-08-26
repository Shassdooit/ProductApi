<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

/**
 * @method authorize(string $string, $user)
 */
class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }


    public function store(Request $request)
    {
        return new UserResource(User::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): UserResource
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUserRole(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $this->authorize('updateRole', $user);

        $validated = $request->validate([
            'role' => ['required', Rule::in(UserRoleEnum::cases())],
        ]);

        $user->role = $validated['role'];
        $user->save();

        return response()
            ->json(['message' => 'User role updated successfully', 'user' => new UserResource($user)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
