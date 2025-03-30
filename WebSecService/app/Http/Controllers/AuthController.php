<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    //register user
    public function register_user(Request $request)
    {
        //validate
        $fields = $request->validate([
            'username' => ['required','max:255'],
            'email' => ['required','email','max:255', 'unique:users'],
            'password' => ['required','min:8','confirmed']
        ]);

        //register user
        $user = User::create($fields);

        // Assign customer role
        $user->assignRole('customer');

        // Create initial credit record with 0 amount
        Credit::create([
            'user_id' => $user->id,
            'amount' => 0
        ]);

        //login
        Auth::login($user);

        //redirect
        return redirect()->route('home');
    }

    //login user
    public function login(Request $request)
    {
        //validate
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required']
        ]);

        //attempt login
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended();
        } else {
            return back()->with('login_error', 'The provided credentials do not match our records.')
                        ->onlyInput('email');
        }
    }

    // Show change password form
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    // Handle password change request
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('home')
            ->with('success', 'Password changed successfully!');
    }

    // logout user
    public function logout(Request $request)
    {
        //logout user
        Auth::logout();

        //invalidate session
        $request->session()->invalidate();

        //regenerate CSRF token
        $request->session()->regenerateToken();

        //redirect to home
        return redirect()->route('home');
    }
}
