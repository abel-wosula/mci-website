<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Http\Resources\RoleResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // GET /api/roles
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    // POST /api/roles
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'description' => 'nullable|string'
        ]);

        $role = Role::create($data);

        return new RoleResource($role);
    }

    // GET /api/roles/{id}
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    // PUT/PATCH /api/roles/{id}
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'description' => 'nullable|string'
        ]);

        $role->update($data);

        return new RoleResource($role);
    }

    // DELETE /api/roles/{id}
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }
}
