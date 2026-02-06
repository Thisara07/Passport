@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>User Details</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Users
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>User Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>User ID:</strong> #{{ $user->Applicant_ID }}</p>
                            <p><strong>Name:</strong> {{ $user->Name }}</p>
                            <p><strong>Email:</strong> {{ $user->Email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Registered Date:</strong> {{ $user->created_at ? $user->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                            <p><strong>Last Updated:</strong> {{ $user->updated_at ? $user->updated_at->format('M d, Y H:i') : 'N/A' }}</p>
                            <p><strong>Total Applications:</strong> {{ $user->applications()->count() }}</p>
                            <p><strong>Total Appointments:</strong> {{ $user->appointments()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Applications</h5>
                </div>
                <div class="card-body">
                    @if($user->applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NIC</th>
                                        <th>Status</th>
                                        <th>Submitted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->applications as $application)
                                        <tr>
                                            <td>#{{ $application->Application_ID }}</td>
                                            <td>{{ $application->NIC }}</td>
                                            <td>
                                                <span class="badge bg-{{ $application->Status === 'approved' ? 'success' : ($application->Status === 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($application->Status ?? 'pending') }}
                                                </span>
                                            </td>
                                            <td>{{ $application->created_at ? $application->created_at->format('M d, Y') : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No applications found for this user.</p>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Appointments</h5>
                </div>
                <div class="card-body">
                    @if($user->appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date & Time</th>
                                        <th>Branch</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->appointments as $appointment)
                                        <tr>
                                            <td>#{{ $appointment->Appointment_ID }}</td>
                                            <td>{{ $appointment->Appointment_Date }} at {{ $appointment->Appointment_Time }}</td>
                                            <td>{{ $appointment->Office_Branch }}</td>
                                            <td>
                                                <span class="badge bg-{{ $appointment->Status === 'APPROVED' ? 'success' : ($appointment->Status === 'CANCELLED' ? 'danger' : 'warning') }}">
                                                    {{ $appointment->Status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No appointments found for this user.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>User Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to List
                        </a>
                        
                        <form action="{{ route('admin.users.destroy', $user->Applicant_ID) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                <i class="bi bi-trash me-2"></i>Delete User
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection