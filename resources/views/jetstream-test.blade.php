<!DOCTYPE html>
<html>
<head>
    <title>Jetstream Livewire Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">Jetstream Livewire Integration Test</h1>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Application Form Test</h3>
                    </div>
                    <div class="card-body">
                        @livewire('application-form')
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Appointment Scheduler Test</h3>
                    </div>
                    <div class="card-body">
                        @livewire('appointment-scheduler')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @livewireScripts
</body>
</html>