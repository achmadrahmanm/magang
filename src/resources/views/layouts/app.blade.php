<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Management Mahasiswa - ' . config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=poppins:400,500,600,700"
        rel="stylesheet" />

    <!-- Base Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 2px solid transparent;
        }

        .nav-link:hover {
            color: #667eea;
        }

        .nav-link.active {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-secondary {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: #333;
        }

        .mobile-nav {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        .mobile-nav.active {
            display: block;
        }

        .mobile-nav-links {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Main Content */
        .main-content {
            padding-top: 80px;
            /* Account for fixed header */
            min-height: calc(100vh - 80px);
        }

        /* Footer Styles */
        .footer {
            background: #1a1a1a;
            color: white;
            padding: 3rem 0 1rem;
            /* margin-top: 4rem; */
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #667eea;
        }

        .footer-section p {
            color: #ccc;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .footer-link {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: #667eea;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #333;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #667eea;
            transform: translateY(-2px);
        }

        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-bottom p {
            color: #999;
            margin: 0;
        }

        .footer-legal {
            display: flex;
            gap: 1rem;
        }

        .footer-legal a {
            color: #999;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .footer-legal a:hover {
            color: #667eea;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 0.5rem;
            }

            .nav {
                padding: 0.5rem 0;
            }

            .logo {
                font-size: 1.2rem;
            }

            .main-content {
                padding-top: 70px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="{{ url('/') }}" class="logo">
                    <div class="logo-icon" style="font-size: 1rem"> MM </div>
                    <span>Management Mahasiswa</span>
                </a>

                <div class="nav-links">
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                    <a href="#features" class="nav-link">Features</a>
                    <a href="#about" class="nav-link">About</a>
                    <a href="#contact" class="nav-link">Contact</a>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-secondary">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-primary">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>

                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    ☰
                </button>

                <div class="mobile-nav" id="mobileNav">
                    <div class="mobile-nav-links">
                        <a href="{{ url('/') }}" class="nav-link">Home</a>
                        <a href="#features" class="nav-link">Features</a>
                        <a href="#about" class="nav-link">About</a>
                        <a href="#contact" class="nav-link">Contact</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-secondary">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-primary">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Student Management System</h3>
                    <p>Solusi terdepan untuk manajemen mahasiswa yang efisien dan modern. Membantu institusi pendidikan
                        mengelola data mahasiswa dengan mudah dan aman.</p>
                    <div class="social-links">
                        <a href="#" class="social-link">📘</a>
                        <a href="#" class="social-link">📸</a>
                        <a href="#" class="social-link">🐦</a>
                        <a href="#" class="social-link">💼</a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <a href="#" class="footer-link">Dashboard</a>
                    <a href="#" class="footer-link">Student Portal</a>
                    <a href="#" class="footer-link">Course Management</a>
                    <a href="#" class="footer-link">Grade Reports</a>
                </div>

                <div class="footer-section">
                    <h3>Support</h3>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Documentation</a>
                    <a href="#" class="footer-link">API Reference</a>
                    <a href="#" class="footer-link">Contact Support</a>
                </div>

                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p>📍 Jakarta, Indonesia</p>
                    <p>📞 +62 21 1234 5678</p>
                    <p>✉️ info@studentmanagement.com</p>
                    <p>🕒 Mon - Fri: 9AM - 5PM</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Student Management System. All rights reserved.</p>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const mobileNav = document.getElementById('mobileNav');
            mobileNav.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileNav = document.getElementById('mobileNav');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');

            if (!mobileNav.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                mobileNav.classList.remove('active');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    <!-- Global API helper: automatically attach Bearer token from localStorage to /api requests -->
    <script>
        (function() {
            // Read token from localStorage
            function getToken() {
                try {
                    return localStorage.getItem('api_token');
                } catch (e) {
                    return null;
                }
            }

            // Wrap fetch to auto-add Authorization header for API calls
            if (window.fetch) {
                const _fetch = window.fetch.bind(window);
                window.fetch = function(input, init) {
                    try {
                        const token = getToken();
                        let url = (typeof input === 'string') ? input : input.url || '';
                        // If relative path like /api/... ensure match
                        if (url.startsWith('/') && url.indexOf('/api/') === 0 || url.indexOf('/api/') !== -1) {
                            init = init || {};
                            init.headers = init.headers || {};
                            // If Headers instance, use set
                            if (init.headers instanceof Headers) {
                                if (token) init.headers.set('Authorization', 'Bearer ' + token);
                            } else if (Array.isArray(init.headers)) {
                                if (token) init.headers.push(['Authorization', 'Bearer ' + token]);
                            } else {
                                if (token && !init.headers['Authorization']) init.headers['Authorization'] =
                                    'Bearer ' + token;
                            }
                        }
                    } catch (e) {
                        /* ignore */ }
                    return _fetch(input, init);
                };
            }

            // If axios is used, set default Authorization header
            if (window.axios) {
                try {
                    const t = getToken();
                    if (t) window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + t;
                } catch (e) {}
            }

            // Monkeypatch XHR send to attach header for legacy code
            (function() {
                const XHR = window.XMLHttpRequest;
                if (!XHR) return;
                const openProto = XHR.prototype.open;
                XHR.prototype.open = function(method, url) {
                    this._url = url;
                    return openProto.apply(this, arguments);
                };

                const sendProto = XHR.prototype.send;
                XHR.prototype.send = function(body) {
                    try {
                        const token = getToken();
                        if (token && this._url && this._url.indexOf('/api/') !== -1) {
                            this.setRequestHeader('Authorization', 'Bearer ' + token);
                        }
                    } catch (e) {}
                    return sendProto.apply(this, arguments);
                };
            })();
        })();
    </script>

    @stack('scripts')
</body>

</html>
