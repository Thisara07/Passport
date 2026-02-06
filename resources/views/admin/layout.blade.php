<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 60px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .nav-link {
            color: rgba(255,255,255,0.7);
        }
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        .stat-card {
            border-left: 4px solid;
        }
        .stat-card.pending { border-color: #ffc107; }
        .stat-card.approved { border-color: #28a745; }
        .stat-card.rejected { border-color: #dc3545; }
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header shadow-sm">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">{{ __('messages.admin_dashboard') }}</h1>
                    <p class="mb-0 opacity-75">Manage your passport system</p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-3">{{ __('messages.welcome') }}, {{ Auth::guard('admin')->user()->Email_Address }}</span>
                    
                    <!-- Language Selector -->
                    <form method="GET" action="{{ url()->current() }}" style="display: inline; margin-right: 10px;">
                        <input type="hidden" name="controller" value="{{ request('controller', 'index') }}">
                        <input type="hidden" name="action" value="{{ request('action', 'index') }}">
                        @if(request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif
                        <select name="lang" class="form-select form-select-sm" style="width: 110px;" onchange="this.form.submit()">
                            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
                            <option value="si" {{ app()->getLocale() == 'si' ? 'selected' : '' }}>{{ __('messages.sinhala') }}</option>
                            <option value="ta" {{ app()->getLocale() == 'ta' ? 'selected' : '' }}>{{ __('messages.tamil') }}</option>
                        </select>
                    </form>
                    
                    <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm me-2">
                        <i class="bi bi-house-door"></i> {{ __('messages.frontend') }}
                    </a>
                    <a href="{{ route('admin.profile') }}" class="btn btn-outline-light btn-sm me-2">
                        <i class="bi bi-person-circle"></i> {{ __('messages.profile') ?? 'Profile' }}
                    </a>
                    <a href="{{ route('admin.logout') }}" 
                       class="btn btn-outline-light btn-sm"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> {{ __('messages.logout') }}
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="text-white text-center mb-4">
            <h4>{{ __('messages.admin_panel') }}</h4>
            <small>{{ Auth::guard('admin')->user()->Email_Address }}</small>
                        <div class="mt-2">
                            <form method="GET" action="{{ url()->current() }}" style="display: inline;">
                                <input type="hidden" name="controller" value="{{ request('controller', 'index') }}">
                                <input type="hidden" name="action" value="{{ request('action', 'index') }}">
                                @if(request('q'))
                                    <input type="hidden" name="q" value="{{ request('q') }}">
                                @endif
                                <select name="lang" class="form-select form-select-sm" style="width: 100px;" onchange="this.form.submit()">
                                    <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
                                    <option value="si" {{ app()->getLocale() == 'si' ? 'selected' : '' }}>{{ __('messages.sinhala') }}</option>
                                    <option value="ta" {{ app()->getLocale() == 'ta' ? 'selected' : '' }}>{{ __('messages.tamil') }}</option>
                                </select>
                            </form>
                        </div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> {{ __('messages.dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}" 
                   href="{{ route('admin.applications.index') }}">
                    <i class="bi bi-file-earmark-text me-2"></i> {{ __('messages.application_management') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}" 
                   href="{{ route('admin.documents.index') }}">
                    <i class="bi bi-file-text me-2"></i> {{ __('messages.document_verification') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}" 
                   href="{{ route('admin.appointments.index') }}">
                    <i class="bi bi-calendar-check me-2"></i> {{ __('messages.appointment_management') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                   href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people me-2"></i> {{ __('messages.user_management') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                   href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-bar-chart me-2"></i> {{ __('messages.reports_analytics') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
                   href="{{ route('admin.settings.index') }}">
                    <i class="bi bi-gear me-2"></i> {{ __('messages.system_settings') }}
                </a>
            </li>
            <li class="nav-item mt-4">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="bi bi-house-door me-2"></i> {{ __('messages.frontend') ?? 'Frontend' }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>