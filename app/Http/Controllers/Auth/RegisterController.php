<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:100',
            'email' => 'required|email|unique:applicant,Email',
            'password' => 'required|min:6|confirmed',
        ]);
        
        $applicant = Applicant::create([
            'Name' => $request->fullname,
            'Email' => $request->email,
            'Password' => Hash::make($request->password),
        ]);
        
        Auth::login($applicant);
        Session::put('user_role', 'applicant');
        
        return redirect()->route('dashboard');
    }
}
