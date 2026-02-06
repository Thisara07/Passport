@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Reports & Analytics</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Applications</h5>
                            <h2>{{ $stats['total_applications'] }}</h2>
                        </div>
                        <i class="bi bi-file-earmark-text" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <a href="{{ route('admin.reports.approved') }}" class="text-decoration-none">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Approved</h5>
                                <h2>{{ $stats['approved_applications'] }}</h2>
                            </div>
                            <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Pending</h5>
                            <h2>{{ $stats['pending_applications'] }}</h2>
                        </div>
                        <i class="bi bi-clock" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <a href="{{ route('admin.reports.rejected') }}" class="text-decoration-none">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Rejected</h5>
                                <h2>{{ $stats['rejected_applications'] }}</h2>
                            </div>
                            <i class="bi bi-x-circle" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Documents</h5>
                            <h2>{{ $stats['total_documents'] }}</h2>
                        </div>
                        <i class="bi bi-files" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Appointments</h5>
                            <h2>{{ $stats['total_appointments'] }}</h2>
                        </div>
                        <i class="bi bi-calendar-check" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Pending Docs</h5>
                            <h2>{{ $stats['pending_documents'] }}</h2>
                        </div>
                        <i class="bi bi-file-earmark" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Pending Appts</h5>
                            <h2>{{ $stats['pending_appointments'] }}</h2>
                        </div>
                        <i class="bi bi-calendar" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Applications</h5>
                </div>
                <div class="card-body">
                    @if($recentApplications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Applicant</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentApplications as $application)
                                        <tr>
                                            <td>#{{ $application->Application_ID }}</td>
                                            <td>{{ $application->applicant->Name ?? 'Unknown' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $application->Status === 'approved' ? 'success' : ($application->Status === 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($application->Status ?? 'pending') }}
                                                </span>
                                            </td>
                                            <td>{{ $application->created_at ? $application->created_at->format('M d') : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No recent applications.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Appointments</h5>
                </div>
                <div class="card-body">
                    @if($recentAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Applicant</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAppointments as $appointment)
                                        <tr>
                                            <td>#{{ $appointment->Appointment_ID }}</td>
                                            <td>{{ $appointment->applicant->Name ?? 'Unknown' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $appointment->Status === 'APPROVED' ? 'success' : ($appointment->Status === 'CANCELLED' ? 'danger' : 'warning') }}">
                                                    {{ $appointment->Status }}
                                                </span>
                                            </td>
                                            <td>{{ $appointment->created_at ? $appointment->created_at->format('M d') : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No recent appointments.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection