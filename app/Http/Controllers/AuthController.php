<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'That email and password don\'t match an account.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(self::home($request->user()));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    /** Students create their own accounts. Counselor accounts are added by an admin. */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'student_number' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create($data + ['role' => 'student']);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('student.home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public static function home(User $user): string
    {
        return $user->isStaff() ? route('office.referrals.index') : route('student.home');
    }
}
