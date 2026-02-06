@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('messages.application_details') }}</h1>
        <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ __('messages.back_to_applications') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('messages.application_information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>{{ __('messages.application_id') }}:</strong> #{{ $application->Application_ID }}</p>
                            <p><strong>{{ __('messages.nic') }}:</strong> {{ $application->NIC }}</p>
                            <p><strong>{{ __('messages.phone_number') }}:</strong> {{ $application->Phone_Number }}</p>
                            <p><strong>{{ __('messages.emergency_contact') }}:</strong> {{ $application->Emergency_Contact }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>{{ __('messages.submitted_date') }}:</strong> {{ $application->created_at ? $application->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                            <p><strong>{{ __('messages.last_updated') }}:</strong> {{ $application->updated_at ? $application->updated_at->format('M d, Y H:i') : 'N/A' }}</p>
                            <p><strong>{{ __('messages.status') }}:</strong>
                                <span class="badge bg-{{ $application->Status === 'approved' ? 'success' : ($application->Status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($application->Status ?? 'pending') }}
                                </span>
                            </p>
                            @if($application->Remarks)
                                <p><strong>{{ __('messages.remarks') }}:</strong> {{ $application->Remarks }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($application->document)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>{{ __('messages.document_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>{{ __('messages.document_type') }}:</strong> {{ $application->document->document_type }}</p>
                        <p><strong>{{ __('messages.verification_status') }}:</strong>
                            <span class="badge bg-{{ $application->document->verification_status === 'approved' ? 'success' : ($application->document->verification_status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($application->document->verification_status ?? 'pending') }}
                            </span>
                        </p>
                        <p><strong>{{ __('messages.uploaded_date') }}:</strong> {{ $application->document->created_at ? $application->document->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                        
                        @if($application->document->file_path)
                            <div class="mt-3">
                                <a href="{{ route('admin.documents.file', ['type' => $application->document->document_type, 'filename' => basename($application->document->file_path)]) }}" 
                                   class="btn btn-info" target="_blank">
                                    <i class="bi bi-eye me-2"></i>{{ __('messages.view_document') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('messages.applicant_information') }}</h5>
                </div>
                <div class="card-body">
                    @if($application->applicant)
                        <p><strong>{{ __('messages.name') }}:</strong> {{ $application->applicant->Name }}</p>
                        <p><strong>{{ __('messages.email') }}:</strong> {{ $application->applicant->Email }}</p>
                        <p><strong>{{ __('messages.applicant_id') }}:</strong> #{{ $application->applicant->Applicant_ID }}</p>
                    @else
                        <p class="text-muted">{{ __('messages.applicant_info_not_available') }}</p>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>{{ __('messages.action_required') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.applications.update-status', $application->Application_ID) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('messages.update_status') }}</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="approved" {{ $application->Status === 'approved' ? 'selected' : '' }}>{{ __('messages.approved') }}</option>
                                <option value="rejected" {{ $application->Status === 'rejected' ? 'selected' : '' }}>{{ __('messages.rejected') }}</option>
                                <option value="pending" {{ $application->Status === 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="remarks" class="form-label">{{ __('messages.remarks') }} ({{ __('messages.optional') }})</label>
                            <textarea name="remarks" id="remarks" class="form-control" rows="3">{{ $application->Remarks }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save me-2"></i>{{ __('messages.update_status') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection