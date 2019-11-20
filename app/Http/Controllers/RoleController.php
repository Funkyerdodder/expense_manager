<?php

namespace App\Http\Controllers;

use App\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        return view('user.role');
    }

    public function saveRole(Request $request) {
        $request->validate([
            'roleName' => 'required',
            'description' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->roleName;
        $role->description = $request->description;
        $role->access = 'user';
        $role->save();
        return response()->json([
            'status' => 'success',
            'last_id' => $role->id
        ]);
    }

    public function getRole() {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function deleteRole(Request $request) {
        Role::destroy($request->id);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function editRole(Request $request) {
        $request->validate([
            'roleName' => 'required',
            'description' => 'required',
        ]);
        $role = Role::find($request->id);
        $role->name = $request->roleName;
        $role->description = $request->description;
        $role->save();
        return response()->json([
            'status' => 'success',
            'last_id' => $role->id
        ]);
    }

}
