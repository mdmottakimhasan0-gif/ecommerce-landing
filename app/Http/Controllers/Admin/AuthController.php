<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.auth.login', compact('settings'));
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'সফলভাবে এডমিন প্যানেলে লগইন হয়েছে।');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'স্বাগতম, '.Auth::user()->name.'! আপনি সফলভাবে লগইন হয়েছেন।');
        }

        return back()->withErrors([
            'email' => 'প্রদত্ত ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        $wasAdmin = Auth::check() && Auth::user()->isAdmin();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($wasAdmin) {
            return redirect()->route('admin.login')->with('success', 'আপনি সফলভাবে লগআউট হয়েছেন।');
        }

        return redirect()->route('home')->with('success', 'আপনি সফলভাবে লগআউট হয়েছেন।');
    }
}
