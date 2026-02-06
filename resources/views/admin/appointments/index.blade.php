@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('messages.appointment_management') }}</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Bulk Time Slot Generator -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('messages.bulk_generate_time_slots') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appointments.generate-bulk-slots') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">{{ __('messages.start_date') }} *</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">{{ __('messages.end_date') }} *</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="daily_start_time" class="form-label">{{ __('messages.daily_start_time') }} *</label>
                                    <input type="time" name="daily_start_time" id="daily_start_time" class="form-control" 
                                           value="09:00" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="daily_end_time" class="form-label">{{ __('messages.daily_end_time') }} *</label>
                                    <input type="time" name="daily_end_time" id="daily_end_time" class="form-control" 
                                           value="17:00" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="interval_minutes" class="form-label">{{ __('messages.interval_minutes') }} *</label>
                            <select name="interval_minutes" id="interval_minutes" class="form-control" required>
                                <option value="15" selected>15 minutes</option>
                                <option value="30">30 minutes</option>
                                <option value="60">60 minutes</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="office_branch_bulk" class="form-label">{{ __('messages.office_branch') }} *</label>
                            <div class="mb-2">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="select-all-branches-bulk">
                                    {{ __('messages.select_all_branches') }}
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-all-branches-bulk">
                                    {{ __('messages.clear_selection') }}
                                </button>
                            </div>
                            <select name="office_branch[]" id="office_branch_bulk" class="form-control" multiple size="5" required>
                                <option value="Colombo">Colombo</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Galle">Galle</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Matara">Matara</option>
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple branches. Click "Select All" to choose all branches.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="max_capacity_bulk" class="form-label">{{ __('messages.max_capacity_per_slot') }} *</label>
                            <input type="number" name="max_capacity" id="max_capacity_bulk" class="form-control" 
                                   min="1" max="50" value="10" required>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="weekdays_only" id="weekdays_only" value="1">
                                <label class="form-check-label" for="weekdays_only">
                                    {{ __('messages.generate_weekdays_only') }}
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-calendar-plus me-2"></i>{{ __('messages.generate_time_slots') }}
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Manual Single Slot Creation -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>{{ __('messages.create_single_time_slot') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appointments.create-slot') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="slot_date" class="form-label">{{ __('messages.date') }}</label>
                            <input type="date" name="slot_date" id="slot_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_time" class="form-label">{{ __('messages.start_time') }}</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">{{ __('messages.end_time') }}</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="office_branch" class="form-label">{{ __('messages.office_branch') }} *</label>
                            <div class="mb-2">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="select-all-branches-single">
                                    {{ __('messages.select_all_branches') }}
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-all-branches-single">
                                    {{ __('messages.clear_selection') }}
                                </button>
                            </div>
                            <select name="office_branch[]" id="office_branch" class="form-control" multiple size="5" required>
                                <option value="Colombo">Colombo</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Galle">Galle</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Matara">Matara</option>
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple branches. Click "Select All" to choose all branches.</div>
                        </div>
                        <div class="mb-3">
                            <label for="max_capacity" class="form-label">{{ __('messages.max_capacity') }}</label>
                            <input type="number" name="max_capacity" id="max_capacity" class="form-control" min="1" max="100" value="10" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('messages.create_single_slot') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Appointments List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('messages.all_appointments') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.appointment_id') }}</th>
                                    <th>{{ __('messages.applicant') }}</th>
                                    <th>{{ __('messages.date') }} & {{ __('messages.time') }}</th>
                                    <th>{{ __('messages.branch') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->Appointment_ID }}</td>
                                        <td>{{ $appointment->applicant->Name ?? __('messages.unknown') }}</td>
                                        <td>
                                            {{ $appointment->Appointment_Date }}<br>
                                            <small>{{ $appointment->Appointment_Time }}</small>
                                        </td>
                                        <td>{{ $appointment->Office_Branch }}</td>
                                        <td>
                                            <span class="badge bg-{{ $appointment->Status === 'PENDING' ? 'warning' : ($appointment->Status === 'APPROVED' ? 'success' : 'danger') }}">
                                                {{ $appointment->Status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($appointment->Status === 'PENDING')
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <form action="{{ route('admin.appointments.update-status', $appointment->Appointment_ID) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="APPROVED">
                                                        <button type="submit" class="btn btn-success" 
                                                                onclick="return confirm('{{ __('messages.confirm_approve_appointment') }}')">
                                                            {{ __('messages.approve') }}
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.appointments.update-status', $appointment->Appointment_ID) }}" method="POST" class="d-inline ms-1">
                                                        @csrf
                                                        <input type="hidden" name="status" value="CANCELLED">
                                                        <input type="hidden" name="cancel_reason" value="Admin cancelled">
                                                        <button type="submit" class="btn btn-danger" 
                                                                onclick="return confirm('{{ __('messages.confirm_cancel_appointment') }}')">
                                                            {{ __('messages.cancel') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-muted">{{ $appointment->Status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('messages.no_appointments_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Time Slots Summary -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('messages.active_time_slots') }}</h5>
                        <span class="badge bg-light text-dark">{{ __('messages.total') }}: {{ $timeSlots->count() }} {{ __('messages.slots') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.time') }}</th>
                                    <th>{{ __('messages.branch') }}</th>
                                    <th>{{ __('messages.capacity') }}</th>
                                    <th>{{ __('messages.bookings') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($timeSlots as $slot)
                                    <tr>
                                        <td>{{ $slot->Slot_Date }}</td>
                                        <td>{{ $slot->Start_Time }} - {{ $slot->End_Time }}</td>
                                        <td>{{ $slot->Office_Branch }}</td>
                                        <td>{{ $slot->Max_Capacity }}</td>
                                        <td>{{ $slot->Current_Bookings }}</td>
                                        <td>
                                            <span class="badge bg-{{ $slot->Status === 'ACTIVE' ? 'success' : 'secondary' }}">
                                                {{ $slot->Status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($slot->Current_Bookings == 0)
                                                <form action="{{ route('admin.appointments.delete-slot', $slot->Slot_ID) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('{{ __('messages.confirm_delete_time_slot') }}')">
                                                        {{ __('messages.delete') }}
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted">{{ __('messages.has_bookings') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('messages.no_time_slots_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview slot generation
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const dailyStartTime = document.getElementById('daily_start_time');
    const dailyEndTime = document.getElementById('daily_end_time');
    const intervalSelect = document.getElementById('interval_minutes');
    const weekdaysOnly = document.getElementById('weekdays_only');
    
    function calculateSlots() {
        if (!startDateInput.value || !endDateInput.value || !dailyStartTime.value || !dailyEndTime.value) {
            return;
        }
        
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const interval = parseInt(intervalSelect.value);
        const weekdays = weekdaysOnly.checked;
        
        // Calculate time range in minutes
        const startTimeParts = dailyStartTime.value.split(':');
        const endTimeParts = dailyEndTime.value.split(':');
        const startMinutes = parseInt(startTimeParts[0]) * 60 + parseInt(startTimeParts[1]);
        const endMinutes = parseInt(endTimeParts[0]) * 60 + parseInt(endTimeParts[1]);
        const dailyMinutes = endMinutes - startMinutes;
        
        if (dailyMinutes <= 0) return;
        
        // Count working days
        let workingDays = 0;
        const currentDate = new Date(startDate);
        
        while (currentDate <= endDate) {
            if (!weekdays || (currentDate.getDay() !== 0 && currentDate.getDay() !== 6)) {
                workingDays++;
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }
        
        // Calculate total slots
        const slotsPerDay = Math.floor(dailyMinutes / interval);
        const totalSlots = workingDays * slotsPerDay;
        
        // Show preview
        const previewText = `${workingDays} days × ${slotsPerDay} slots/day = ${totalSlots} total slots`;
        let previewElement = document.getElementById('slot-preview');
        
        if (!previewElement) {
            previewElement = document.createElement('div');
            previewElement.id = 'slot-preview';
            previewElement.className = 'alert alert-info mt-3';
            document.querySelector('#start_date').closest('.card-body').appendChild(previewElement);
        }
        
        previewElement.innerHTML = `<strong>Preview:</strong> ${previewText}`;
    }
    
    // Add event listeners
    [startDateInput, endDateInput, dailyStartTime, dailyEndTime, intervalSelect, weekdaysOnly].forEach(element => {
        if (element) {
            element.addEventListener('change', calculateSlots);
        }
    });
    
    // Initial calculation
    setTimeout(calculateSlots, 100);
    
    // Select All functionality
    document.getElementById('select-all-branches-bulk').addEventListener('click', function() {
        const select = document.getElementById('office_branch_bulk');
        for (let i = 0; i < select.options.length; i++) {
            select.options[i].selected = true;
        }
    });
    
    document.getElementById('clear-all-branches-bulk').addEventListener('click', function() {
        const select = document.getElementById('office_branch_bulk');
        for (let i = 0; i < select.options.length; i++) {
            select.options[i].selected = false;
        }
    });
    
    document.getElementById('select-all-branches-single').addEventListener('click', function() {
        const select = document.getElementById('office_branch');
        for (let i = 0; i < select.options.length; i++) {
            select.options[i].selected = true;
        }
    });
    
    document.getElementById('clear-all-branches-single').addEventListener('click', function() {
        const select = document.getElementById('office_branch');
        for (let i = 0; i < select.options.length; i++) {
            select.options[i].selected = false;
        }
    });
});
</script>
@endsection