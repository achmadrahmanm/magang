@extends('mahasiswa.layout')

@section('title', 'Settings')
@section('page-title', 'Account Settings')

@section('content')
<style>
    .settings-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
    }

    .settings-nav {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        height: fit-content;
        border: 1px solid #f0f0f0;
    }

    .settings-nav-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .settings-nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #666;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .settings-nav-item:hover,
    .settings-nav-item.active {
        background: #29166F;
        color: white;
        text-decoration: none;
    }

    .settings-nav-item i {
        width: 20px;
        margin-right: 0.75rem;
    }

    .settings-content {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }

    .content-header {
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
        padding: 2rem;
        border-radius: 16px 16px 0 0;
    }

    .content-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .content-body {
        padding: 2rem;
    }

    .settings-section {
        display: none;
    }

    .settings-section.active {
        display: block;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #333;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .form-control:focus {
        outline: none;
        border-color: #29166F;
        box-shadow: 0 0 0 3px rgba(41, 22, 111, 0.1);
        background-color: white;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .profile-picture {
        text-align: center;
        margin-bottom: 2rem;
        padding: 2rem;
        border: 2px dashed #e1e5e9;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .profile-picture:hover {
        border-color: #29166F;
        background: #f8f7ff;
    }

    .current-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 1rem;
    }

    .upload-btn {
        background: #29166F;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .upload-btn:hover {
        background: #1f0e4f;
    }

    .notification-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border: 1px solid #e1e5e9;
        border-radius: 8px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        border-color: #29166F;
    }

    .notification-info {
        flex: 1;
    }

    .notification-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .notification-desc {
        color: #666;
        font-size: 0.85rem;
    }

    .toggle-switch {
        position: relative;
        width: 50px;
        height: 25px;
        background: #ccc;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-switch.active {
        background: #29166F;
    }

    .toggle-switch::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 21px;
        height: 21px;
        background: white;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .toggle-switch.active::before {
        transform: translateX(25px);
    }

    .privacy-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .privacy-item:last-child {
        border-bottom: none;
    }

    .btn-primary {
        background: #29166F;
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #1f0e4f;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #dc3545;
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    @media (max-width: 768px) {
        .settings-container {
            grid-template-columns: 1fr;
        }

        .settings-nav {
            order: 2;
        }

        .settings-content {
            order: 1;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .content-body {
            padding: 1.5rem;
        }
    }
</style>

<div class="settings-container">
    <nav class="settings-nav">
        <div class="settings-nav-title">
            <i class="fas fa-cog"></i>
            Settings Menu
        </div>
        <a href="#" class="settings-nav-item active" data-section="profile">
            <i class="fas fa-user"></i>
            Profile Information
        </a>
        <a href="#" class="settings-nav-item" data-section="account">
            <i class="fas fa-shield-alt"></i>
            Account Security
        </a>
        <a href="#" class="settings-nav-item" data-section="notifications">
            <i class="fas fa-bell"></i>
            Notifications
        </a>
        <a href="#" class="settings-nav-item" data-section="privacy">
            <i class="fas fa-eye"></i>
            Privacy Settings
        </a>
        <a href="#" class="settings-nav-item" data-section="preferences">
            <i class="fas fa-palette"></i>
            Preferences
        </a>
    </nav>

    <div class="settings-content">
        <div class="content-header">
            <h2 class="content-title">
                <i class="fas fa-user"></i>
                <span id="section-title">Profile Information</span>
            </h2>
        </div>

        <div class="content-body">
            <!-- Profile Section -->
            <div class="settings-section active" id="profile">
                <div class="profile-picture">
                    <div class="current-avatar">
                        @if(Auth::user()->identity && Auth::user()->identity->image)
                            <img src="{{ Auth::user()->identity->image_url }}" alt="Profile">
                        @else
                            {{ Auth::user()->identity ? Auth::user()->identity->initials : substr(Auth::user()->name, 0, 2) }}
                        @endif
                    </div>
                    <button class="upload-btn">
                        <i class="fas fa-camera"></i> Change Photo
                    </button>
                </div>

                <form>
                    @php
                        $identity = Auth::user()->identity;
                        $nameParts = explode(' ', Auth::user()->name);
                        $firstName = $nameParts[0] ?? '';
                        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';
                    @endphp
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" value="{{ $firstName }}" placeholder="Enter first name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" value="{{ $lastName }}" placeholder="Enter last name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="Enter email">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" value="{{ $identity->phone ?? '' }}" placeholder="Enter phone">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Student ID</label>
                            <input type="text" class="form-control" value="{{ $identity->user_id ?? 'N/A' }}" placeholder="Student ID" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <input type="text" class="form-control" value="{{ $identity->department ?? '' }}" placeholder="Enter department">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Major</label>
                            <input type="text" class="form-control" value="{{ $identity->major ?? '' }}" placeholder="Enter major">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Bio</label>
                        <textarea class="form-control" rows="4" placeholder="Tell us about yourself">{{ ucfirst(Auth::user()->role) }} student passionate about learning and academic excellence.</textarea>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>
            </div>

            <!-- Account Security Section -->
            <div class="settings-section" id="account">
                <form>
                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" placeholder="Enter current password">
                    </div>

                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" placeholder="Enter new password">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" placeholder="Confirm new password">
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-key"></i> Update Password
                    </button>
                </form>
            </div>

            <!-- Notifications Section -->
            <div class="settings-section" id="notifications">
                <div class="notification-item">
                    <div class="notification-info">
                        <div class="notification-title">Email Notifications</div>
                        <div class="notification-desc">Receive assignment and grade notifications via email</div>
                    </div>
                    <div class="toggle-switch active"></div>
                </div>

                <div class="notification-item">
                    <div class="notification-info">
                        <div class="notification-title">SMS Notifications</div>
                        <div class="notification-desc">Receive urgent notifications via SMS</div>
                    </div>
                    <div class="toggle-switch"></div>
                </div>

                <div class="notification-item">
                    <div class="notification-info">
                        <div class="notification-title">Assignment Reminders</div>
                        <div class="notification-desc">Get reminded about upcoming assignment deadlines</div>
                    </div>
                    <div class="toggle-switch active"></div>
                </div>

                <div class="notification-item">
                    <div class="notification-info">
                        <div class="notification-title">Grade Updates</div>
                        <div class="notification-desc">Be notified when new grades are posted</div>
                    </div>
                    <div class="toggle-switch active"></div>
                </div>

                <div class="notification-item">
                    <div class="notification-info">
                        <div class="notification-title">Schedule Changes</div>
                        <div class="notification-desc">Get notified about class schedule changes</div>
                    </div>
                    <div class="toggle-switch active"></div>
                </div>
            </div>

            <!-- Privacy Section -->
            <div class="settings-section" id="privacy">
                <div class="privacy-item">
                    <div class="notification-info">
                        <div class="notification-title">Profile Visibility</div>
                        <div class="notification-desc">Who can see your profile information</div>
                    </div>
                    <select class="form-control" style="width: auto;">
                        <option>Everyone</option>
                        <option>Students Only</option>
                        <option>Faculty Only</option>
                        <option>Private</option>
                    </select>
                </div>

                <div class="privacy-item">
                    <div class="notification-info">
                        <div class="notification-title">Contact Information</div>
                        <div class="notification-desc">Show email and phone in directory</div>
                    </div>
                    <div class="toggle-switch active"></div>
                </div>

                <div class="privacy-item">
                    <div class="notification-info">
                        <div class="notification-title">Academic Information</div>
                        <div class="notification-desc">Show GPA and grades to others</div>
                    </div>
                    <div class="toggle-switch"></div>
                </div>
            </div>

            <!-- Preferences Section -->
            <div class="settings-section" id="preferences">
                <div class="form-group">
                    <label class="form-label">Language</label>
                    <select class="form-control">
                        <option>English</option>
                        <option>Bahasa Indonesia</option>
                        <option>Mandarin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Timezone</label>
                    <select class="form-control">
                        <option>UTC+7 (Jakarta)</option>
                        <option>UTC+8 (Singapore)</option>
                        <option>UTC+0 (GMT)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Date Format</label>
                    <select class="form-control">
                        <option>DD/MM/YYYY</option>
                        <option>MM/DD/YYYY</option>
                        <option>YYYY-MM-DD</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Preferences
                </button>

                <hr style="margin: 2rem 0;">

                <div style="background: #f8d7da; padding: 1.5rem; border-radius: 8px; border: 1px solid #f5c6cb;">
                    <h4 style="color: #721c24; margin-bottom: 1rem;">
                        <i class="fas fa-exclamation-triangle"></i> Danger Zone
                    </h4>
                    <p style="color: #721c24; margin-bottom: 1rem; font-size: 0.9rem;">
                        Once you delete your account, there is no going back. Please be certain.
                    </p>
                    <button class="btn-danger">
                        <i class="fas fa-trash"></i> Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Settings navigation
    const settingsNavItems = document.querySelectorAll('.settings-nav-item');
    const sections = document.querySelectorAll('.settings-section');
    const sectionTitle = document.getElementById('section-title');

    const sectionTitles = {
        'profile': 'Profile Information',
        'account': 'Account Security',
        'notifications': 'Notifications',
        'privacy': 'Privacy Settings',
        'preferences': 'Preferences'
    };

    const sectionIcons = {
        'profile': 'fas fa-user',
        'account': 'fas fa-shield-alt',
        'notifications': 'fas fa-bell',
        'privacy': 'fas fa-eye',
        'preferences': 'fas fa-palette'
    };

    settingsNavItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const targetSection = this.getAttribute('data-section');
            
            // Remove active from all settings nav items and sections
            settingsNavItems.forEach(nav => nav.classList.remove('active'));
            sections.forEach(section => section.classList.remove('active'));
            
            // Add active to clicked nav item and corresponding section
            this.classList.add('active');
            document.getElementById(targetSection).classList.add('active');
            
            // Update section title
            sectionTitle.innerHTML = `<i class="${sectionIcons[targetSection]}"></i> ${sectionTitles[targetSection]}`;
        });
    });

    // Toggle switches
    const toggleSwitches = document.querySelectorAll('.toggle-switch');
    
    toggleSwitches.forEach(toggle => {
        toggle.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });
</script>
@endsection
@endsection