<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() { return view('admin.login'); }
    public function login(Request $r) {
        $creds = $r->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::guard('admin')->attempt($creds,$r->filled('remember'))) {
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email'=>'Invalid credentials']);
    }
    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    public function dashboard() { return view('admin.dashboard'); }
}
