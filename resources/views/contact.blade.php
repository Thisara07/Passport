@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4">{{ __('messages.contact') }}</h1>
            <p class="text-center text-muted mb-5">We're here to help you with any questions or concerns</p>
        </div>
    </div>

    <div class="row">
        <!-- Contact Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100 p-4">
                <h3 class="text-primary mb-4">{{ __('messages.contact_info') }}</h3>
                <div class="mt-2">
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-map-marker-alt fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">{{ __('messages.address') }}</h5>
                            <p class="mb-0 text-muted">Passport Office<br>Colombo, Sri Lanka</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-phone-alt fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">{{ __('messages.phone') }}</h5>
                            <p class="mb-0 text-muted">+94 11 242 1234</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-envelope fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">{{ __('messages.email') }}</h5>
                            <p class="mb-0 text-muted">support@passport.gov.lk</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-clock fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">{{ __('messages.working_hours') }}</h5>
                            <p class="mb-0 text-muted">{!! __('messages.hours_details') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100 p-4">
                <h3 class="text-primary mb-4">{{ __('messages.send_message') }}</h3>
                <form class="mt-2">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">{{ __('messages.full_name') }}</label>
                        <input type="text" class="form-control" id="name" placeholder="{{ __('messages.enter_full_name') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">{{ __('messages.email') }}</label>
                        <input type="email" class="form-control" id="email" placeholder="{{ __('messages.enter_email') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="subject" class="form-label fw-bold">{{ __('messages.subject') }}</label>
                        <input type="text" class="form-control" id="subject" placeholder="{{ __('messages.enter_subject') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label fw-bold">{{ __('messages.message') }}</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="{{ __('messages.enter_message') }}"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">{{ __('messages.send_message_btn') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
