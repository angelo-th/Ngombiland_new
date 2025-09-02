<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    // List all users
    public function index() {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // Show create form
    public function create() {
        return view('admin.create_user');
    }

    // Store new user
    public function store(Request $request) {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
            'role'=>'required|in:client,agent,admin,super-admin'
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'role'=>$request->role
        ]);

        return redirect()->route('admin.users.index')->with('success','User created successfully!');
    }

    // Edit user
    public function edit(User $user) {
        return view('admin.edit_user', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user) {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'role'=>'required|in:client,agent,admin,super-admin'
        ]);

        $user->update($request->only(['name','email','role']));
        return redirect()->route('admin.users.index')->with('success','User updated.');
    }

    // Delete user
    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted.');
    }
}
