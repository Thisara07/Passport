@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('messages.application_management') }}</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>{{ __('messages.all_applications') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>{{ __('messages.application_id') }}</th>
                            <th><i class="bi bi-person"></i> {{ __('messages.applicant_name') }}</th>
                            <th><i class="bi bi-card-text"></i> {{ __('messages.nic') }}</th>
                            <th><i class="bi bi-calendar"></i> {{ __('messages.submitted_date') }}</th>
                            <th><i class="bi bi-info-circle"></i> {{ __('messages.status') }}</th>
                            <th><i class="bi bi-gear"></i> {{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                            <tr>
                                <td>
                                    <strong>#{{ $application->Application_ID }}</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="bi bi-person-circle text-primary" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $application->applicant->Name ?? $application->Full_Name ?? 'Unknown Applicant' }}</strong>
                                            @if($application->applicant)
                                                <div class="small text-muted">{{ $application->applicant->Email ?? 'No email' }}</div>
                                            @elseif($application->Email)
                                                <div class="small text-muted">{{ $application->Email }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary p-2">
                                        <i class="bi bi-card-text me-1"></i>
                                        {{ $application->NIC ?? 'Not provided' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-event text-info me-2"></i>
                                        <div>
                                            <strong>{{ $application->created_at ? $application->created_at->format('M d, Y') : 'Not available' }}</strong>
                                            @if($application->created_at)
                                                <div class="small text-muted">{{ $application->created_at->format('H:i A') }}</div>
                                            @else
                                                <div class="small text-muted">Date not recorded</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $application->Status === 'approved' ? 'success' : ($application->Status === 'rejected' ? 'danger' : 'warning') }} fs-6 p-2">
                                        <i class="bi bi-{{ $application->Status === 'approved' ? 'check-circle' : ($application->Status === 'rejected' ? 'x-circle' : 'clock') }} me-1"></i>
                                        {{ ucfirst($application->Status ?? 'pending') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.applications.show', $application->Application_ID) }}" 
                                           class="btn btn-primary">
                                            <i class="bi bi-eye me-1"></i>{{ __('messages.view') }}
                                        </a>
                                        
                                        @if($application->Status !== 'approved')
                                            <form action="{{ route('admin.applications.update-status', $application->Application_ID) }}" 
                                                  method="POST" class="d-inline ms-1">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-success"
                                                        onclick="return confirm('Approve this application?')">
                                                    <i class="bi bi-check-circle me-1"></i>{{ __('messages.approve') }}
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($application->Status !== 'rejected')
                                            <form action="{{ route('admin.applications.update-status', $application->Application_ID) }}" 
                                                  method="POST" class="d-inline ms-1">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Reject this application?')">
                                                    <i class="bi bi-x-circle me-1"></i>{{ __('messages.reject') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                                    <div class="mt-3">
                                        <h4>{{ __('messages.no_applications_found') }}</h4>
                                        <p class="text-muted">{{ __('messages.no_applications_currently') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection