<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    protected $middleware = ['auth'];

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        // Check if user has view_users permission
        if (!$request->user()->hasPermissionTo('view_users')) {
            abort(401);
        }

        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(Request $request)
    {
        // Check if user has create_users permission
        if (!$request->user()->hasPermissionTo('create_users')) {
            abort(401);
        }

        $roles = \Spatie\Permission\Models\Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        // Check if user has create_users permission
        if (!$request->user()->hasPermissionTo('create_users')) {
            abort(401);
        }

        //validate
        $fields = $request->validate([
            'username' => ['required','max:255'],
            'email' => ['required','email','max:255', 'unique:users'],
            'password' => ['required','min:8','confirmed'],
            'role' => ['required', 'exists:roles,name']
        ]);

        // Extract role from fields to prevent mass assignment issues
        $role = $fields['role'];
        unset($fields['role']);

        // Create user
        $user = User::create($fields);

        // Assign role
        $user->assignRole($role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(Request $request, User $user)
    {
        // Allow users to view their own profiles OR check for view_users permission
        if ($request->user()->id !== $user->id && !$request->user()->hasPermissionTo('view_users')) {
            abort(404);
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(Request $request, User $user)
    {
        // Check if user has edit_users permission
        if (!$request->user()->hasPermissionTo('edit_users')) {
            abort(401);
        }

        $roles = \Spatie\Permission\Models\Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        // Check if user has edit_users permission
        if (!$request->user()->hasPermissionTo('edit_users')) {
            abort(401);
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'exists:roles,name']
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed','min:8'],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->save();

        // Sync roles (removes old roles and adds the new one)
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(Request $request, User $user)
    {
        // Check if user has delete_users permission
        if (!$request->user()->hasPermissionTo('delete_users')) {
            abort(401);
        }

        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
