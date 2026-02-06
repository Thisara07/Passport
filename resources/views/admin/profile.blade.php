@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">{{ __('messages.admin_profile') ?? 'Admin Profile' }}</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Profile Information</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $admin->Email_Address) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number', $admin->Contact_Number) }}">
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h6 class="mb-3 text-muted">Change Password (Optional)</h6>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Required only if changing password.</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
        
        {{-- Two-Factor Authentication Card --}}
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Two-Factor Authentication</h6>
                </div>
                <div class="card-body">
                    <div id="adminTwoFactorContent">
                        @if(auth()->guard('admin')->user()->two_factor_secret)
                            {{-- 2FA is Enabled --}}
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>Two-Factor Authentication is <strong>enabled</strong>. Your account is protected.
                            </div>
                            
                            <div class="mb-3">
                                <h6>Recovery Codes</h6>
                                <p class="text-muted small">Store these recovery codes in a secure location. They can be used to recover access to your account if your two-factor authentication device is lost.</p>
                                <div class="recovery-codes bg-light p-3 rounded mb-3" style="font-family: monospace; font-size: 0.9rem;">
                                    @if(auth()->guard('admin')->user()->two_factor_recovery_codes)
                                        @foreach(json_decode(decrypt(auth()->guard('admin')->user()->two_factor_recovery_codes), true) as $code)
                                            <div>{{ $code }}</div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" onclick="adminRegenerateRecoveryCodes()" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-repeat me-1"></i>Regenerate Recovery Codes
                                </button>
                            </div>
                            
                            <button type="button" onclick="adminDisable2FA()" class="btn btn-danger">
                                <i class="bi bi-x-circle me-2"></i>Disable Two-Factor Authentication
                            </button>
                        @else
                            {{-- 2FA is Disabled --}}
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>Two-Factor Authentication is <strong>not enabled</strong>. Enable it for enhanced security.
                            </div>
                            
                            <p>When two-factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator or similar application.</p>
                            
                            <button type="button" onclick="adminEnable2FA()" class="btn btn-primary" id="adminEnable2FABtn">
                                <i class="bi bi-shield-check me-2"></i>Enable Two-Factor Authentication
                            </button>
                            
                            {{-- QR Code Section (Hidden by default) --}}
                            <div id="adminQrCodeSection" style="display: none;" class="mt-4">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>Scan the QR code below with your authenticator app, then enter a code to confirm.
                                </div>
                                
                                <h6>Scan QR Code</h6>
                                <p>Scan this QR code with your authenticator app:</p>
                                <div id="adminQrCodeContainer" class="mb-3 text-center">
                                    {{-- QR code will be loaded here via AJAX --}}
                                </div>
                                
                                <h6>Or Enter Setup Key</h6>
                                <p>Setup Key: <code id="adminSetupKey"></code></p>
                                
                                <form onsubmit="adminConfirm2FA(event)" class="mt-3">
                                    <div class="form-group mb-3">
                                        <label for="adminConfirmCode">Verification Code</label>
                                        <input type="text" id="adminConfirmCode" class="form-control" placeholder="Enter the 6-digit code" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check me-2"></i>Confirm and Enable
                                    </button>
                                    <button type="button" onclick="adminCancel2FASetup()" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function adminEnable2FA() {
        const btn = document.getElementById('adminEnable2FABtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Enabling...';
        
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
            document.getElementById('adminQrCodeContainer').innerHTML = data.svg;
            
            // Extract secret from the URL
            const secretMatch = data.url.match(/secret=([^&]+)/);
            const secret = secretMatch ? secretMatch[1] : '';
            document.getElementById('adminSetupKey').textContent = secret;
            
            document.getElementById('adminQrCodeSection').style.display = 'block';
            btn.style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to enable 2FA. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Enable Two-Factor Authentication';
        });
    }
    
    function adminConfirm2FA(event) {
        event.preventDefault();
        const code = document.getElementById('adminConfirmCode').value;
        
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
    
    function adminCancel2FASetup() {
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
    
    function adminDisable2FA() {
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
    
    function adminRegenerateRecoveryCodes() {
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
@endsection
