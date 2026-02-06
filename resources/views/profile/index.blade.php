@extends('layouts.app')

@section('content')
<div class="hero">
    <div class="hero-content fade-in">
        <h1>My Profile</h1>
        <p>Manage your personal information and account settings securely.</p>
    </div>
</div>

<div class="container">
    <div class="profile-header fade-in">
        <div class="profile-avatar">
            {{ substr($user->Name, 0, 1) }}
        </div>
        <div class="profile-info">
            <h2>{{ $user->Name }}</h2>
            <p>{{ $user->Email }}</p>
            <span class="badge badge-info">Applicant</span>
        </div>
        <div class="profile-actions ms-auto">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card fade-in" style="animation-delay: 0.1s">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar text-primary me-2"></i>Quick Stats</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Applications:</span>
                        <strong>{{ $applications->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Appointments:</span>
                        <strong>{{ $appointments->count() }}</strong>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span>Applications:</span>
                        <strong>{{ $applications->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Appointments:</span>
                        <strong>{{ $appointments->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card fade-in" style="animation-delay: 0.2s">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-edit text-primary me-2"></i>Edit Profile</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name', $user->Name) }}" required placeholder="Enter your full name">
                            @error('name')
                                <div class="alert alert-danger mt-2 mb-0">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ old('email', $user->Email) }}" required placeholder="Enter your email address">
                            @error('email')
                                <div class="alert alert-danger mt-2 mb-0">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter current password to make changes">
                            <div class="form-text">Required only if changing password</div>
                            @error('current_password')
                                <div class="alert alert-danger mt-2 mb-0">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password">
                            @error('new_password')
                                <div class="alert alert-danger mt-2 mb-0">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- Two-Factor Authentication Card --}}
            <div class="card mt-4 fade-in" style="animation-delay: 0.25s">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shield-alt text-primary me-2"></i>Two-Factor Authentication</h3>
                </div>
                <div class="card-body">
                    <div id="twoFactorContent">
                        @if(auth()->user()->two_factor_secret)
                            {{-- 2FA is Enabled --}}
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>Two-Factor Authentication is <strong>enabled</strong>. Your account is protected.
                            </div>
                            
                            <div class="mb-3">
                                <h5>Recovery Codes</h5>
                                <p class="text-muted">Store these recovery codes in a secure location. They can be used to recover access to your account if your two-factor authentication device is lost.</p>
                                <div class="recovery-codes bg-light p-3 rounded mb-3" style="font-family: monospace;">
                                    @if(auth()->user()->two_factor_recovery_codes)
                                        @foreach(json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                            <div>{{ $code }}</div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" onclick="regenerateRecoveryCodes()" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-sync me-1"></i>Regenerate Recovery Codes
                                </button>
                            </div>
                            
                            <button type="button" onclick="disable2FA()" class="btn btn-danger">
                                <i class="fas fa-times-circle me-2"></i>Disable Two-Factor Authentication
                            </button>
                        @else
                            {{-- 2FA is Disabled --}}
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>Two-Factor Authentication is <strong>not enabled</strong>. Enable it for enhanced security.
                            </div>
                            
                            <p>When two-factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator or similar application.</p>
                            
                            <button type="button" onclick="enable2FA()" class="btn btn-primary" id="enable2FABtn">
                                <i class="fas fa-shield-alt me-2"></i>Enable Two-Factor Authentication
                            </button>
                            
                            {{-- QR Code Section (Hidden by default) --}}
                            <div id="qrCodeSection" style="display: none;" class="mt-4">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>Scan the QR code below with your authenticator app, then enter a code to confirm.
                                </div>
                                
                                <h5>Scan QR Code</h5>
                                <p>Scan this QR code with your authenticator app:</p>
                                <div id="qrCodeContainer" class="mb-3 text-center">
                                    {{-- QR code will be loaded here via AJAX --}}
                                </div>
                                
                                <h5>Or Enter Setup Key</h5>
                                <p>Setup Key: <code id="setupKey"></code></p>
                                
                                <form onsubmit="confirm2FA(event)" class="mt-3">
                                    <div class="form-group mb-3">
                                        <label for="confirmCode">Verification Code</label>
                                        <input type="text" id="confirmCode" class="form-control" placeholder="Enter the 6-digit code" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check me-2"></i>Confirm and Enable
                                    </button>
                                    <button type="button" onclick="cancel2FASetup()" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <script>
                function enable2FA() {
                    const btn = document.getElementById('enable2FABtn');
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enabling...';
                    
                    fetch('/user/two-factor-authentication', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Now fetch the QR code
                        return fetch('/user/two-factor-qr-code', {
                            headers: {
                                'Accept': 'application/json',
                            }
                        });
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Display QR code
                        document.getElementById('qrCodeContainer').innerHTML = data.svg;
                        
                        // Extract secret from the URL (format: otpauth://totp/...?secret=XXXXX&...)
                        const secretMatch = data.url.match(/secret=([^&]+)/);
                        const secret = secretMatch ? secretMatch[1] : '';
                        document.getElementById('setupKey').textContent = secret;
                        
                        document.getElementById('qrCodeSection').style.display = 'block';
                        btn.style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to enable 2FA. Please try again.');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-shield-alt me-2"></i>Enable Two-Factor Authentication';
                    });
                }
                
                function confirm2FA(event) {
                    event.preventDefault();
                    const code = document.getElementById('confirmCode').value;
                    
                    fetch('/user/confirmed-two-factor-authentication', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ code: code })
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Invalid code');
                            });
                        }
                    })
                    .catch(error => {
                        alert(error.message || 'Invalid verification code. Please try again.');
                    });
                }
                
                function cancel2FASetup() {
                    // Disable 2FA since user cancelled
                    fetch('/user/two-factor-authentication', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(() => {
                        window.location.reload();
                    });
                }
                
                function disable2FA() {
                    if (!confirm('Are you sure you want to disable two-factor authentication?')) {
                        return;
                    }
                    
                    fetch('/user/two-factor-authentication', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(() => {
                        window.location.reload();
                    });
                }
                
                function regenerateRecoveryCodes() {
                    if (!confirm('Are you sure you want to regenerate recovery codes? Your old codes will no longer work.')) {
                        return;
                    }
                    
                    fetch('/user/two-factor-recovery-codes', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(() => {
                        window.location.reload();
                    });
                }
            </script>
            
            <div class="card mt-4 fade-in" style="animation-delay: 0.3s">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-history text-primary me-2"></i>Recent Activity</h3>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Applications</h5>
                    @if($applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Application ID</th>
                                        <th>Submitted Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>#{{ $application->Application_ID }}</td>
                                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $application->document->verification_status === 'approved' ? 'success' : ($application->document->verification_status === 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($application->document->verification_status ?? 'pending') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-2x text-muted mb-3"></i>
                            <p class="mb-0">No applications found.</p>
                        </div>
                    @endif
                    
                    <h5 class="mt-4 mb-3">Appointments</h5>
                    @if($appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Appointment ID</th>
                                        <th>Date & Time</th>
                                        <th>Branch</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>#{{ $appointment->Appointment_ID }}</td>
                                            <td>{{ $appointment->Appointment_Date }} at {{ $appointment->Appointment_Time }}</td>
                                            <td>{{ $appointment->Office_Branch }}</td>
                                            <td>
                                                <span class="badge badge-{{ $appointment->Status === 'PENDING' ? 'warning' : ($appointment->Status === 'APPROVED' ? 'success' : 'danger') }}">
                                                    {{ $appointment->Status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar fa-2x text-muted mb-3"></i>
                            <p class="mb-0">No appointments found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection