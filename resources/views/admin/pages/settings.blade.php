@extends('admin.layouts.index')

@section('title', 'Quiz Battle - Settings')

@section('content')
<!-- Cheerly Style Breadcrumb & Title -->
<div class="cheerly-breadcrumbs">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>/</span>
    <span class="active">Settings</span>
</div>

<div class="page-title-section" style="margin-bottom: 2rem;">
    <h1 class="page-main-heading">Settings</h1>
    <p class="page-sub-heading">Configure core system settings, feature flags, and email configuration for your workspace.</p>
</div>

<div class="settings-layout-grid">

    <!-- Left Sidebar: Settings Tabs Navigation (Screenshot 1-5) -->
    <div class="settings-nav-card">
        <div class="settings-nav-header">
            <h2 class="settings-nav-title">Settings</h2>
            <p class="settings-nav-desc">Manage your workspace</p>
        </div>

        <div class="settings-search-box">
            <span class="settings-search-icon">🔍</span>
            <input type="text" id="settings-search-input" class="settings-search-input" placeholder="Search settings...">
        </div>

        <ul class="settings-nav-list" id="settings-nav-list">
            <li class="settings-nav-item active" data-tab="general">
                <a href="#general">
                    <span class="nav-tab-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </span>
                    <span>General</span>
                </a>
            </li>

            <li class="settings-nav-item" data-tab="appearance">
                <a href="#appearance">
                    <span class="nav-tab-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                            <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path>
                            <path d="M2 2l7.586 7.586"></path>
                            <circle cx="11" cy="11" r="2"></circle>
                        </svg>
                    </span>
                    <span>Appearance</span>
                </a>
            </li>

            <li class="settings-nav-item" data-tab="mail">
                <a href="#mail">
                    <span class="nav-tab-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    <span>Mail</span>
                </a>
            </li>

            <li class="settings-nav-item" data-tab="features">
                <a href="#features">
                    <span class="nav-tab-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </span>
                    <span>Features</span>
                </a>
            </li>

            <li class="settings-nav-item" data-tab="security">
                <a href="#security">
                    <span class="nav-tab-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </span>
                    <span>Security</span>
                </a>
            </li>

            <li class="settings-nav-item" data-tab="social-login">
                <a href="#social-login">
                    <span class="nav-tab-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                        </svg>
                    </span>
                    <span>Social Login</span>
                </a>
            </li>

            <li class="settings-nav-item" data-tab="notifications">
                <a href="#notifications">
                    <span class="nav-tab-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </span>
                    <span>Notifications</span>
                </a>
            </li>

            <li class="settings-nav-item" data-tab="login-page">
                <a href="#login-page">
                    <span class="nav-tab-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                    </span>
                    <span>Login Page</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Right Side: Settings Content Card (Screenshot 1-5) -->
    <div class="settings-content-card">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settings-main-form">
            @csrf

            <!-- ==========================================
                 TAB 1: GENERAL (Screenshot 1)
                 ========================================== -->
            <div class="settings-tab-panel active" id="tab-general">
                <div class="settings-section-header">
                    <div class="settings-section-badge">GENERAL</div>
                    <div class="settings-section-subtitle">Core platform identity and configuration</div>
                </div>

                <!-- Site Name -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Site Name</div>
                        <div class="settings-row-label-desc">The name displayed across the platform</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="text" name="site_name" class="form-input-cheerly" value="Admin Panel" placeholder="Enter site name">
                    </div>
                </div>

                <!-- Site Description -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Site Description</div>
                        <div class="settings-row-label-desc">A brief description of your platform</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <textarea name="site_description" class="form-input-cheerly" rows="3" placeholder="Enter site description"></textarea>
                    </div>
                </div>

                <!-- Contact Email -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Contact Email</div>
                        <div class="settings-row-label-desc">Primary contact email address</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="email" name="contact_email" class="form-input-cheerly" value="admin@example.com" placeholder="Enter contact email">
                    </div>
                </div>

                <!-- Default Timezone -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Default Timezone</div>
                        <div class="settings-row-label-desc">Timezone used for dates and scheduling</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <select name="default_timezone" class="form-input-cheerly">
                            <option value="UTC" selected>UTC</option>
                            <option value="Asia/Kolkata">Asia/Kolkata (IST)</option>
                            <option value="America/New_York">America/New_York (EST)</option>
                            <option value="Europe/London">Europe/London (GMT)</option>
                        </select>
                    </div>
                </div>

                <!-- Date Format -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Date Format</div>
                        <div class="settings-row-label-desc">How dates are displayed across the platform</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <select name="date_format" class="form-input-cheerly">
                            <option value="d M, Y" selected>23 Feb, 2026</option>
                            <option value="Y-m-d">2026-02-23</option>
                            <option value="m/d/Y">02/23/2026</option>
                            <option value="d/m/Y">23/02/2026</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 2: APPEARANCE (Screenshot 2)
                 ========================================== -->
            <div class="settings-tab-panel" id="tab-appearance">
                <div class="settings-section-header">
                    <div class="settings-section-badge">APPEARANCE</div>
                    <div class="settings-section-subtitle">Logo, favicon, and theme colors</div>
                </div>

                <!-- Site Logo -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Site Logo</div>
                        <div class="settings-row-label-desc">Recommended: 200×50px, PNG or SVG</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <div class="avatar-upload-box" style="min-height: 120px; padding: 1.25rem;">
                            <input type="file" name="site_logo" style="display: none;" accept="image/*">
                            <div class="avatar-placeholder">
                                <div class="dropzone-cloud-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                                <div class="dropzone-main-text">Click or drop files</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Site Favicon -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Site Favicon</div>
                        <div class="settings-row-label-desc">Recommended: 32×32px or 64×64px, PNG or ICO</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <div class="avatar-upload-box" style="min-height: 120px; padding: 1.25rem;">
                            <input type="file" name="site_favicon" style="display: none;" accept="image/*">
                            <div class="avatar-placeholder">
                                <div class="dropzone-cloud-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                                <div class="dropzone-main-text">Click or drop files</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Primary Color -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Primary Color</div>
                        <div class="settings-row-label-desc">Main brand color for buttons, links, and accents</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <div class="color-picker-row">
                            <div class="color-swatch-box" style="background-color: #7c3aed;">
                                <input type="color" name="primary_color_picker" class="color-swatch-input" value="#7c3aed">
                            </div>
                            <input type="text" name="primary_color" class="color-hex-field" value="#7c3aed">
                        </div>
                    </div>
                </div>

                <!-- Secondary Color -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Secondary Color</div>
                        <div class="settings-row-label-desc">Used for secondary actions and decorative elements</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <div class="color-picker-row">
                            <div class="color-swatch-box" style="background-color: #1a1325;">
                                <input type="color" name="secondary_color_picker" class="color-swatch-input" value="#1a1325">
                            </div>
                            <input type="text" name="secondary_color" class="color-hex-field" value="#1a1325">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 3: MAIL (Screenshot 3, 4, 5)
                 ========================================== -->
            <div class="settings-tab-panel" id="tab-mail">
                <div class="settings-section-header">
                    <div class="settings-section-badge">MAIL</div>
                    <div class="settings-section-subtitle">Outgoing email and notification settings</div>
                </div>

                <!-- Mail Driver -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Mail Driver</div>
                        <div class="settings-row-label-desc">Default transport used to send all outgoing emails</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <select name="mail_driver" class="form-input-cheerly">
                            <option value="smtp" selected>SMTP</option>
                            <option value="sendmail">Sendmail</option>
                            <option value="mailgun">Mailgun</option>
                            <option value="ses">Amazon SES</option>
                            <option value="log">Log (Testing)</option>
                        </select>
                    </div>
                </div>

                <!-- From Name -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">From Name</div>
                        <div class="settings-row-label-desc">Sender name for outgoing emails</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="text" name="mail_from_name" class="form-input-cheerly" value="Laravel" placeholder="Sender name">
                    </div>
                </div>

                <!-- From Address -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">From Address</div>
                        <div class="settings-row-label-desc">Sender email address</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="email" name="mail_from_address" class="form-input-cheerly" value="hello@example.com" placeholder="Sender email address">
                    </div>
                </div>

                <!-- SMTP Host -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">SMTP Host</div>
                        <div class="settings-row-label-desc">SMTP server host, e.g. smtp.mailgun.org</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="text" name="smtp_host" class="form-input-cheerly" value="127.0.0.1" placeholder="SMTP server host">
                    </div>
                </div>

                <!-- SMTP Port -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">SMTP Port</div>
                        <div class="settings-row-label-desc">SMTP server port, usually 587 (TLS) or 465 (SSL)</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="number" name="smtp_port" class="form-input-cheerly" value="2525" placeholder="SMTP port">
                    </div>
                </div>

                <!-- SMTP Encryption -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">SMTP Encryption</div>
                        <div class="settings-row-label-desc">Use None for local/testing SMTP servers</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <select name="smtp_encryption" class="form-input-cheerly">
                            <option value="none" selected>None</option>
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                </div>

                <!-- SMTP Username -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">SMTP Username</div>
                        <div class="settings-row-label-desc">Username for SMTP authentication</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="text" name="smtp_username" class="form-input-cheerly" placeholder="Enter smtp username">
                    </div>
                </div>

                <!-- SMTP Password -->
                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">SMTP Password</div>
                        <div class="settings-row-label-desc">Password or app password for SMTP authentication</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="password" name="smtp_password" class="form-input-cheerly" placeholder="Enter smtp password">
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 4: FEATURES
                 ========================================== -->
            <div class="settings-tab-panel" id="tab-features">
                <div class="settings-section-header">
                    <div class="settings-section-badge">FEATURES</div>
                    <div class="settings-section-subtitle">Enable or disable platform feature flags</div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">User Registration</div>
                        <div class="settings-row-label-desc">Allow new members to register on the platform</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <label class="cheerly-toggle-switch">
                            <input type="checkbox" name="feature_registration" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Referral Reward Program</div>
                        <div class="settings-row-label-desc">Enable referral commissions on coin purchases</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <label class="cheerly-toggle-switch">
                            <input type="checkbox" name="feature_referrals" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Maintenance Mode</div>
                        <div class="settings-row-label-desc">Temporarily take the public app offline for updates</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <label class="cheerly-toggle-switch">
                            <input type="checkbox" name="feature_maintenance">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 5: SECURITY
                 ========================================== -->
            <div class="settings-tab-panel" id="tab-security">
                <div class="settings-section-header">
                    <div class="settings-section-badge">SECURITY</div>
                    <div class="settings-section-subtitle">Authentication and session security settings</div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Session Lifetime (Minutes)</div>
                        <div class="settings-row-label-desc">Inactivity duration before requiring re-authentication</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="number" name="session_lifetime" class="form-input-cheerly" value="120">
                    </div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Max Login Attempts</div>
                        <div class="settings-row-label-desc">Number of allowed attempts before temporary rate limiting</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="number" name="max_login_attempts" class="form-input-cheerly" value="5">
                    </div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Force HTTPS / SSL</div>
                        <div class="settings-row-label-desc">Ensure all connections are encrypted via SSL</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <label class="cheerly-toggle-switch">
                            <input type="checkbox" name="force_https" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 6: SOCIAL LOGIN
                 ========================================== -->
            <div class="settings-tab-panel" id="tab-social-login">
                <div class="settings-section-header">
                    <div class="settings-section-badge">SOCIAL LOGIN</div>
                    <div class="settings-section-subtitle">Configure OAuth providers for user login</div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Google OAuth Client ID</div>
                        <div class="settings-row-label-desc">Google Cloud Console client identifier</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="text" name="google_client_id" class="form-input-cheerly" placeholder="e.g. 123456789-abc.apps.googleusercontent.com">
                    </div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Google OAuth Secret</div>
                        <div class="settings-row-label-desc">Google Cloud client secret key</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="password" name="google_client_secret" class="form-input-cheerly" placeholder="Enter Google secret">
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 7: NOTIFICATIONS
                 ========================================== -->
            <div class="settings-tab-panel" id="tab-notifications">
                <div class="settings-section-header">
                    <div class="settings-section-badge">NOTIFICATIONS</div>
                    <div class="settings-section-subtitle">Configure email and push notification preferences</div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">New User Registration Notification</div>
                        <div class="settings-row-label-desc">Receive email alerts when a new user signs up</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <label class="cheerly-toggle-switch">
                            <input type="checkbox" name="notify_user_signup" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Withdrawal Request Alerts</div>
                        <div class="settings-row-label-desc">Notify admin whenever a creator requests coin payout</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <label class="cheerly-toggle-switch">
                            <input type="checkbox" name="notify_withdrawal" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 8: LOGIN PAGE
                 ========================================== -->
            <div class="settings-tab-panel" id="tab-login-page">
                <div class="settings-section-header">
                    <div class="settings-section-badge">LOGIN PAGE</div>
                    <div class="settings-section-subtitle">Customize authentication hero graphics and text</div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Login Hero Headline</div>
                        <div class="settings-row-label-desc">Main headline displayed on the left hero side of /login</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <input type="text" name="login_headline" class="form-input-cheerly" value="Run your recognition platform with confidence.">
                    </div>
                </div>

                <div class="settings-row">
                    <div class="settings-row-label">
                        <div class="settings-row-label-title">Login Hero Subtitle</div>
                        <div class="settings-row-label-desc">Secondary descriptive copy below the headline</div>
                    </div>
                    <div class="settings-row-input-wrap">
                        <textarea name="login_subtitle" class="form-input-cheerly" rows="3">A focused gateway for secure operations, team access, and critical business workflows.</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button (Screenshot 1-5) -->
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light);">
                <button type="submit" class="btn-primary-cheerly">Save Changes</button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navItems = document.querySelectorAll('.settings-nav-item');
        const tabPanels = document.querySelectorAll('.settings-tab-panel');
        const searchInput = document.getElementById('settings-search-input');

        // Function to switch tab
        function activateTab(tabName) {
            navItems.forEach(item => {
                if (item.getAttribute('data-tab') === tabName) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });

            tabPanels.forEach(panel => {
                if (panel.id === 'tab-' + tabName) {
                    panel.classList.add('active');
                } else {
                    panel.classList.remove('active');
                }
            });
        }

        // Handle tab clicks
        navItems.forEach(item => {
            item.addEventListener('click', function (e) {
                const tab = this.getAttribute('data-tab');
                if (tab) {
                    activateTab(tab);
                }
            });
        });

        // Handle URL hash on page load
        const initialHash = window.location.hash.replace('#', '');
        if (initialHash) {
            const matchedItem = document.querySelector(`.settings-nav-item[data-tab="${initialHash}"]`);
            if (matchedItem) {
                activateTab(initialHash);
            }
        }

        // Live color swatch sync
        document.querySelectorAll('.color-swatch-input').forEach(input => {
            input.addEventListener('input', function () {
                const row = this.closest('.color-picker-row');
                const swatch = row.querySelector('.color-swatch-box');
                const hexField = row.querySelector('.color-hex-field');
                if (swatch) swatch.style.backgroundColor = this.value;
                if (hexField) hexField.value = this.value;
            });
        });

        document.querySelectorAll('.color-hex-field').forEach(input => {
            input.addEventListener('input', function () {
                const row = this.closest('.color-picker-row');
                const swatch = row.querySelector('.color-swatch-box');
                const picker = row.querySelector('.color-swatch-input');
                if (swatch) swatch.style.backgroundColor = this.value;
                if (picker) picker.value = this.value;
            });
        });

        // Filter search input
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                navItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(query)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush
