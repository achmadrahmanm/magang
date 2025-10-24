<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mahasiswa Dashboard')</title>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font Awesome 6.5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Mahasiswa Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/mahasiswa.css') }}">
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header text-center">
            <div class="sidebar-brand mx-auto">
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
                <a href="{{ route('dashboard.mahasiswa') }}"
                    class="nav-link {{ request()->routeIs('dashboard.mahasiswa') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('mahasiswa.formal-requests') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.formal-requests') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span class="nav-text">Permohonan Formal</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('mahasiswa.signature') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.signature') ? 'active' : '' }}">
                    <i class="fas fa-signature"></i>
                    <span class="nav-text">Digital Signature</span>
                </a>
            </li>

            <li class="nav-item d-none">
                <a href="{{ route('mahasiswa.courses') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.courses') ? 'active' : '' }}">
                    <i class="fas fa-file"></i>
                    <span class="nav-text">Course</span>
                </a>
            </li>
            <li class="nav-item d-none">
                <a href="{{ route('mahasiswa.grades') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.grades') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span class="nav-text">Grades</span>
                </a>
            </li>
            <li class="nav-item d-none">
                <a href="{{ route('mahasiswa.schedule') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.schedule') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="nav-text">Schedule</span>
                </a>
            </li>
            <li class="nav-item d-none">
                <a href="{{ route('mahasiswa.assignments') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.assignments') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i>
                    <span class="nav-text">Assignments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('mahasiswa.settings') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.settings') ? 'active' : '' }}">
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
                            @if (Auth::user()->identity && Auth::user()->identity->image)
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
                                @if (Auth::user()->identity && Auth::user()->identity->image)
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

                            <form method="POST" action="{{ route('logout.post') }}" style="margin: 0;">
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

    <!-- Bootstrap 5.3 JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    @yield('scripts')
</body>

</html>
