<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Appointment;
use App\Models\Document;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Get statistics for reports
        $stats = [
            'total_applications' => Application::count(),
            'pending_applications' => Application::where('Status', 'pending')->count(),
            'approved_applications' => Application::where('Status', 'approved')->count(),
            'rejected_applications' => Application::where('Status', 'rejected')->count(),
            
            'total_documents' => Document::count(),
            'pending_documents' => Document::where('verification_status', 'pending')->count(),
            'approved_documents' => Document::where('verification_status', 'approved')->count(),
            'rejected_documents' => Document::where('verification_status', 'rejected')->count(),
            
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('Status', 'PENDING')->count(),
            'approved_appointments' => Appointment::where('Status', 'APPROVED')->count(),
            'cancelled_appointments' => Appointment::where('Status', 'CANCELLED')->count(),
        ];
        
        // Get recent activity
        $recentApplications = Application::with('applicant')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentAppointments = Appointment::with('applicant')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.reports.index', compact('stats', 'recentApplications', 'recentAppointments'));
    }
    
    public function approvedApplications()
    {
        $applications = Application::with(['applicant', 'document'])
            ->where('Status', 'approved')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('admin.reports.approved', compact('applications'));
    }
    
    public function rejectedApplications()
    {
        $applications = Application::with(['applicant', 'document'])
            ->where('Status', 'rejected')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('admin.reports.rejected', compact('applications'));
    }
}