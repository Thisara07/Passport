<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Application;
use App\Models\Appointment;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalApplications = Application::count();
        $pendingDocuments = Document::where('verification_status', 'pending')->count();
        $approvedDocuments = Document::where('verification_status', 'approved')->count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('Status', 'PENDING')->count();
        
        // Get recent applications
        $recentApplications = Application::with(['document', 'applicant'])
            ->orderBy('Application_ID', 'desc')
            ->limit(10)
            ->get();
            
        // Get recent appointments
        $recentAppointments = Appointment::with('applicant')
            ->orderBy('Appointment_Date', 'desc')
            ->orderBy('Appointment_Time', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalApplications',
            'pendingDocuments',
            'approvedDocuments',
            'totalAppointments',
            'pendingAppointments',
            'recentApplications',
            'recentAppointments'
        ));
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $request->validate([
            'email' => 'required|email|unique:admin,Email_Address,' . $admin->Admin_ID . ',Admin_ID',
            'contact_number' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $admin->Email_Address = $request->email;
        $admin->Contact_Number = $request->contact_number;
        
        if ($request->new_password) {
            if (!Hash::check($request->current_password, $admin->Password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $admin->Password = Hash::make($request->new_password);
        }
        
        $admin->save();
        
        return back()->with('success', 'Profile updated successfully.');
    }
}
