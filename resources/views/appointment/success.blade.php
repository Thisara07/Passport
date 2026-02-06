@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <div class="card shadow p-5">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
        </div>
        <h2>Appointment Booked Successfully!</h2>
        <p>Your appointment has been confirmed.</p>
        
        <div class="card bg-light p-3 my-4">
            <h5>Appointment Details</h5>
            <p><strong>Date:</strong> {{ $qrData['appointment_date'] ?? 'N/A' }}</p>
            <p><strong>Time:</strong> {{ $qrData['appointment_time'] ?? 'N/A' }}</p>
            <p><strong>Appointment ID:</strong> #{{ $qrData['appointment_id'] ?? 'N/A' }}</p>
        </div>

        <div class="mt-4">
            <a href="{{ route('appointment.view') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-list"></i> {{ __('messages.view_my_appointments') }}
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-primary me-2">
                <i class="bi bi-house"></i> {{ __('messages.dashboard') ?? 'Return to Dashboard' }}
            </a>
            <a href="{{ route('application') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-text"></i> {{ __('messages.apply_for_passport') ?? 'Apply for Passport' }}
            </a>
        </div>
    </div>
</div>
@endsection