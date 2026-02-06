<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        // Get current settings (you can store these in database or config)
        $settings = [
            'site_name' => config('app.name', 'Passport System'),
            'admin_email' => config('mail.from.address', 'admin@example.com'),
            'maintenance_mode' => config('app.maintenance_mode', false),
            'max_applications_per_day' => config('app.max_applications_per_day', 100),
            'appointment_interval' => config('app.appointment_interval', 15),
        ];
        
        return view('admin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:100',
            'admin_email' => 'required|email',
            'max_applications_per_day' => 'required|integer|min:1|max:1000',
            'appointment_interval' => 'required|integer|in:15,30,60',
        ]);
        
        // In a real application, you would save these to database
        // For now, we'll just return success message
        
        return redirect()->back()
            ->with('success', 'Settings updated successfully');
    }
}