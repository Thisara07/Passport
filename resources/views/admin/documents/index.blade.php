@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Document Verification</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Applicant Name</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>Phone</th>
                            <th>Documents</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>#{{ $document->application?->Application_ID ?? 'N/A' }}</td>
                                <td>{{ $document->application?->applicant?->Name ?? 'N/A' }}</td>
                                <td>{{ $document->application?->Gender ?? 'N/A' }}</td>
                                <td>{{ $document->application && $document->application->Date_of_Birth ? date('Y-m-d', strtotime($document->application->Date_of_Birth)) : 'N/A' }}</td>
                                <td>{{ $document->application?->Phone_Number ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if($document->NIC_card)
                                            <a href="{{ route('admin.documents.file', ['path' => $document->NIC_card]) }}" target="_blank" class="btn btn-outline-primary" title="View NIC">
                                                <i class="fas fa-id-card"></i>
                                            </a>
                                        @endif
                                        @if($document->Birth_Certificate)
                                            <a href="{{ route('admin.documents.file', ['path' => $document->Birth_Certificate]) }}" target="_blank" class="btn btn-outline-success" title="View Birth Certificate">
                                                <i class="fas fa-file-contract"></i>
                                            </a>
                                        @endif
                                        @if($document->Photo)
                                            <a href="{{ route('admin.documents.file', ['path' => $document->Photo]) }}" target="_blank" class="btn btn-outline-info" title="View Photo">
                                                <i class="fas fa-user-circle"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $document->verification_status === 'approved' ? 'success' : ($document->verification_status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($document->verification_status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($document->verification_status === 'pending')
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.documents.show', $document->Document_ID) }}" class="btn btn-primary btn-sm me-1">
                                                <i class="fas fa-eye"></i> View Details
                                            </a>
                                            <form action="{{ route('admin.documents.update-status', $document->Document_ID) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-success btn-sm" 
                                                        onclick="return confirm('Approve this document?')">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.documents.update-status', $document->Document_ID) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-danger btn-sm ms-1" 
                                                        onclick="return confirm('Reject this document?')">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted">Processed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No documents found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection