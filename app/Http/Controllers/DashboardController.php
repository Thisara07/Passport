<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's applications and appointments
        $applications = Application::where('Applicant_ID', $user->Applicant_ID)->get();
        $appointments = Appointment::where('Applicant_ID', $user->Applicant_ID)->get();
        
        return view('dashboard', compact('applications', 'appointments'));
    }
}
