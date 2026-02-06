<div>
    <div class="container py-5" style="max-width: 800px;">
        <div class="card shadow p-4">
            <h3 class="text-center mb-4">{{ __('messages.book_appointment') }}</h3>


            <form wire:submit.prevent="submit">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">{{ __('messages.appointment_date') }} *</label>
                            <input type="date" wire:model="appointment_date" id="appointment_date" class="form-control" 
                                   min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" required>
                            @error('appointment_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="office_branch" class="form-label">{{ __('messages.office_branch') }} *</label>
                            <select wire:model="office_branch" id="office_branch" class="form-control" required>
                                <option value="">{{ __('messages.select_branch') }}</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch }}">{{ $branch }}</option>
                                @endforeach
                            </select>
                            @error('office_branch')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="appointment_time" class="form-label">{{ __('messages.available_time_slots') }} *</label>
                    <select wire:model="appointment_time" id="appointment_time" class="form-control" required>
                        <option value="">{{ __('messages.select_time_slot') }}</option>
                        @foreach($availableSlots as $slot)
                            <option value="{{ $slot['Slot_ID'] }}">
                                {{ date('h:i A', strtotime($slot['Start_Time'])) }} - 
                                {{ date('h:i A', strtotime($slot['End_Time'])) }}
                                ({{ __('messages.available') }}: {{ $slot['available_capacity'] }})
                            </option>
                        @endforeach
                    </select>
                    @if($availableSlots->isEmpty() && $appointment_date && $office_branch)
                        <div class="alert alert-warning mt-2">
                            {{ __('messages.no_available_slots_message') }}
                        </div>
                    @endif
                    @error('appointment_time')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nic_number" class="form-label">{{ __('messages.nic_number') }} *</label>
                    <input type="text" wire:model="nic_number" id="nic_number" class="form-control" required>
                    @error('nic_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 shadow-sm" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        {{ $reschedule_id ? __('messages.reschedule') : __('messages.book_appointment') }}
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin me-1"></i> {{ __('messages.processing') ?? 'Processing...' }}
                    </span>
                </button>
            </form>

            <div class="mt-3">
                <a href="{{ route('appointment.view') }}" class="btn btn-outline-secondary w-100 shadow-sm">
                    <i class="fas fa-list me-1"></i> {{ __('messages.view_my_appointments') }}
                </a>
            </div>
        </div>
    </div>
</div>