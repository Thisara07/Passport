@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="card shadow p-4">
        <h3 class="text-center mb-4">{{ __('messages.passport_application') }}</h3>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($hasAppointment)
            <form id="applicationForm" action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">{{ __('messages.full_name') }} *</label>
                            <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gender" class="form-label">{{ __('messages.gender') }} *</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="">{{ __('messages.select_gender') }}</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>{{ __('messages.male') }}</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>{{ __('messages.female') }}</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>{{ __('messages.other') }}</option>
                            </select>
                            @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dob" class="form-label">{{ __('messages.date_of_birth') }} *</label>
                            <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}" required>
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('messages.phone_number') }} *</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">{{ __('messages.address') }} *</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="street" class="form-label">{{ __('messages.street') }} *</label>
                            <input type="text" name="street" id="street" class="form-control" value="{{ old('street') }}" required>
                            @error('street')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="city" class="form-label">{{ __('messages.city') }} *</label>
                            <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" required>
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="province" class="form-label">{{ __('messages.province') }} *</label>
                            <input type="text" name="province" id="province" class="form-control" value="{{ old('province') }}" required>
                            @error('province')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- NIC Number Field -->
                <div class="mb-3">
                    <label for="nic_number" class="form-label">{{ __('messages.nic_number') }} *</label>
                    <input type="text" name="nic_number" id="nic_number" class="form-control" value="{{ old('nic_number') }}" required>
                    @error('nic_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nic_file" class="form-label">{{ __('messages.nic_card') }} (PDF/JPG/PNG) *</label>
                    <input type="file" name="nic_file" id="nic_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    @error('nic_file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="birth_file" class="form-label">{{ __('messages.birth_certificate') }} (PDF/JPG/PNG) *</label>
                    <input type="file" name="birth_file" id="birth_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    @error('birth_file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="photo_file" class="form-label">{{ __('messages.passport_photo') }} (JPG/PNG) *</label>
                    <input type="file" name="photo_file" id="photo_file" class="form-control" accept=".jpg,.jpeg,.png" required>
                    @error('photo_file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">{{ __('messages.submit_application') }}</button>
            </form>
        @else
            <div class="text-center">
                <h4>{{ __('messages.book_appointment_first') }}</h4>
                <p class="lead">{{ __('messages.appointment_required_message') }}</p>
                <a href="{{ route('appointment') }}" class="btn btn-primary btn-lg">{{ __('messages.book_appointment') }}</a>
            </div>
        @endif
    </div>
</div>
@endsection