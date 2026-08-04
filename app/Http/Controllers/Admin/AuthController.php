<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the login form for Super Admins.
     */
    public function showLoginForm()
    {
        return view('admin.pages.login');
    }

    /**
     * Handle authentication for Super Admin.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('super_admin')->attempt($credentials, $remember)) {
            // Store flash variable for the toaster notification
            $request->session()->flash('toast_success', 'Welcome admin');
            
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()
            ->withErrors(['email' => 'Invalid email address or password.'])
            ->withInput();
    }

    /**
     * Logout Super Admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('super_admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->flash('toast_success', 'User logout successfully');

        return redirect()->route('admin.login');
    }
}
