<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    {{-- add favicon and meta og for sharing --}}
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta property="og:title" content="Login">
    <meta property="og:description" content="Login to the application">
    <meta property="og:image" content="/icons/logo.svg">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            height: 100% !important;
            overflow-x: hidden !important;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; */
            background: url('/images/background.jpg') !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            backdrop-filter: blur(5px) !important;
            /* make background dimmer */


            min-height: 100vh !important;
            height: 100vh !important;
        }

        .login-wrapper {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            position: relative !important;
            z-index: 9999 !important;
        }

        .login-container {
            background: white !important;
            padding: 3rem 2.5rem !important;
            border-radius: 16px !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
            width: 100% !important;
            max-width: 400px !important;
            position: relative !important;
            margin: auto !important;
            transform: translateZ(0) !important;
            z-index: 10000 !important;
        }

        .login-header {
            text-align: center;
            /* margin-bottom: 2rem; */
        }

        .login-header h1 {
            color: #333;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #666;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
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
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background-color: white;
        }

        .password-input {
            padding-right: 3rem;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            color: #666;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #333;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 0.5rem;
            width: 1.1rem;
            height: 1.1rem;
            accent-color: #667eea;
        }

        .remember-me label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            background: #29166f;
            color: white;
            border: none;
            padding: 0.875rem 1rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e1e5e9;
        }

        .form-footer a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 1rem !important;
                padding: 2rem 1.5rem !important;
            }
        }

        /* Prevent extension interference */
        /* body:not([style*="sw-si-extension"]) {
            position: fixed !important;
        } */

        /* Override any external extension styles */
        /* #sw-si-extension-global-style ~ * .login-container,
        body[data-extension] .login-container {
            position: relative !important;
            display: block !important;
        } */
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <img src="/icons/logo.svg" alt="App Logo" style="width:55%; height: auto;">
                {{-- <h1>Welcome Back</h1>
                <p>Please sign in to your account</p> --}}
            </div>

            <form id="login-form" method="POST" action="{{ route('api.login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email or Username</label>
                    <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}"
                        placeholder="Enter your email or username" required autofocus>
                    <span id="email-error" class="error-message">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="form-control password-input"
                            placeholder="Enter your password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <span id="password-icon">🔒</span>
                        </button>
                    </div>
                    <span id="password-error" class="error-message">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="login-btn mb-3">
                    Login
                </button>

                <div id="general-error" style="margin-top:0.75rem; text-align:center; color:#dc3545"></div>

                {{-- <p style="color: #667eea; text-decoration: underline; text-align: center; font-size: 0.9rem; margin-top:5px;"><a href="#" >Forgot your password?</a></p> --}}
                <p class="signup-link" style="margin-top:10px">Forgot your password? <a href="#">Reset here</a>
                </p>

            </form>

            <div>
                {{-- SSO google login button --}}
                <div class="sso-section">
                    <div class="divider">
                        <span>or continue with</span>
                    </div>
                    <a href="#" class="sso-btn google-btn">
                        <svg class="google-icon" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span>Continue with Google</span>
                    </a>
                </div>

                <style>
                    .sso-section {
                        margin-top: 1rem;
                    }

                    .divider {
                        position: relative;
                        text-align: center;
                        margin: 1.5rem 0;
                    }

                    .divider::before {
                        content: '';
                        position: absolute;
                        top: 50%;
                        left: 0;
                        right: 0;
                        height: 1px;
                        background: #e1e5e9;
                    }

                    .divider span {
                        background: white;
                        padding: 0 1rem;
                        color: #666;
                        font-size: 0.85rem;
                        position: relative;
                        z-index: 1;
                    }

                    .google-btn {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 100%;
                        padding: 0.875rem 1rem;
                        border: 2px solid #e1e5e9;
                        border-radius: 8px;
                        background: white;
                        color: #333;
                        text-decoration: none;
                        font-weight: 500;
                        font-size: 0.95rem;
                        transition: all 0.3s ease;
                        margin-bottom: 1rem;
                    }

                    .google-btn:hover {
                        border-color: #4285F4;
                        box-shadow: 0 4px 12px rgba(66, 133, 244, 0.15);
                        transform: translateY(-1px);
                    }

                    .google-icon {
                        margin-right: 0.75rem;
                    }

                    .signup-link {
                        text-align: center;
                        color: #666;
                        font-size: 0.9rem;
                        margin: 0;
                    }

                    .signup-link a {
                        color: #667eea;
                        text-decoration: none;
                        font-weight: 500;
                    }

                    .signup-link a:hover {
                        text-decoration: underline;
                    }
                </style>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.textContent = '🔓';
            } else {
                passwordInput.type = 'password';
                passwordIcon.textContent = '🔒';
            }
        }

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');

            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.parentNode.style.transform = 'scale(1.02)';
                    this.parentNode.parentNode.style.transition = 'transform 0.3s ease';
                });

                input.addEventListener('blur', function() {
                    this.parentNode.parentNode.style.transform = 'scale(1)';
                });
            });

            // AJAX login handler: submit to API, store token and redirect based on role
            const loginForm = document.getElementById('login-form');
            if (loginForm) {
                loginForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    clearErrors();

                    const email = document.getElementById('email').value.trim();
                    const password = document.getElementById('password').value;
                    const remember = document.getElementById('remember').checked;

                    try {
                        const res = await fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                email,
                                password,
                                remember
                            })
                        });

                        if (res.ok) {
                            const data = await res.json();
                            // store token for API calls
                            try {
                                localStorage.setItem('api_token', data.token);
                            } catch (err) {
                                /* ignore */
                            }

                            const role = data.user && data.user.role ? data.user.role : null;
                            let path = '/dashboard';
                            switch (role) {
                                case 'sysadmin':
                                    path = '/dashboard/sysadmin';
                                    break;
                                case 'mahasiswa':
                                    path = '/dashboard/mahasiswa';
                                    break;
                                case 'dosen':
                                    path = '/dashboard/dosen';
                                    break;
                                case 'management':
                                    path = '/dashboard/management';
                                    break;
                                default:
                                    path = '/dashboard';
                            }

                            // Try to create a server session by POSTing to the web /login endpoint (will set laravel-session cookie)
                            try {
                                const tokenInput = document.querySelector('input[name="_token"]');
                                const csrf = tokenInput ? tokenInput.value : document.querySelector(
                                    'meta[name="csrf-token"]')?.getAttribute('content');

                                // Attempt a same-origin fetch so browser accepts Set-Cookie
                                await fetch('/login', {
                                    method: 'POST',
                                    credentials: 'same-origin',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrf || ''
                                    },
                                    body: JSON.stringify({
                                        email,
                                        password,
                                        remember
                                    })
                                });

                                // Navigate to dashboard (server will now recognize session)
                                window.location.href = path;
                                return;
                            } catch (err) {
                                try {
                                    // Fallback: submit hidden form which also establishes session
                                    const f = document.createElement('form');
                                    f.method = 'POST';
                                    f.action = '/login';
                                    f.style.display = 'none';

                                    const iCsrf = document.createElement('input');
                                    iCsrf.type = 'hidden';
                                    iCsrf.name = '_token';
                                    iCsrf.value = document.querySelector('input[name="_token"]')
                                        ?.value || '';
                                    f.appendChild(iCsrf);

                                    const iEmail = document.createElement('input');
                                    iEmail.type = 'hidden';
                                    iEmail.name = 'email';
                                    iEmail.value = email;
                                    f.appendChild(iEmail);

                                    const iPass = document.createElement('input');
                                    iPass.type = 'hidden';
                                    iPass.name = 'password';
                                    iPass.value = password;
                                    f.appendChild(iPass);

                                    const iRemember = document.createElement('input');
                                    iRemember.type = 'hidden';
                                    iRemember.name = 'remember';
                                    iRemember.value = remember ? 'on' : '';
                                    f.appendChild(iRemember);

                                    document.body.appendChild(f);
                                    f.submit();
                                    return;
                                } catch (e) {
                                    // fallback to client-side redirect if session setup fails
                                    window.location.href = path;
                                    return;
                                }
                            }
                            return;
                        }

                        // handle validation errors
                        if (res.status === 422) {
                            const json = await res.json();
                            if (json.errors) {
                                if (json.errors.email) document.getElementById('email-error')
                                    .textContent = json.errors.email.join(' ');
                                if (json.errors.password) document.getElementById('password-error')
                                    .textContent = json.errors.password.join(' ');
                            } else if (json.message) {
                                document.getElementById('general-error').textContent = json.message;
                            }
                            return;
                        }

                        // other errors
                        let text = await res.text();
                        document.getElementById('general-error').textContent = text || 'Login failed';

                    } catch (err) {
                        document.getElementById('general-error').textContent =
                            'Network error. Please try again.';
                        console.error(err);
                    }
                });
            }

            function clearErrors() {
                const eEmail = document.getElementById('email-error');
                if (eEmail) eEmail.textContent = '';
                const ePass = document.getElementById('password-error');
                if (ePass) ePass.textContent = '';
                const eGen = document.getElementById('general-error');
                if (eGen) eGen.textContent = '';
            }
        });
    </script>
</body>

</html>
