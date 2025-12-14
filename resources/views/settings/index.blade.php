@extends('layouts.app')

@section('title', 'Settings - LifeHub')

@section('content')
<style>
    .settings-container {
        max-width: 900px;
    }
    .settings-section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 24px;
    }
    .section-header {
        margin-bottom: 24px;
    }
    .section-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 8px;
    }
    .section-subtitle {
        color: var(--muted);
        font-size: 14px;
        margin: 0;
    }
    .profile-avatar-section {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid var(--border);
    }
    .avatar-display {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 32px;
    }
    .avatar-info {
        flex: 1;
    }
    .avatar-upload-btn {
        padding: 10px 20px;
        background: white;
        border: 2px solid var(--primary);
        color: var(--primary);
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .avatar-upload-btn:hover {
        background: var(--primary);
        color: white;
    }
    .avatar-note {
        font-size: 13px;
        color: var(--muted);
        margin-top: 8px;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .save-btn {
        padding: 12px 32px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .save-btn:hover {
        background: #316bce;
    }
    .appearance-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
        border: 1px solid var(--border);
        border-radius: 12px;
        margin-bottom: 12px;
    }
    .option-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .option-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(59, 130, 246, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }
    .option-label {
        font-weight: 600;
    }
    .toggle-switch {
        position: relative;
        width: 50px;
        height: 28px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e5e7eb;
        transition: .3s;
        border-radius: 28px;
    }
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }
    input:checked + .toggle-slider {
        background-color: var(--primary);
    }
    input:checked + .toggle-slider:before {
        transform: translateX(22px);
    }
    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .alert.success {
        background: #ecfdf3;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .alert.error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
</style>

<div class="settings-container">
    <div class="page-header">
        <h1 class="page-title">Settings</h1>
        <p class="page-subtitle">Manage your account and preferences</p>
    </div>

    @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert error">
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
    @endif

    <!-- Profile Information -->
    <div class="settings-section">
        <div class="section-header">
            <h2 class="section-title">Profile Information</h2>
            <p class="section-subtitle">Update your personal information</p>
        </div>

        <div class="profile-avatar-section">
            <div class="avatar-display">
                {{ $user->initials }}
            </div>
            <div class="avatar-info">
                <form method="POST" action="{{ route('settings.avatar.update') }}" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;" onchange="this.form.submit()">
                    <label for="avatarInput" class="avatar-upload-btn">Change Avatar</label>
                    <div class="avatar-note">JPG, PNG or GIF (max. 2MB)</div>
                </form>
            </div>
        </div>

        <form method="POST" action="{{ route('settings.profile.update') }}">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" name="name" class="form-input" value="{{ explode(' ', $user->name)[0] ?? '' }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-input" value="{{ explode(' ', $user->name)[1] ?? '' }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input" value="{{ $user->email }}" required>
            </div>

            <button type="submit" class="save-btn">Save Changes</button>
        </form>
    </div>

    <!-- Appearance -->
    <div class="settings-section">
        <div class="section-header">
            <h2 class="section-title">Appearance</h2>
            <p class="section-subtitle">Customize how LifeHub looks</p>
        </div>

        <div class="appearance-option">
            <div class="option-info">
                <div class="option-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                </div>
                <span class="option-label">Dark Mode</span>
            </div>
            <label class="toggle-switch">
                <input type="checkbox">
                <span class="toggle-slider"></span>
            </label>
        </div>
    </div>

    <!-- Security -->
    <div class="settings-section">
        <div class="section-header">
            <h2 class="section-title">Security</h2>
            <p class="section-subtitle">Update your password and security settings</p>
        </div>

        <form method="POST" action="{{ route('settings.password.update') }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-input" required minlength="8">
            </div>

            <div class="form-group">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-input" required minlength="8">
            </div>

            <button type="submit" class="save-btn">Update Password</button>
        </form>
    </div>

    <!-- Notifications -->
    <div class="settings-section">
        <div class="section-header">
            <h2 class="section-title">Notifications</h2>
            <p class="section-subtitle">Manage your notification preferences</p>
        </div>

        <div class="appearance-option">
            <div class="option-info">
                <div class="option-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                </div>
                <div>
                    <div class="option-label">Task Reminders</div>
                    <div style="font-size: 13px; color: var(--muted);">Get notified about upcoming tasks</div>
                </div>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
            </label>
        </div>

        <div class="appearance-option">
            <div class="option-info">
                <div class="option-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                </div>
                <div>
                    <div class="option-label">Habit Reminders</div>
                    <div style="font-size: 13px; color: var(--muted);">Daily reminders for your habits</div>
                </div>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
            </label>
        </div>

        <div class="appearance-option">
            <div class="option-info">
                <div class="option-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                </div>
                <div>
                    <div class="option-label">Weekly Reports</div>
                    <div style="font-size: 13px; color: var(--muted);">Receive weekly progress summaries</div>
                </div>
            </div>
            <label class="toggle-switch">
                <input type="checkbox">
                <span class="toggle-slider"></span>
            </label>
        </div>
    </div>
</div>
@endsection