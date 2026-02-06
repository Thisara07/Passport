<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's applications and appointments for profile overview
        $applications = $user->applications()->with('document')->get();
        $appointments = $user->appointments()->orderBy('Appointment_Date', 'desc')->get();
        
        return view('profile.index', compact('user', 'applications', 'appointments'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:applicant,Email,' . $user->Applicant_ID . ',Applicant_ID',
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            // Update basic info
            $user->Name = $request->name;
            $user->Email = $request->email;
            
            // Update password if provided
            if ($request->new_password) {
                if (!Hash::check($request->current_password, $user->Password)) {
                    return redirect()->back()
                        ->withErrors(['current_password' => 'Current password is incorrect'])
                        ->withInput();
                }
                $user->Password = Hash::make($request->new_password);
            }
            
            $user->save();
            
            return redirect()->back()
                ->with('success', 'Profile updated successfully');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
