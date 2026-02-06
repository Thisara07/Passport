<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        // Get all applications with applicant details
        $applications = Application::with(['applicant', 'document'])
            ->orderBy('Application_ID', 'desc')
            ->paginate(10);
            
        return view('admin.applications.index', compact('applications'));
    }
    
    public function show($id)
    {
        $application = Application::with(['applicant', 'document'])->findOrFail($id);
        
        return view('admin.applications.show', compact('application'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
            'remarks' => 'nullable|string|max:500'
        ]);
        
        $application = Application::findOrFail($id);
        $application->Status = $request->status;
        $application->Remarks = $request->remarks ?? '';
        $application->save();
        
        // Also update the document status if it exists
        if ($application->document) {
            $application->document->verification_status = $request->status;
            $application->document->save();
        }
        
        return redirect()->back()
            ->with('success', 'Application status updated successfully');
    }
}