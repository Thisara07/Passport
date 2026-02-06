<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $email = $request->email;
        $password = $request->password;
        
        // Check Admin first
        $admin = Admin::where('Email_Address', $email)->first();
        
        if ($admin && Hash::check($password, $admin->Password)) {
            // Check if admin has 2FA enabled and confirmed
            if ($admin->two_factor_secret && $admin->two_factor_confirmed_at) {
                // Store the admin ID in session for 2FA verification
                $request->session()->put('login.id', $admin->getKey());
                $request->session()->put('login.guard', 'admin');
                $request->session()->put('login.remember', $request->boolean('remember'));
                
                return redirect()->route('two-factor.login');
            }
            
            Auth::guard('admin')->login($admin);
            Session::put('user_role', 'admin');
            return redirect()->route('admin.dashboard');
        }
        
        // Check Applicant
        $applicant = Applicant::where('Email', $email)->first();
        
        if ($applicant && Hash::check($password, $applicant->Password)) {
            // Check if applicant has 2FA enabled and confirmed
            if ($applicant->two_factor_secret && $applicant->two_factor_confirmed_at) {
                // Store the applicant ID in session for 2FA verification
                $request->session()->put('login.id', $applicant->getKey());
                $request->session()->put('login.guard', 'web');
                $request->session()->put('login.remember', $request->boolean('remember'));
                
                return redirect()->route('two-factor.login');
            }
            
            Auth::guard('web')->login($applicant);
            Session::put('user_role', 'applicant');
            return redirect('/');
        }
        
        // If neither, login failed
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->only('email'));
    }
    
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
    
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $admin = Admin::where('Email_Address', $request->email)->first();
        
        if ($admin && Hash::check($request->password, $admin->Password)) {
            // Check if admin has 2FA enabled and confirmed
            if ($admin->two_factor_secret && $admin->two_factor_confirmed_at) {
                // Store the admin ID in session for 2FA verification
                $request->session()->put('login.id', $admin->getKey());
                $request->session()->put('login.guard', 'admin');
                $request->session()->put('login.remember', $request->boolean('remember'));
                
                return redirect()->route('two-factor.login');
            }
            
            Auth::guard('admin')->login($admin);
            Session::put('user_role', 'admin');
            return redirect()->route('admin.dashboard');
        }
        
        return back()->withErrors([
            'email' => 'Invalid admin credentials.',
        ])->withInput($request->only('email'));
    }
}
