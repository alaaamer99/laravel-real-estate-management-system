<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('users.manage')) {
            abort(403);
        }
        
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->can('users.manage')) {
            abort(403);
        }
        
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('users.manage')) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $user->assignRole($request->role);
        
        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function edit(User $user)
    {
        if (!auth()->user()->can('users.manage')) {
            abort(403);
        }
        
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->can('users.manage')) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        
        $user->syncRoles([$request->role]);
        
        return redirect()->route('users.index')->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->can('users.manage')) {
            abort(403);
        }
        
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'لا يمكنك حذف حسابك الشخصي');
        }
        
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
