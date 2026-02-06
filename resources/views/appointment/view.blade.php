@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Appointments</h2>
        <a href="{{ route('appointment') }}" class="btn btn-primary">
            <i class="bi bi-calendar-plus"></i> Book New Appointment
        </a>
    </div>

    @if($appointments->count() > 0)
        <div class="row">
            @foreach($appointments as $appointment)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Appointment #{{ $appointment->Appointment_ID }}</h5>
                            <p class="card-text">
                                <strong>Date:</strong> {{ $appointment->Appointment_Date }}<br>
                                <strong>Time:</strong> {{ $appointment->Appointment_Time }}<br>
                                <strong>Branch:</strong> {{ $appointment->Office_Branch }}<br>
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $appointment->Status === 'PENDING' ? 'warning' : ($appointment->Status === 'APPROVED' ? 'success' : 'danger') }}">
                                    {{ $appointment->Status }}
                                </span>
                            </p>
                            
                            @php
                                $appointmentDateTime = $appointment->Appointment_Date->copy()->setTimeFrom($appointment->Appointment_Time);
                                $isFuture = $appointmentDateTime->isFuture();
                            @endphp
                            
                            @if($isFuture && $appointment->Status === 'PENDING')
                                <div class="btn-group mt-3" role="group">
                                    <a href="{{ route('appointment') }}?reschedule_id={{ $appointment->Appointment_ID }}" 
                                       class="btn btn-sm btn-outline-primary shadow-sm rounded-start">
                                        <i class="fas fa-calendar-alt me-1"></i> {{ __('messages.reschedule') }}
                                    </a>
                                    <form action="{{ route('appointment.cancel', $appointment->Appointment_ID) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('{{ __('messages.confirm_delete_appointment') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm rounded-end ms-n1">
                                            <i class="fas fa-trash me-1"></i> {{ __('messages.delete_appointment') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <h4>No Appointments Found</h4>
            <p>You haven't booked any appointments yet.</p>
            <a href="{{ route('appointment') }}" class="btn btn-primary">Book Your First Appointment</a>
        </div>
    @endif
</div>

@endsection