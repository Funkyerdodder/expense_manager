<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserManageController extends Controller
{
    public function index() {
        return view('user.manage');
    }

    public function getUser() {
        $users = User::with('role')->get();
        return response()->json($users);
    }

    public function saveUser(Request $request) {
        $request->validate([
            'username' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role;
        $user->save();

        $last_id = $user->id;

        $newUser = User::find($last_id);

        $role = $newUser->role;
        $created_at = $newUser->created_at;

        return response()->json([
            'status' => 'success',
            'last_id' => $last_id,
            'role_name' => $role->name,
            'role_id' => $role->id,
            'created_at' => $created_at
        ]);

    }

    public function deleteUser(Request $request) {
        User::destroy($request->id);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function editUser(Request $request) {
        $request->validate([
            'username' => 'required',
            'name' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);
        $user = User::find($request->id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->save();



        return response()->json([
            'status' => 'success',
            'role_name' => $user->role->name,
            'role_id' => $user->role->id,
        ]);
    }

}
