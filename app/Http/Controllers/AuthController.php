<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{   
    
    
    public function showLoginForm() {
        return view('admin.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email or password is incorrect.'
        ])->withInput();  
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    public function index(){
        return view('dashboard.users.index');
    }
      public function master(){
        return view('layouts.master');
    }
 public function dashboard()
{
    $totalCategory = Category::count(); 
    $totalUsers = User::count(); 
    $totalProduct = Product::count();
    $totalAdmin = Admin::count();
    

    
    return view('dashboard.dashboard', compact('totalCategory', 'totalUsers','totalProduct','totalAdmin'));
}

     
}
