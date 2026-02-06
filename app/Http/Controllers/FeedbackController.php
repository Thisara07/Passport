<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback_entries = Feedback::where('Status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
            
        return view('feedback', compact('feedback_entries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        Feedback::create([
            'Name' => $validated['name'],
            'Email' => $validated['email'],
            'Subject' => $validated['subject'],
            'Rating' => $validated['rating'],
            'Message' => $validated['message'],
            'Status' => 'active'
        ]);

        return redirect()->route('feedback')
            ->with('success', 'Thank you for your feedback! We appreciate your input.');
    }
}
