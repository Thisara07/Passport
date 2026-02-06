@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero d-flex align-items-center justify-content-center"
    style="background-image: url('{{ asset('images/p1.jpg') }}');
           height: 450px;
           background-size: cover;
           background-position: center;
           background-repeat: no-repeat;">
    
    <div class="hero-overlay text-center" 
     style="background: rgba(0, 0, 0, 0.4); padding: 40px; border-radius: 10px; color: white;">
    
    <h1 class="display-4 fw-bold mb-3">{{ __('messages.welcome_to_passport_system') }}</h1>
    <p class="lead mb-4">{{ __('messages.book_manage_appointments') }}</p>

    <a href="{{ route('appointment') }}" class="btn btn-primary btn-lg px-5 shadow">{{ __('messages.book_now') }}</a>

</div>

</section>

<!-- Services Section -->
<section class="container my-5">
    <div class="row g-4">

        <!-- Service Card 1: Appointment -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-3 service-card">
                <div class="card-body">
                    <img src="{{ asset('images/appointment.jpg') }}" alt="{{ __('messages.appointment') }}"
                         style="width:80px; height:80px; object-fit:cover; border-radius:50%; margin-bottom:1rem;" class="mx-auto">
                    <h4 class="card-title fw-bold">{{ __('messages.appointment') }}</h4>
                    <p class="card-text text-muted">{{ __('messages.book_manage_appointments') }}</p>
                    <a href="{{ route('appointment') }}" class="btn btn-outline-primary mt-auto text-decoration-none">{{ __('messages.book_now') }}</a>
                </div>
            </div>
        </div>

        <!-- Service Card 2: Passport -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-3 service-card">
                <div class="card-body">
                    <img src="{{ asset('images/passport.jpg') }}" alt="{{ __('messages.passport') }}"
                         style="width:80px; height:80px; object-fit:cover; border-radius:50%; margin-bottom:1rem;" class="mx-auto">
                    <h4 class="card-title fw-bold">{{ __('messages.passport') }}</h4>
                    <p class="card-text text-muted">{{ __('messages.passport_info') }}</p>
                    <a href="#" class="btn btn-outline-primary mt-auto text-decoration-none">{{ __('messages.book_now') }}</a>
                </div>
            </div>
        </div>

        <!-- Service Card 3: Instructions -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-3 service-card">
                <div class="card-body">
                    <img src="{{ asset('images/instructions.jpg') }}" alt="{{ __('messages.instructions') }}"
                         style="width:80px; height:80px; object-fit:cover; border-radius:50%; margin-bottom:1rem;" class="mx-auto">
                    <h4 class="card-title fw-bold">{{ __('messages.instructions') }}</h4>
                    <p class="card-text text-muted">{{ __('messages.instructions_info') }}</p>
                    <a href="#" class="btn btn-outline-primary mt-auto text-decoration-none">{{ __('messages.book_now') }}</a>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
    .service-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick chatbot button functionality
    const quickChatbotBtn = document.getElementById('quick-chatbot');
    const mainChatbotBtn = document.getElementById('chatbot-toggle');
    
    if(quickChatbotBtn) {
        quickChatbotBtn.addEventListener('click', function() {
            // Trigger the main chatbot toggle if it exists
            if(mainChatbotBtn) {
                mainChatbotBtn.click();
            } else {
                alert('Chatbot feature coming soon!');
            }
        });
    }
});
</script>
@endsection