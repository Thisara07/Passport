@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white p-4">
                    <h3 class="mb-0 fw-bold">{{ __('messages.feedback_suggestions') }}</h3>
                </div>
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Please fix the errors below:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <p class="lead text-muted mb-5">{{ __('messages.feedback_description') }}</p>
                    
                    <!-- Display existing feedback entries -->
                    <div class="feedback-section mb-5">
                        <h4 class="fw-bold mb-4 text-primary border-bottom pb-2">
                            <i class="fas fa-comments me-2"></i> {{ __('messages.recent_feedback') }}
                        </h4>
                        @if($feedback_entries->count() > 0)
                            <div class="row">
                                @foreach($feedback_entries as $feedback)
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-0 shadow-sm bg-light">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title fw-bold text-primary mb-0">{{ $feedback->Subject }}</h6>
                                                    <small class="text-muted">{{ $feedback->created_at->format('M j, Y') }}</small>
                                                </div>
                                                <div class="mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $feedback->Rating)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-muted"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p class="card-text text-muted mb-3 italic">"{{ $feedback->Message }}"</p>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; font-size: 10px;">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <small class="fw-bold">{{ __('messages.by') ?? 'By' }}: {{ $feedback->Name }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 bg-light rounded">
                                <p class="text-muted mb-0">{{ __('messages.no_feedback_yet') }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <hr class="my-5">
                    
                    <!-- Feedback submission form -->
                    <div id="feedback-form-section">
                        <h4 class="fw-bold mb-4 text-primary border-bottom pb-2">
                            <i class="fas fa-paper-plane me-2"></i> {{ __('messages.share_feedback') }}
                        </h4>
                        <form method="POST" action="{{ route('feedback.store') }}" class="mt-4">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold">{{ __('messages.full_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">{{ __('messages.email') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="subject" class="form-label fw-bold">{{ __('messages.subject') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="rating" class="form-label fw-bold">{{ __('messages.rating') ?? 'Rating' }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                        <option value="">{{ __('messages.select_rating') }}</option>
                                        <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 - {{ __('messages.very_poor') }}</option>
                                        <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 - {{ __('messages.poor') }}</option>
                                        <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 - {{ __('messages.average') }}</option>
                                        <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 - {{ __('messages.good') }}</option>
                                        <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5 - {{ __('messages.excellent') }}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="message" class="form-label fw-bold">{{ __('messages.feedback_suggestions') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" placeholder="{{ __('messages.feedback_placeholder') }}" required>{{ old('message') }}</textarea>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 shadow-sm">
                                    <i class="fas fa-check-circle me-2"></i> {{ __('messages.submit_feedback') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
