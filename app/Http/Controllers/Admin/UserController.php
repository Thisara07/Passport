<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Get all applicants/users
        $users = Applicant::orderBy('Applicant_ID', 'desc')
            ->paginate(10);
            
        return view('admin.users.index', compact('users'));
    }
    
    public function show($id)
    {
        $user = Applicant::with(['applications', 'appointments'])->findOrFail($id);
        
        return view('admin.users.show', compact('user'));
    }
    
    public function destroy($id)
    {
        $user = Applicant::findOrFail($id);
        
        // Check if user has active applications or appointments
        if ($user->applications()->count() > 0 || $user->appointments()->count() > 0) {
            return redirect()->back()
                ->withErrors(['error' => 'Cannot delete user with active applications or appointments']);
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}