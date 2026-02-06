<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- DEBUG: Current locale is {{ app()->getLocale() }} -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Passport System') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireStyles
    <style>
        .floating-contact {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .floating-contact:hover {
            transform: scale(1.1);
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-2" style="z-index: 1050;">

            <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
                
                <!-- Left Side: Language, Chatbot & User Profile / Auth -->
                <div class="d-none d-lg-flex align-items-center justify-content-start" style="flex: 1; gap: 10px;">
                    <!-- Language Selector -->
                    <div class="dropdown">
                        <form method="GET" action="{{ request()->url() }}">
                            @foreach(request()->except('lang') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="lang" class="form-select form-select-sm border-0 bg-transparent text-white fw-bold" style="width: auto; cursor: pointer; padding-right: 25px;" onchange="this.form.submit()">
                                <option value="en" class="text-dark" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>EN</option>
                                <option value="si" class="text-dark" {{ app()->getLocale() == 'si' ? 'selected' : '' }}>SI</option>
                                <option value="ta" class="text-dark" {{ app()->getLocale() == 'ta' ? 'selected' : '' }}>TA</option>
                            </select>
                        </form>
                    </div>

                    <!-- Chatbot Button -->
                    <button id="chatbot-toggle" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;" title="Open Chatbot">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </button>

                    <!-- Auth Dropdown -->
                    @auth
                        <div class="d-flex align-items-center gap-3 ps-2">
                            {{-- Direct Profile Link --}}
                            <a href="{{ route('profile') }}" class="d-flex align-items-center text-decoration-none" title="Go to Profile">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->Name ?? auth()->user()->name ?? auth()->user()->Email ?? auth()->user()->Email_Address ?? auth()->user()->email ?? 'User') }}&background=0D8ABC&color=fff" 
                                     alt="Profile"
                                     class="rounded-circle border border-2 border-white"
                                     style="width: 36px; height: 36px; min-width: 36px; object-fit: cover;">
                                <span class="text-white fw-bold ms-2">{{ auth()->user()->Name ?? auth()->user()->name ?? 'User' }}</span>
                            </a>

                            {{-- Admin Panel Link --}}
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-light" title="Admin Panel">
                                    <i class="fas fa-user-shield"></i>
                                </a>
                            @endif

                            {{-- Logout Button --}}
                            <a href="{{ route('logout') }}" class="btn btn-sm btn-danger text-white" title="Logout"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-2">
                            <a class="btn btn-sm btn-light text-primary fw-bold px-3 shadow-sm" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                            <a class="btn btn-sm btn-outline-light fw-bold px-3" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                        </div>
                    @endauth
                </div>

                <!-- Navbar Links (Centered) -->
                <div class="d-flex justify-content-center" style="flex: 2;">
                    <!-- Mobile Toggler -->
                    <button class="navbar-toggler me-auto d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <ul class="navbar-nav d-none d-lg-flex flex-row align-items-center mb-0 gap-3">
                        <li class="nav-item"><a class="nav-link px-2 text-white fw-bold" href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-white fw-bold" href="{{ route('about') }}">{{ __('messages.about') }}</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-white fw-bold" href="{{ route('appointment') }}">{{ __('messages.appointment') }}</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-white fw-bold" href="{{ route('application') }}">{{ __('messages.application') }}</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-white fw-bold" href="{{ route('instructions') }}">{{ __('messages.instructions') }}</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-white fw-bold" href="{{ route('contact') }}">{{ __('messages.contact') }}</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-white fw-bold" href="{{ route('feedback') }}">{{ __('messages.feedback') }}</a></li>
                    </ul>
                </div>

                <!-- Mobile Menu (Collapsible) -->
                <div class="collapse navbar-collapse d-lg-none width-100" id="mobileMenu">
                    <ul class="navbar-nav p-3 bg-primary w-100">
                        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('about') }}">{{ __('messages.about') }}</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('appointment') }}">{{ __('messages.appointment') }}</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('application') }}">{{ __('messages.application') }}</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('instructions') }}">{{ __('messages.instructions') }}</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('contact') }}">{{ __('messages.contact') }}</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('feedback') }}">{{ __('messages.feedback') }}</a></li>
                    </ul>
                </div>

                <!-- Right Side (empty now, elements moved to left) -->
                <div class="d-none d-lg-flex align-items-center justify-content-end" style="flex: 1;">
                </div>
            </div>
        </nav>

        <!-- Chatbot Side Panel -->
        <div id="chatbot-panel" style="position: fixed; top: 0; right: -400px; width: 350px; height: 100vh; background-color: white; box-shadow: -2px 0 10px rgba(0,0,0,0.1); z-index: 10000; transition: right 0.3s ease; display: flex; flex-direction: column;">
            <div style="background-color: #2563eb; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.25rem;">{{ __('messages.passport_assistant') }}</h3>
                <button id="chatbot-close" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            
            <!-- Chat Messages Area -->
            <div id="chatbot-messages" style="flex: 1; padding: 15px; overflow-y: auto; background-color: #f8fafc; display: flex; flex-direction: column; gap: 10px;">
                <div class="bot-message" style="background-color: #dbeafe; color: #1e40af; padding: 10px 15px; border-radius: 15px 15px 15px 2px; align-self: flex-start; max-width: 85%; font-size: 0.95rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    {{ __('messages.welcome_passport_assistant') }}
                </div>
            </div>

            <!-- Input Area -->
            <div style="padding: 15px; border-top: 1px solid #e2e8f0; background: white;">
                <div class="input-group">
                    <input type="text" id="chatbot-input" class="form-control" placeholder="Type your message..." style="border-radius: 20px 0 0 20px; border-right: none;">
                    <button class="btn btn-primary" id="chatbot-send" style="border-radius: 0 20px 20px 0; padding-left: 20px; padding-right: 20px;">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Overlay for when chatbot is open -->
        <div id="chatbot-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: none;"></div>

        <!-- Floating Contact Icon -->
        <a href="#" class="floating-contact" title="Contact Support">
            <i class="fas fa-headset"></i>
        </a>

        <main class="py-4">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-3 fs-4"></i>
                        <div>
                            <strong>{{ __('messages.success') }}!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div>
                            <strong>{{ __('messages.error') }}!</strong> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            @yield('content')
            @if(isset($slot) && is_string($slot))
                {{ $slot }}
            @endif
        </main>
    </div>
    
    <footer class="footer bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ config('app.name', 'Passport System') }}</h5>
                    <p>{{ __('messages.trusted_partner_message') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2026 {{ config('app.name', 'Passport System') }}. {{ __('messages.all_rights_reserved') }}</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    
    <!-- Chatbot JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatbotToggle = document.getElementById('chatbot-toggle');
        const chatbotPanel = document.getElementById('chatbot-panel');
        const chatbotClose = document.getElementById('chatbot-close');
        const chatbotOverlay = document.getElementById('chatbot-overlay');
        const chatbotInput = document.getElementById('chatbot-input');
        const chatbotSend = document.getElementById('chatbot-send');
        const chatbotMessages = document.getElementById('chatbot-messages');

        // Function to open chatbot
        function openChatbot() {
            chatbotPanel.style.right = '0';
            chatbotOverlay.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        // Function to close chatbot
        function closeChatbot() {
            chatbotPanel.style.right = '-400px';
            chatbotOverlay.style.display = 'none';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }

        // Function to add message to chat
        function addMessage(sender, text) {
            const msgDiv = document.createElement('div');
            msgDiv.style.padding = '10px 15px';
            msgDiv.style.borderRadius = '15px';
            msgDiv.style.maxWidth = '85%';
            msgDiv.style.fontSize = '0.95rem';
            msgDiv.style.boxShadow = '0 1px 2px rgba(0,0,0,0.05)';
            msgDiv.style.marginBottom = '5px';

            if (sender === 'user') {
                msgDiv.style.backgroundColor = '#2563eb';
                msgDiv.style.color = 'white';
                msgDiv.style.alignSelf = 'flex-end';
                msgDiv.style.borderBottomRightRadius = '2px';
            } else {
                msgDiv.style.backgroundColor = '#dbeafe';
                msgDiv.style.color = '#1e40af';
                msgDiv.style.alignSelf = 'flex-start';
                msgDiv.style.borderBottomLeftRadius = '2px';
            }

            msgDiv.textContent = text;
            chatbotMessages.appendChild(msgDiv);
            
            // Auto scroll to bottom
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }

        // Function to send message to backend
        function sendMessage() {
            const message = chatbotInput.value.trim();
            if (!message) return;

            // Add user message to UI
            addMessage('user', message);
            chatbotInput.value = '';

            // Add thinking indicator
            const thinkingId = 'thinking-' + Date.now();
            const thinkingDiv = document.createElement('div');
            thinkingDiv.id = thinkingId;
            thinkingDiv.style.padding = '10px 15px';
            thinkingDiv.style.backgroundColor = '#f1f5f9';
            thinkingDiv.style.color = '#64748b';
            thinkingDiv.style.borderRadius = '15px 15px 15px 2px';
            thinkingDiv.style.alignSelf = 'flex-start';
            thinkingDiv.style.fontSize = '0.9rem';
            thinkingDiv.textContent = 'Assistant is typing...';
            chatbotMessages.appendChild(thinkingDiv);
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;

            // Send AJAX request
            fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                // Remove thinking indicator
                const indicator = document.getElementById(thinkingId);
                if (indicator) indicator.remove();
                
                // Add bot response to UI
                addMessage('bot', data.reply);
            })
            .catch(error => {
                // Remove thinking indicator
                const indicator = document.getElementById(thinkingId);
                if (indicator) indicator.remove();
                
                addMessage('bot', 'Sorry, I encountered an error. Please try again.');
                console.error('Chatbot Error:', error);
            });
        }

        // Event listeners
        if(chatbotToggle) chatbotToggle.addEventListener('click', openChatbot);
        if(chatbotClose) chatbotClose.addEventListener('click', closeChatbot);
        if(chatbotOverlay) chatbotOverlay.addEventListener('click', closeChatbot);
        if(chatbotSend) chatbotSend.addEventListener('click', sendMessage);
        if(chatbotInput) {
            chatbotInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        }
    });
    </script>
</body>
</html>
