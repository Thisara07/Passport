@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Rejected Applications</h1>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Reports
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Rejected Applications List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Application ID</th>
                            <th><i class="bi bi-person"></i> Applicant Name</th>
                            <th><i class="bi bi-card-text"></i> NIC Number</th>
                            <th><i class="bi bi-telephone"></i> Phone Number</th>
                            <th><i class="bi bi-calendar"></i> Submitted Date</th>
                            <th><i class="bi bi-calendar-x"></i> Rejected Date</th>
                            <th><i class="bi bi-chat"></i> Remarks</th>
                            <th><i class="bi bi-gear"></i> Actions</th>
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
                                    <span class="badge bg-danger p-2">
                                        <i class="bi bi-card-text me-1"></i>
                                        {{ $application->NIC ?? 'Not provided' }}
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-telephone text-primary me-1"></i>
                                    {{ $application->Phone_Number ?? 'N/A' }}
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
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-x text-danger me-2"></i>
                                        <div>
                                            <strong>{{ $application->updated_at ? $application->updated_at->format('M d, Y') : 'Not available' }}</strong>
                                            @if($application->updated_at)
                                                <div class="small text-muted">{{ $application->updated_at->format('H:i A') }}</div>
                                            @else
                                                <div class="small text-muted">Date not recorded</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($application->Remarks)
                                        <span class="badge bg-warning p-2">
                                            <i class="bi bi-chat me-1"></i>
                                            {{ Str::limit($application->Remarks, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">No remarks</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.applications.show', $application->Application_ID) }}" 
                                           class="btn btn-primary">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                                    <div class="mt-3">
                                        <h4>No rejected applications found</h4>
                                        <p class="text-muted">There are currently no rejected applications.</p>
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