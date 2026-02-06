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
        <!-- Main Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Passport System') }}</a>

                <!-- Search Form -->
                <form method="GET" action="{{ url('/') }}" style="width: 300px;" class="d-flex ms-auto">
                    <input type="hidden" name="controller" value="search">
                    <input type="hidden" name="action" value="index">
                    <input name="q" class="form-control form-control-sm" type="search" placeholder="Search..." value="{{ request('q') }}">
                    <button class="btn btn-sm btn-dark ms-2" type="submit">Search</button>
                </form>

                <!-- Language Selector -->
                <form method="GET" action="{{ request()->url() }}" style="display: inline;">
                    @foreach(request()->except('lang') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="lang" class="form-select form-select-sm ms-3" style="width: 110px;" onchange="console.log('Language changed to: ' + this.value); this.form.submit()">
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
                        <option value="si" {{ app()->getLocale() == 'si' ? 'selected' : '' }}>{{ __('messages.sinhala') }}</option>
                        <option value="ta" {{ app()->getLocale() == 'ta' ? 'selected' : '' }}>{{ __('messages.tamil') }}</option>
                    </select>
                </form>

                <!-- Chatbot Button -->
                <button id="chatbot-toggle" class="ms-3 bg-white rounded-full p-2 hover:bg-gray-100 transition duration-200" style="display: inline-block; border-radius: 50%; width: 35px; height: 35px; text-align: center; cursor: pointer;" title="Open Chatbot">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </button>

                <!-- Profile Icon -->
                @auth
                    <a href="{{ route('profile') }}" class="ms-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->Name ?? Auth::user()->Email_Address) }}&background=0D8ABC&color=fff" 
                             alt="Profile"
                             style="width:35px; height:35px; border-radius:50%; object-fit:cover;">
                    </a>
                @endauth

                <!-- Mobile toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#secondaryNavbar" aria-controls="secondaryNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <!-- Secondary Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary collapse" id="secondaryNavbar">
            <div class="container">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                    <!-- DEBUG: Home translation: {{ __('messages.home') }} -->
                    <li class="nav-item mx-2"><a class="nav-link" href="#">{{ __('messages.about') }}</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('appointment') }}">{{ __('messages.appointment') }}</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ route('application') }}">{{ __('messages.application') }}</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">{{ __('messages.passport') }}</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">{{ __('messages.payment') }}</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">{{ __('messages.instructions') }}</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">{{ __('messages.contact') }}</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="#">{{ __('messages.feedback') }}</a></li>
                    
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item mx-2">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item mx-2">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown mx-2">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->Name ?? Auth::user()->Email_Address }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('messages.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest

                    <!-- Admin Dashboard Link -->
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item mx-2">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </nav>

        <!-- Chatbot Side Panel -->
        <div id="chatbot-panel" style="position: fixed; top: 0; right: -400px; width: 350px; height: 100vh; background-color: white; box-shadow: -2px 0 10px rgba(0,0,0,0.1); z-index: 10000; transition: right 0.3s ease; display: flex; flex-direction: column;">
            <div style="background-color: #2563eb; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0;">{{ __('messages.passport_assistant') }}</h3>
                <button id="chatbot-close" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">×</button>
            </div>
            <div style="flex: 1; padding: 15px; overflow-y: auto;">
                <p>{{ __('messages.welcome_passport_assistant') }}</p>
                <!-- Chatbot content would go here -->
            </div>
        </div>

        <!-- Overlay for when chatbot is open -->
        <div id="chatbot-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: none;"></div>

        <!-- Floating Contact Icon -->
        <a href="#" class="floating-contact" title="Contact Support">
            <i class="fas fa-headset"></i>
        </a>

        <main class="py-4">
            @yield('content')
            {{ $slot ?? '' }}
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

        // Event listeners
        if(chatbotToggle) chatbotToggle.addEventListener('click', openChatbot);
        if(chatbotClose) chatbotClose.addEventListener('click', closeChatbot);
        if(chatbotOverlay) chatbotOverlay.addEventListener('click', closeChatbot);
    });
    </script>
</body>
</html>