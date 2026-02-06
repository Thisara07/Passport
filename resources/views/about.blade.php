@extends('layouts.app')

@section('content')
<!-- About Section -->
<section class="container my-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">{{ __('messages.about_title') }}</h1>
            <div class="underline mx-auto bg-primary mb-3" style="height: 4px; width: 80px;"></div>
        </div>
    </div>
    
    <!-- Mission & Vision -->
    <div class="row mb-5 g-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100 p-4 hover-shadow transition">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-bullseye fs-3"></i>
                        </div>
                        <h3 class="card-title text-primary mb-0 fw-bold">{{ __('messages.our_mission') }}</h3>
                    </div>
                    <p class="card-text text-muted fs-5 leading-relaxed">
                        {{ __('messages.mission_text') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100 p-4 hover-shadow transition">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-eye fs-3"></i>
                        </div>
                        <h3 class="card-title text-primary mb-0 fw-bold">{{ __('messages.our_vision') }}</h3>
                    </div>
                    <p class="card-text text-muted fs-5 leading-relaxed">
                        {{ __('messages.vision_text') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- What We Do -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold text-dark">{{ __('messages.what_we_do') }}</h2>
        </div>
        <div class="col-12">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-calendar-check text-primary mb-3 fs-1"></i>
                            <h5 class="fw-bold mb-3">{{ __('messages.online_appointments') }}</h5>
                            <p class="text-muted small">{{ __('messages.online_appointments_text') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-file-alt text-primary mb-3 fs-1"></i>
                            <h5 class="fw-bold mb-3">{{ __('messages.app_management') }}</h5>
                            <p class="text-muted small">{{ __('messages.app_management_text') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-shield-alt text-primary mb-3 fs-1"></i>
                            <h5 class="fw-bold mb-3">{{ __('messages.secure_platform') }}</h5>
                            <p class="text-muted small">{{ __('messages.secure_payments_text') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-passport text-primary mb-3 fs-1"></i>
                            <h5 class="fw-bold mb-3">{{ __('messages.visa_services') }}</h5>
                            <p class="text-muted small">{{ __('messages.visa_services_text') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-user-cog text-primary mb-3 fs-1"></i>
                            <h5 class="fw-bold mb-3">{{ __('messages.profile_management') }}</h5>
                            <p class="text-muted small">{{ __('messages.profile_management_text') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-headset text-primary mb-3 fs-1"></i>
                            <h5 class="fw-bold mb-3">{{ __('messages.need_help') }}</h5>
                            <p class="text-muted small">{{ __('messages.support_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Features -->
    <div class="row mb-5">
        <div class="col-md-6 order-2 order-md-1">
            <h2 class="fw-bold mb-4">{{ __('messages.key_features') }}</h2>
            <div class="feature-list">
                <div class="d-flex mb-3">
                    <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-1">{{ __('messages.easy_booking') }}</h6>
                        <p class="text-muted small mb-0">{{ __('messages.easy_booking_text') }}</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-language text-primary mt-1 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-1">{{ __('messages.multi_language_support') }}</h6>
                        <p class="text-muted small mb-0">{{ __('messages.multi_language_support_text') }}</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-bell text-warning mt-1 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-1">{{ __('messages.track_status') }}</h6>
                        <p class="text-muted small mb-0">{{ __('messages.real_time_updates_text') }}</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-lock text-danger mt-1 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-1">{{ __('messages.secure_platform') }}</h6>
                        <p class="text-muted small mb-0">{{ __('messages.secure_platform_text') }}</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-mobile-alt text-info mt-1 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-1">{{ __('messages.mobile_friendly') }}</h6>
                        <p class="text-muted small mb-0">{{ __('messages.mobile_friendly_text') }}</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-book-open text-secondary mt-1 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-1">{{ __('messages.comprehensive_guidance') }}</h6>
                        <p class="text-muted small mb-0">{{ __('messages.comprehensive_guidance_text') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 order-1 order-md-2 mb-4 mb-md-0 d-flex align-items-center justify-content-center">
            <div class="p-5 bg-primary bg-opacity-10 rounded-circle">
                <i class="fas fa-info-circle text-primary" style="font-size: 15rem;"></i>
            </div>
        </div>
    </div>

    <!-- Appointment Booking Instructions -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">{{ __('messages.how_to_book') }}</h2>
            <p class="text-muted">{{ __('messages.how_to_book_desc') }}</p>
        </div>
        <div class="col-md-10 mx-auto">
            <div class="accordion shadow-sm border-0" id="appointmentInstructions">
                
                @php
                    $steps = [
                        ['id' => 'One', 'title' => 'step_1_title', 'icon' => 'user-plus'],
                        ['id' => 'Two', 'title' => 'step_2_title', 'icon' => 'map-marker-alt'],
                        ['id' => 'Three', 'title' => 'step_3_title', 'icon' => 'edit'],
                        ['id' => 'Four', 'title' => 'step_4_title', 'icon' => 'check-double'],
                        ['id' => 'Five', 'title' => 'step_5_title', 'icon' => 'calendar-check'],
                    ];
                @endphp

                @foreach($steps as $index => $step)
                    <div class="accordion-item border-0 mb-2 rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="heading{{ $step['id'] }}">
                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }} fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $step['id'] }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $step['id'] }}">
                                <i class="fas fa-{{ $step['icon'] }} text-primary me-3"></i>
                                {{ __('messages.' . $step['title']) }}
                            </button>
                        </h2>
                        <div id="collapse{{ $step['id'] }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $step['id'] }}" data-bs-parent="#appointmentInstructions">
                            <div class="accordion-body bg-white border-top">
                                @if($index === 0)
                                    <ul>
                                        <li>If you're a new user, click on <strong>"Register"</strong> in the navigation menu</li>
                                        <li>Fill in your details: Full Name, Email Address, Contact Number, and Password</li>
                                        <li>If you already have an account, click <strong>"Login"</strong> and enter your credentials</li>
                                        <li>Make sure to use a valid email address for notifications and updates</li>
                                    </ul>
                                @elseif($index === 1)
                                    <ul>
                                        <li>Once logged in, click on <strong>"Appointment"</strong> in the navigation menu</li>
                                        <li>Alternatively, click the <strong>"Book Now"</strong> button on the homepage</li>
                                        <li>You will be directed to the appointment booking form</li>
                                    </ul>
                                @elseif($index === 2)
                                    <ul>
                                        <li><strong>Full Name:</strong> Enter your full name as it appears on official documents</li>
                                        <li><strong>Email:</strong> Provide a valid email for appointment confirmation</li>
                                        <li><strong>Contact Number:</strong> Enter your active phone number</li>
                                        <li><strong>Preferred Date:</strong> Select your preferred appointment date from the calendar</li>
                                        <li><strong>Preferred Time:</strong> Choose a convenient time slot</li>
                                        <li><strong>Service Type:</strong> Select the service you need (New Passport, Renewal, etc.)</li>
                                    </ul>
                                @elseif($index === 3)
                                    <ul>
                                        <li>Double-check all the information you've entered</li>
                                        <li>Ensure your contact details are correct for communication</li>
                                        <li>Click the <strong>"Book Appointment"</strong> button to submit</li>
                                        <li>Wait for the confirmation message</li>
                                    </ul>
                                @elseif($index === 4)
                                    <ul>
                                        <li>You will receive a confirmation message on screen</li>
                                        <li>Check your email for appointment details and reference number</li>
                                        <li>Save or print your appointment confirmation</li>
                                        <li>Prepare the required documents before your appointment date</li>
                                        <li>Arrive 15 minutes early on your appointment day</li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Important Tips -->
            <div class="mt-5 p-4 bg-primary bg-opacity-10 rounded-4 border border-primary border-opacity-25">
                <h5 class="text-primary fw-bold mb-3"><i class="fas fa-lightbulb me-2"></i> {{ __('messages.important_tips') }}</h5>
                <ul class="mb-0 text-muted">
                    <li class="mb-2">{{ __('messages.tip_1') }}</li>
                    <li class="mb-2">{{ __('messages.tip_2') }}</li>
                    <li class="mb-2">{{ __('messages.tip_3') }}</li>
                    <li class="mb-2">{{ __('messages.tip_4') }}</li>
                    <li class="mb-0">{{ __('messages.multi_language_support_text') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="row">
        <div class="col-12 text-center mt-4">
            <h2 class="fw-bold mb-3">{{ __('messages.get_in_touch') }}</h2>
            <p class="text-muted mb-4">{{ __('messages.contact_questions') }}</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 shadow">{{ __('messages.login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-5">{{ __('messages.register') }}</a>
            </div>
        </div>
    </div>
</section>

<style>
    .transition { transition: all 0.3s ease; }
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important; }
    .leading-relaxed { line-height: 1.6; }
    .underline { border-radius: 10px; }
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa !important;
        color: var(--bs-primary) !important;
        box-shadow: none !important;
    }
    .accordion-button:focus {
        box-shadow: none !important;
        border-color: rgba(0,0,0,.125) !important;
    }
</style>
@endsection
