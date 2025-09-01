<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class AuthController extends Controller
{
    public function showRegister() { return view('customer.register'); }
    public function register(Request $r){
        $data = $r->validate([
            'name'=>'required',
            'email'=>'required|email|unique:customers,email',
            'password'=>'required|min:6|confirmed'
        ]);
        $data['password']=bcrypt($data['password']);
        Customer::create($data);
        return redirect()->route('customer.login')->with('ok','Registered, please login.');
    }
    public function showLogin() { return view('customer.login'); }
    public function login(Request $r){
        $creds = $r->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::guard('customer')->attempt($creds,$r->filled('remember'))) {
            return redirect()->route('customer.dashboard');
        }
        return back()->withErrors(['email'=>'Invalid credentials']);
    }
    public function logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }
    public function dashboard(){ return view('customer.dashboard'); }
}
