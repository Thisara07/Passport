@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>System Settings</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>General Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="site_name" class="form-label">Site Name</label>
                            <input type="text" name="site_name" id="site_name" class="form-control" 
                                   value="{{ $settings['site_name'] }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="admin_email" class="form-label">Admin Email</label>
                            <input type="email" name="admin_email" id="admin_email" class="form-control" 
                                   value="{{ $settings['admin_email'] }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="max_applications_per_day" class="form-label">Max Applications Per Day</label>
                            <input type="number" name="max_applications_per_day" id="max_applications_per_day" 
                                   class="form-control" min="1" max="1000" 
                                   value="{{ $settings['max_applications_per_day'] }}" required>
                            <div class="form-text">Maximum number of applications allowed per day</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="appointment_interval" class="form-label">Appointment Interval (minutes)</label>
                            <select name="appointment_interval" id="appointment_interval" class="form-control" required>
                                <option value="15" {{ $settings['appointment_interval'] == 15 ? 'selected' : '' }}>15 minutes</option>
                                <option value="30" {{ $settings['appointment_interval'] == 30 ? 'selected' : '' }}>30 minutes</option>
                                <option value="60" {{ $settings['appointment_interval'] == 60 ? 'selected' : '' }}>60 minutes</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Save Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>System Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                    <p><strong>PHP Version:</strong> {{ phpversion() }}</p>
                    <p><strong>Server Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
                    <p><strong>Environment:</strong> {{ app()->environment() }}</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-info">
                            <i class="bi bi-bar-chart me-2"></i>View Reports
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-secondary" target="_blank">
                            <i class="bi bi-house-door me-2"></i>Frontend
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection