<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        // Get all documents with application details
        $documents = Document::with(['application.applicant'])
            ->orderByRaw("CASE verification_status 
                WHEN 'pending' THEN 1 
                WHEN 'approved' THEN 2 
                WHEN 'rejected' THEN 3 
                ELSE 4 
            END")
            ->orderBy('Document_ID', 'desc')
            ->get();
            
        return view('admin.documents.index', compact('documents'));
    }
    
    public function show($id)
    {
        $document = Document::with(['application.applicant'])->findOrFail($id);
        return view('admin.documents.show', compact('document'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'remarks' => 'nullable|string|max:500'
        ]);
        
        $document = Document::findOrFail($id);
        $document->verification_status = $request->status;
        $document->save();
        
        // In a real system, you might want to send notifications here
        
        return redirect()->back()
            ->with('success', 'Document status updated successfully');
    }
    
    public function getDocumentFile(Request $request)
    {
        // Security check - ensure user is admin
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }
        
        $filePath = $request->query('path');
        
        if (!$filePath) {
            abort(404);
        }

        // Clean up and normalize path
        $filePath = ltrim(str_replace(['\\', '//'], '/', $filePath), '/');
        
        // Ensure documents/ prefix
        if (!str_starts_with($filePath, 'documents/')) {
            $filePath = 'documents/' . $filePath;
        }
        
        // Security check: prevent directory traversal
        if (str_contains($filePath, '..')) {
            abort(403);
        }

        // Resolve path via Storage facade
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
            $path = \Illuminate\Support\Facades\Storage::disk('public')->path($filePath);
            return response()->file($path);
        }

        // Fallback for files mistakenly stored in the root
        $basename = basename($filePath);
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($basename)) {
            $path = \Illuminate\Support\Facades\Storage::disk('public')->path($basename);
            return response()->file($path);
        }
        
        abort(404, 'File not found');
    }
}
