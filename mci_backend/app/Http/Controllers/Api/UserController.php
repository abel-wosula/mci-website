<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET /api/users
    public function index(Request $request)
    {
        $range  = json_decode($request->query('range', '[0,9]'));   // [start, end]
        $sort   = json_decode($request->query('sort', '["id","ASC"]')); // [field, order]
        $filter = json_decode($request->query('filter', '{}'), true);

        $query = User::with('roles');

        // Apply filters
        foreach ($filter as $field => $value) {
            $query->where($field, 'like', "%$value%");
        }

        $total = $query->count();

        $users = $query
            ->orderBy($sort[0], $sort[1])
            ->skip($range[0])
            ->take($range[1] - $range[0] + 1)
            ->get();

        // Return plain array with pagination headers
        return response()->json([
            'data' => UserResource::collection($users)->resolve(),
        ])->header('Content-Range', "users {$range[0]}-" . ($range[0] + count($users) - 1) . "/{$total}")
          ->header('Access-Control-Expose-Headers', 'Content-Range');
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return response()->json(['data' => new UserResource($user)]);
    }

    // POST /api/users
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json(['data' => new UserResource($user)]);
    }

    // PUT/PATCH /api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json(['data' => new UserResource($user)]);
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['data' => ['id' => $id]]);
    }
}
