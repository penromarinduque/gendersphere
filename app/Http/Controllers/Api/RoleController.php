<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'role' => ['required', Rule::in(['admin', 'viewer', 'encoder'])],
            'user_id' => ['required', 'exists:users,id'],
            'office_id' => ['required', 'exists:offices,id'],
        ], [
            'user_id' => 'user',
            'office_id' => 'office'
        ]);

        $roleExist = Role::where([
            'user_id' => $request->user_id,
            'office_id' => $request->office_id,
            'role_type' => $request->role
        ])->exists();

        if($roleExist) {
            return response()->json([
                'message' => 'Role already exists'
            ], 409);
        }

        $role = Role::create([
            'role_type' => $request->role,
            'user_id' => $request->user_id,
            'office_id' => $request->office_id,
        ]);

        return response()->json($role, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
