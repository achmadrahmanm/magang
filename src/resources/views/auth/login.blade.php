<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laravel App</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            min-height: 100vh !important;
            height: 100vh !important;
            /* display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            padding: 0 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            overflow: auto !important; */
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
            margin-bottom: 2rem;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            <h1>Welcome Back</h1>
            <p>Please sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email or Username</label>
                <input 
                    type="text" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    value="{{ old('email') }}"
                    placeholder="Enter your email or username"
                    required
                    autofocus
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control password-input" 
                        placeholder="Enter your password"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <span id="password-icon">🔒</span>
                    </button>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="login-btn">
                Sign In
            </button>
        </form>

        <div class="form-footer">
            <a href="#">Forgot your password?</a>
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
        });
    </script>
</body>
</html>