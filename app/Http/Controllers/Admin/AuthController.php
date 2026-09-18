<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
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
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $loginInput = trim($request->input('email'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Check if email or phone number
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);
        if ($isEmail) {
            $credentials = ['email' => $loginInput, 'password' => $password];
        } else {
            $cleanPhone = preg_replace('/^(?:\+?88)/', '', $loginInput);
            $credentials = ['phone' => $cleanPhone, 'password' => $password];
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Link any past guest orders matching user's phone or email
            $user = Auth::user();
            if ($user->phone) {
                Order::where('phone', $user->phone)->whereNull('user_id')->update(['user_id' => $user->id]);
            }
            if ($user->email && ! str_ends_with($user->email, '@customer.demandhat.com')) {
                Order::where('email', $user->email)->whereNull('user_id')->update(['user_id' => $user->id]);
            }

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Admin login successful.');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Welcome, '.$user->name.'! Signed in successfully.');
        }

        return back()->withErrors([
            'email' => 'Invalid email/phone number or password.',
        ])->onlyInput('email');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => ['required', 'string', 'regex:/^(?:\+?88)?01[3-9]\d{8}$/', 'unique:users,phone'],
            'email' => 'nullable|email|max:150|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Please provide your full name.',
            'phone.required' => 'Please provide your mobile number.',
            'phone.regex' => 'Please enter a valid 11-digit mobile number (e.g. 01712345678).',
            'phone.unique' => 'An account with this phone number already exists. Please sign in.',
            'email.unique' => 'An account with this email already exists.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $cleanPhone = preg_replace('/^(?:\+?88)/', '', trim($validated['phone']));
        $email = ! empty($validated['email']) ? trim($validated['email']) : $cleanPhone.'@customer.demandhat.com';

        $user = User::create([
            'name' => $validated['name'],
            'phone' => $cleanPhone,
            'email' => $email,
            'password' => $validated['password'],
            'role' => 'customer',
            'is_admin' => false,
        ]);

        // Auto-link existing guest orders with matching phone or email
        Order::where(function ($q) use ($cleanPhone, $email) {
            $q->where('phone', $cleanPhone);
            if (! str_ends_with($email, '@customer.demandhat.com')) {
                $q->orWhere('email', $email);
            }
        })->whereNull('user_id')->update(['user_id' => $user->id]);

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('customer.orders'))
            ->with('success', 'Account created successfully! Welcome, '.$user->name.'.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $wasAdmin = Auth::check() && Auth::user()->isAdmin();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($wasAdmin) {
            return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
        }

        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
