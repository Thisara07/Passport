<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index()
    {
        // Check if user has any appointments (similar to original logic)
        $user = Auth::user();
        $hasAppointment = $user->appointments()->exists();
        
        return view('application.form', compact('hasAppointment'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'required|date',
            'phone' => 'required|string|max:20',
            'nic_number' => 'required|string|max:12',
            'address' => 'required|string|max:200',
            'street' => 'required|string|max:100',
            'city' => 'required|string|max:50',
            'province' => 'required|string|max:50',
            'nic_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:20480',
            'birth_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:20480',
            'photo_file' => 'required|file|mimes:jpg,jpeg,png|max:20480',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            // Handle file uploads
            $nicFile = $request->file('nic_file')->store('documents', 'public');
            $birthFile = $request->file('birth_file')->store('documents', 'public');
            $photoFile = $request->file('photo_file')->store('documents', 'public');
            
            // Create document record - storing full paths
            $document = Document::create([
                'NIC_card' => $nicFile,
                'Birth_Certificate' => $birthFile,
                'Photo' => $photoFile,
                'Nationality' => $request->province,
                'verification_status' => 'PENDING'
            ]);
            
            // Create application record
            $application = Application::create([
                'Applicant_ID' => Auth::id(),
                'Document_ID' => $document->Document_ID,
                'Full_Name' => $request->full_name,
                'Gender' => $request->gender,
                'Date_of_Birth' => $request->dob,
                'Phone_Number' => $request->phone,
                'NIC' => $request->nic_number,
                'Address' => $request->address,
                'Street' => $request->street,
                'City' => $request->city,
                'Province' => $request->province,
                'Status' => 'PENDING'
            ]);
            
            return redirect()->route('application.success')
                ->with('success', __('messages.application_submitted_successfully'));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to submit application: ' . $e->getMessage()])
                ->withInput();
        }
    }
    
    public function success()
    {
        return view('application.success');
    }
}
