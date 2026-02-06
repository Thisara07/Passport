<div>
    <div class="container py-5" style="max-width: 900px;">
        <div class="card shadow p-4">
            <h3 class="text-center mb-4">{{ __('messages.passport_application') }}</h3>

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="submit">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">{{ __('messages.full_name') }} *</label>
                            <input type="text" wire:model="full_name" id="full_name" class="form-control" required>
                            @error('full_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gender" class="form-label">{{ __('messages.gender') }} *</label>
                            <select wire:model="gender" id="gender" class="form-control" required>
                                <option value="">{{ __('messages.select_gender') }}</option>
                                <option value="Male">{{ __('messages.male') }}</option>
                                <option value="Female">{{ __('messages.female') }}</option>
                                <option value="Other">{{ __('messages.other') }}</option>
                            </select>
                            @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dob" class="form-label">{{ __('messages.date_of_birth') }} *</label>
                            <input type="date" wire:model="dob" id="dob" class="form-control" required>
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('messages.phone_number') }} *</label>
                            <input type="text" wire:model="phone" id="phone" class="form-control" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">{{ __('messages.address') }} *</label>
                    <input type="text" wire:model="address" id="address" class="form-control" required>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="street" class="form-label">{{ __('messages.street') }} *</label>
                            <input type="text" wire:model="street" id="street" class="form-control" required>
                            @error('street')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="city" class="form-label">{{ __('messages.city') }} *</label>
                            <input type="text" wire:model="city" id="city" class="form-control" required>
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="province" class="form-label">{{ __('messages.province') }} *</label>
                            <input type="text" wire:model="province" id="province" class="form-control" required>
                            @error('province')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nic_number" class="form-label">{{ __('messages.nic_number') }} *</label>
                    <input type="text" wire:model="nic_number" id="nic_number" class="form-control" required>
                    @error('nic_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nic_file" class="form-label">{{ __('messages.nic_card') }} (PDF/JPG/PNG) *</label>
                    <input type="file" wire:model="nic_file" id="nic_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    @error('nic_file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="birth_file" class="form-label">{{ __('messages.birth_certificate') }} (PDF/JPG/PNG) *</label>
                    <input type="file" wire:model="birth_file" id="birth_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    @error('birth_file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="photo_file" class="form-label">{{ __('messages.passport_photo') }} (JPG/PNG) *</label>
                    <input type="file" wire:model="photo_file" id="photo_file" class="form-control" accept=".jpg,.jpeg,.png" required>
                    @error('photo_file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ __('messages.submit_application') }}</span>
                    <span wire:loading>{{ __('messages.processing') }}</span>
                </button>
            </form>
        </div>
    </div>
</div>