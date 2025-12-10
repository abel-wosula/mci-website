<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        return UserResource::collection(
            User::with('roles')->paginate(10)
        );
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return new UserResource($user);
    }

    // POST /api/users
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return new UserResource($user);
    }

    // PUT/PATCH /api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return new UserResource($user);
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
