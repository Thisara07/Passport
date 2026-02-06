@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Admin Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card pending">
                <div class="card-body">
                    <h5 class="card-title">{{ $totalApplications }}</h5>
                    <p class="card-text">Total Applications</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card pending">
                <div class="card-body">
                    <h5 class="card-title">{{ $pendingDocuments }}</h5>
                    <p class="card-text">Pending Documents</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card approved">
                <div class="card-body">
                    <h5 class="card-title">{{ $approvedDocuments }}</h5>
                    <p class="card-text">Approved Documents</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title">{{ $totalAppointments }}</h5>
                    <p class="card-text">Total Appointments</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Recent Applications -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Applications</h5>
                </div>
                <div class="card-body">
                    @if($recentApplications->count() > 0)
                        <div class="list-group">
                            @foreach($recentApplications as $application)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>{{ $application->Full_Name }}</strong><br>
                                            <small class="text-muted">
                                                Application ID: {{ $application->Application_ID }}
                                            </small>
                                        </div>
                                        <span class="badge bg-{{ ($application->document->verification_status ?? 'pending') === 'approved' ? 'success' : (($application->document->verification_status ?? 'pending') === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($application->document->verification_status ?? 'pending') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No applications found.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Recent Appointments -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Appointments</h5>
                </div>
                <div class="card-body">
                    @if($recentAppointments->count() > 0)
                        <div class="list-group">
                            @foreach($recentAppointments as $appointment)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>{{ $appointment->applicant->Name ?? 'Unknown Applicant' }}</strong><br>
                                            <small class="text-muted">
                                                {{ $appointment->Appointment_Date ?? 'Unknown date' }} at {{ $appointment->Appointment_Time ?? 'Unknown time' }}<br>
                                                {{ $appointment->Office_Branch ?? 'Unknown branch' }}
                                            </small>
                                        </div>
                                        <span class="badge bg-{{ $appointment->Status === 'PENDING' ? 'warning' : ($appointment->Status === 'APPROVED' ? 'success' : 'danger') }}">
                                            {{ $appointment->Status }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No appointments found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection