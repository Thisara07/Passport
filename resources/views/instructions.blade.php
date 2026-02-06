@extends('layouts.app')

@section('content')
<section class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4">{{ __('messages.system_guide') }}</h1>
            <p class="text-center text-muted mb-5">{{ __('messages.guide_description') }}</p>
        </div>
    </div>

    <!-- System Background Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-primary mb-4">
                <i class="fas fa-info-circle me-2"></i> {{ __('messages.system_background') }}
            </h2>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">{{ __('messages.about_system') }}</h4>
                    <p class="text-muted">
                        {{ __('messages.system_background_text') }}
                    </p>
                    
                    <h5 class="mt-4 text-primary fw-bold">{{ __('messages.why_we_built') }}</h5>
                    <p class="text-muted">
                        {{ __('messages.why_built_text') }}
                    </p>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item border-0 ps-0"><i class="fas fa-check-circle text-success me-2"></i> <strong>{{ __('messages.digitizing_process') }}</strong></li>
                        <li class="list-group-item border-0 ps-0"><i class="fas fa-check-circle text-success me-2"></i> <strong>{{ __('messages.reducing_waiting') }}</strong></li>
                        <li class="list-group-item border-0 ps-0"><i class="fas fa-check-circle text-success me-2"></i> <strong>{{ __('messages.improving_efficiency') }}</strong></li>
                        <li class="list-group-item border-0 ps-0"><i class="fas fa-check-circle text-success me-2"></i> <strong>{{ __('messages.enhancing_accessibility') }}</strong></li>
                        <li class="list-group-item border-0 ps-0"><i class="fas fa-check-circle text-success me-2"></i> <strong>{{ __('messages.ensuring_transparency') }}</strong></li>
                    </ul>

                    <h5 class="mt-4 text-primary fw-bold">{{ __('messages.system_architecture') }}</h5>
                    <p class="text-muted">
                        {{ __('messages.system_architecture_text') }}
                    </p>
                    <div class="row mt-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="p-3 bg-light rounded text-center mb-3 h-100">
                                <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">{{ __('messages.secure_authentication') }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="p-3 bg-light rounded text-center mb-3 h-100">
                                <i class="fas fa-database fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">{{ __('messages.reliable_database') }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="p-3 bg-light rounded text-center mb-3 h-100">
                                <i class="fas fa-mobile-alt fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">{{ __('messages.responsive_design') }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="p-3 bg-light rounded text-center mb-3 h-100">
                                <i class="fas fa-language fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">{{ __('messages.multi_language_support') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Overview Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-primary mb-4">
                <i class="fas fa-briefcase me-2"></i> {{ __('messages.services_overview') }}
            </h2>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">{{ __('messages.available_services') }}</h4>
                    <div class="accordion" id="servicesAccordion">
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                            <h2 class="accordion-header">
                                <button class="accordion-button rounded" type="button" data-bs-toggle="collapse" data-bs-target="#service1">
                                    <strong class="text-primary">1. {{ __('messages.appointment_scheduling') }}</strong>
                                </button>
                            </h2>
                            <div id="service1" class="accordion-collapse collapse show" data-bs-parent="#servicesAccordion">
                                <div class="accordion-body">
                                    <p>{{ __('messages.appointment_scheduling_description') }}</p>
                                    <ul>
                                        <li>Select preferred date and time slots</li>
                                        <li>Instant confirmation</li>
                                        <li>Manage your booking online</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Add more accordion items as needed, mirroring the old system -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How the Process Works -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-primary mb-4">
                <i class="fas fa-project-diagram me-2"></i> {{ __('messages.how_process_works') }}
            </h2>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">{{ __('messages.process_phases') }}</h4>
                    <div class="row g-4">
                        @php
                            $phases = [
                                ['icon' => 'fa-user-plus', 'key' => 'phase_1_registration'],
                                ['icon' => 'fa-calendar-check', 'key' => 'phase_2_booking'],
                                ['icon' => 'fa-file-invoice', 'key' => 'phase_3_documents'],
                                ['icon' => 'fa-id-card', 'key' => 'phase_4_attendance'],
                                ['icon' => 'fa-cog', 'key' => 'phase_5_processing'],
                                ['icon' => 'fa-truck', 'key' => 'phase_6_delivery'],
                            ];
                        @endphp
                        @foreach($phases as $phase)
                        <div class="col-md-4">
                            <div class="p-3 border-start border-primary border-4 bg-light rounded h-100">
                                <h5 class="text-primary d-flex align-items-center mb-2">
                                    <i class="fas {{ $phase['icon'] }} me-2"></i>
                                    {{ __('messages.' . $phase['key']) }}
                                </h5>
                                <p class="small text-muted mb-0">Step-by-step guidance for this phase.</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Instructions -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-primary mb-4">
                <i class="fas fa-list-ol me-2"></i> {{ __('messages.booking_steps') }}
            </h2>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="timeline">
                        <!-- Step 1, 2, 3 ... -->
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary">Step 1: Create an Account or Login</h5>
                            <p class="text-muted ms-4">Ensure you have a valid account to start the process.</p>
                        </div>
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary">Step 2: Fill in Details & Choose Slot</h5>
                            <p class="text-muted ms-4">Provide accurate information and select your preferred branch and time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Documents -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-primary mb-4">
                <i class="fas fa-file-alt me-2"></i> {{ __('messages.required_docs') }}
            </h2>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded">
                                <h5 class="fw-bold text-primary">For New Passport</h5>
                                <ul class="mb-0">
                                    <li>National Identity Card (original & copy)</li>
                                    <li>Birth Certificate</li>
                                    <li>Passport Photos (Color)</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded">
                                <h5 class="fw-bold text-primary">For Passport Renewal</h5>
                                <ul class="mb-0">
                                    <li>Current Passport</li>
                                    <li>National Identity Card</li>
                                    <li>Proof of Residence</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-primary mb-4">
                <i class="fas fa-question-circle me-2"></i> {{ __('messages.faq') }}
            </h2>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-2 shadow-sm rounded">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <strong>How long does it take to get an appointment?</strong>
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Appointment availability varies. Typically, you can book appointments 2-4 weeks in advance. We recommend booking as early as possible for better time slot selection.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-2 shadow-sm rounded">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <strong>Can I reschedule my appointment?</strong>
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Yes, you can reschedule your appointment through your profile page. Please do so at least 48 hours before your scheduled appointment to avoid cancellation fees.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0 bg-primary text-white text-center p-5">
                <div class="card-body">
                    <h2 class="fw-bold mb-3">{{ __('messages.ready_to_start') }}</h2>
                    <p class="lead mb-4">{{ __('messages.create_account_today') }}</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">{{ __('messages.register') }}</a>
                        <a href="{{ route('appointment') }}" class="btn btn-outline-light btn-lg px-4">{{ __('messages.book_now') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        box-shadow: none;
    }
    .timeline {
        border-left: 2px solid #007bff;
        padding-left: 20px;
        position: relative;
    }
    .list-group-item i {
        width: 25px;
    }
</style>
@endsection
