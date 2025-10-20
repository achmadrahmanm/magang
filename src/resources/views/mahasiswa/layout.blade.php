<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mahasiswa Dashboard')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(135deg, #29166F 0%, #4c2c91 100%);
            padding: 1rem 0;
            transition: transform 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            transform: translateX(-260px);
        }

        .sidebar-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-brand {
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-brand i {
            font-size: 1.5rem;
        }

        .sidebar-user-info {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .sidebar-user-id {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: white;
        }

        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .nav-text {
            flex: 1;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-wrapper.expanded {
            margin-left: 0;
        }

        /* Top Navigation */
        .top-nav {
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: background 0.3s ease;
            color: #333;
        }

        .menu-toggle:hover {
            background: #f8f9fa;
        }

        .top-nav-title {
            color: #333;
            font-size: 1.3rem;
            font-weight: 600;
            flex: 1;
            margin-left: 1rem;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        .user-dropdown {
            position: relative;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            border: none;
            background: #f8f9fa;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .user-trigger:hover {
            background: #e9ecef;
            transform: translateY(-1px);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #29166F, #4c2c91);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .user-name {
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
            line-height: 1.2;
        }

        .user-id {
            color: #666;
            font-size: 0.75rem;
            line-height: 1;
        }

        .dropdown-arrow {
            color: #666;
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        .user-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 280px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid #e9ecef;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            margin-top: 0.5rem;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dropdown-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #29166F, #4c2c91);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dropdown-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .dropdown-user-info {
            flex: 1;
        }

        .dropdown-user-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
            font-size: 1rem;
        }

        .dropdown-user-id {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        .dropdown-user-role {
            color: #29166F;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dropdown-body {
            padding: 1rem 0;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: #333;
            text-decoration: none;
        }

        .dropdown-item i {
            width: 16px;
            color: #29166F;
        }

        .dropdown-divider {
            height: 1px;
            background: #e9ecef;
            margin: 0.5rem 0;
        }

        .dropdown-item.logout {
            color: #dc3545;
            border-top: 1px solid #f0f0f0;
            margin-top: 0.5rem;
            padding-top: 1rem;
        }

        .dropdown-item.logout i {
            color: #dc3545;
        }

        .dropdown-item.logout:hover {
            background: #f8d7da;
        }

        /* Content Area */
        .content {
            padding: 2rem 1.5rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            color: #333;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-description {
            color: #666;
            font-size: 1rem;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-260px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .content {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .user-details {
                display: none;
            }

            .dropdown-menu {
                width: 260px;
                right: -10px;
            }

            .user-trigger {
                padding: 0.5rem;
                background: transparent;
            }

            .user-trigger:hover {
                background: rgba(0, 0, 0, 0.05);
            }
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <i class="fas fa-graduation-cap"></i>
                <span>Student Portal</span>
            </div>
            <div class="sidebar-user-info">
                {{ Auth::user()->name }}
            </div>
            <div class="sidebar-user-id">
                ID: {{ Auth::user()->identity->user_id ?? 'N/A' }}
            </div>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('dashboard.mahasiswa') }}" class="nav-link {{ request()->routeIs('dashboard.mahasiswa') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('mahasiswa.courses') }}" class="nav-link {{ request()->routeIs('mahasiswa.courses') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span class="nav-text">My Courses</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('mahasiswa.grades') }}" class="nav-link {{ request()->routeIs('mahasiswa.grades') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span class="nav-text">Grades</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('mahasiswa.schedule') }}" class="nav-link {{ request()->routeIs('mahasiswa.schedule') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="nav-text">Schedule</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('mahasiswa.assignments') }}" class="nav-link {{ request()->routeIs('mahasiswa.assignments') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i>
                    <span class="nav-text">Assignments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('mahasiswa.settings') }}" class="nav-link {{ request()->routeIs('mahasiswa.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <div class="main-wrapper" id="mainWrapper">
        <!-- Top Navigation -->
        <header class="top-nav">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="top-nav-title">@yield('page-title', 'Dashboard')</h1>
            <div class="user-actions">
                <div class="user-dropdown" id="userDropdown">
                    <button class="user-trigger" id="userTrigger">
                        <div class="user-avatar">
                            @if(Auth::user()->identity && Auth::user()->identity->image)
                                <img src="{{ Auth::user()->identity->image_url }}" alt="Profile">
                            @else
                                {{ Auth::user()->identity ? Auth::user()->identity->initials : substr(Auth::user()->name, 0, 2) }}
                            @endif
                        </div>
                        <div class="user-details">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-id">{{ Auth::user()->identity->user_id ?? 'N/A' }}</div>
                        </div>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </button>
                    
                    <div class="dropdown-menu" id="dropdownMenu">
                        <div class="dropdown-header">
                            <div class="dropdown-avatar">
                                @if(Auth::user()->identity && Auth::user()->identity->image)
                                    <img src="{{ Auth::user()->identity->image_url }}" alt="Profile">
                                @else
                                    {{ Auth::user()->identity ? Auth::user()->identity->initials : substr(Auth::user()->name, 0, 2) }}
                                @endif
                            </div>
                            <div class="dropdown-user-info">
                                <div class="dropdown-user-name">{{ Auth::user()->name }}</div>
                                <div class="dropdown-user-id">ID: {{ Auth::user()->identity->user_id ?? 'N/A' }}</div>
                                <div class="dropdown-user-role">{{ ucfirst(Auth::user()->role) }}</div>
                            </div>
                        </div>
                        
                        <div class="dropdown-body">
                            <a href="{{ route('mahasiswa.profile') }}" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="{{ route('mahasiswa.settings') }}" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                <span>Account Settings</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-bell"></i>
                                <span>Notifications</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-question-circle"></i>
                                <span>Help & Support</span>
                            </a>
                            
                            <div class="dropdown-divider"></div>
                            
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="dropdown-item logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="content">
            @yield('content')
        </main>
    </div>

    <script>
        // Sidebar Toggle Functionality
        const sidebar = document.getElementById('sidebar');
        const mainWrapper = document.getElementById('mainWrapper');
        const menuToggle = document.getElementById('menuToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        menuToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                // Mobile behavior
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
            } else {
                // Desktop behavior
                sidebar.classList.toggle('collapsed');
                mainWrapper.classList.toggle('expanded');
            }
        });

        // Close sidebar when clicking overlay (mobile)
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });

        // Close mobile menu when clicking nav link
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });
        });

        // User Dropdown Functionality
        const userDropdown = document.getElementById('userDropdown');
        const userTrigger = document.getElementById('userTrigger');
        const dropdownMenu = document.getElementById('dropdownMenu');

        userTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            userDropdown.classList.toggle('active');
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target)) {
                userDropdown.classList.remove('active');
                dropdownMenu.classList.remove('show');
            }
        });

        // Close dropdown on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                userDropdown.classList.remove('active');
                dropdownMenu.classList.remove('show');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>