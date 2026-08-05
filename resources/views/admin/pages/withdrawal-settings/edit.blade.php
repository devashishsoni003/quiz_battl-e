@extends('admin.layouts.index')

@section('title', 'Withdrawal Settings')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Withdrawal Settings</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        <div class="profile-card-header">
            <span class="header-icon">⚙️</span>
            <h2>Withdrawal Settings</h2>
        </div>

        <form action="{{ route('admin.withdrawal-settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display: flex; gap: 2.5rem; align-items: flex-start; flex-wrap: wrap;">
                <div style="flex: 1 1 100%;">

                    <div class="form-row-2">
                        <!-- Coins Per USD -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="coins_per_usd">Coins Per USD<span class="req">*</span></label>
                            <input type="number" step="0.01" name="coins_per_usd" id="coins_per_usd" class="form-input" value="{{ old('coins_per_usd', $setting->coins_per_usd) }}" required min="0.01">
                            @error('coins_per_usd')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- USD To Local Rate -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="usd_to_local_rate">USD To Local Rate<span class="req">*</span></label>
                            <input type="number" step="0.01" name="usd_to_local_rate" id="usd_to_local_rate" class="form-input" value="{{ old('usd_to_local_rate', $setting->usd_to_local_rate) }}" required min="0.01">
                            @error('usd_to_local_rate')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row-2">
                        <!-- Minimum Withdrawal Coins -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="minimum_withdrawal_coins">Minimum Withdrawal (Coins)<span class="req">*</span></label>
                            <input type="number" name="minimum_withdrawal_coins" id="minimum_withdrawal_coins" class="form-input" value="{{ old('minimum_withdrawal_coins', $setting->minimum_withdrawal_coins) }}" required min="1">
                            @error('minimum_withdrawal_coins')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Maximum Withdrawal Coins -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="maximum_withdrawal_coins">Maximum Withdrawal (Coins)<span class="req">*</span></label>
                            <input type="number" name="maximum_withdrawal_coins" id="maximum_withdrawal_coins" class="form-input" value="{{ old('maximum_withdrawal_coins', $setting->maximum_withdrawal_coins) }}" required min="1">
                            @error('maximum_withdrawal_coins')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row-2">
                        <!-- Local Currency -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="local_currency">Local Currency<span class="req">*</span></label>
                            <input type="text" name="local_currency" id="local_currency" class="form-input" value="{{ old('local_currency', $setting->local_currency) }}" required maxlength="10">
                            @error('local_currency')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Processing Time -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="processing_time">Processing Time</label>
                            <input type="text" name="processing_time" id="processing_time" class="form-input" value="{{ old('processing_time', $setting->processing_time) }}" placeholder="e.g. 3-5 Business Days">
                            @error('processing_time')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="note">Note</label>
                        <textarea name="note" id="note" class="form-input" rows="3">{{ old('note', $setting->note) }}</textarea>
                        @error('note')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem; width: 48%;">
                        <label class="form-label" for="status">Status<span class="req">*</span></label>
                        <select name="status" id="status" class="form-input" required style="background-color: #1e1b2e; color: #ffffff;">
                            <option value="1" {{ old('status', $setting->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $setting->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-submit-container" style="margin-top: 2rem;">
                <button type="submit" class="btn-profile-save">Update Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
