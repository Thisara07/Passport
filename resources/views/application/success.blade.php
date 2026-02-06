@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <div class="card shadow p-5">
        <h2>Application Submitted Successfully</h2>
        <p>Your passport application has been received and is being processed.</p>
        <p class="text-muted">You will receive a notification when your application status changes.</p>
        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-primary me-2">
                <i class="bi bi-house"></i> Return to Dashboard
            </a>
            <a href="{{ route('appointment') }}" class="btn btn-outline-primary">
                <i class="bi bi-calendar"></i> Book Another Appointment
            </a>
        </div>
    </div>
</div>
@endsection