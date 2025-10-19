<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - EventManager</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 0.95rem;
            position: relative;
        }

        .card-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 0.75rem;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #6B7280;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 0.75rem 0.75rem 2.5rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-control:focus+.input-icon {
            color: #4F46E5;
        }

        .toggle-visibility {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0.375rem;
            cursor: pointer;
            color: #6B7280;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .toggle-visibility:hover {
            color: #4F46E5;
            background: rgba(79, 70, 229, 0.1);
            transform: translateY(-50%) scale(1.1);
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: white;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4338CA 0%, #5853DF 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-primary .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        .btn-primary.loading .spinner {
            display: inline-block;
        }

        .btn-primary.loading .button-text {
            opacity: 0.8;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .forgot-password {
            display: block;
            text-align: center;
            font-size: 0.85rem;
            color: #4F46E5;
            margin-bottom: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
        }


        .forgot-password:hover {
            color: red;
        }


        .separator {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .separator::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #E5E7EB;
        }

        .separator span {
            background: white;
            padding: 0 1rem;
            color: #6B7280;
            font-size: 0.8rem;
        }

        .register-link {
            text-align: center;
            font-size: 0.9rem;
            color: #6B7280;
        }

        .register-link a {
            color: #4F46E5;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
        }

        .register-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #4F46E5;
            transition: width 0.3s ease;
        }

        .register-link a:hover {
            color: #3730A3;
        }

        .register-link a:hover::after {
            width: 100%;
        }

        .error-message {
            color: #EF4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .error-message::before {
            content: '⚠';
            font-size: 0.7rem;
        }

        .success-message {
            background: #F0FDF4;
            color: #166534;
            padding: 0.875rem;
            border-radius: 10px;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
            text-align: center;
            border: 1.5px solid #BBF7D0;
            position: relative;
            overflow: hidden;
        }

        .success-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #22C55E;
        }

        .footer {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
            font-size: 0.75rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }


        .remember-me label {
            font-size: 0.875rem;
            color: #374151;
            cursor: pointer;
            margin: 0;
        }

        @media (max-width: 480px) {
            .login-card {
                max-width: 100%;
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-card border">
        <div class="card-header">
            <h2>Connexion</h2>
            <p>Accédez à votre compte EventManager</p>
        </div>

        <div class="card-body">
            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.5a2.25 2.25 0 01-2.26 0l-7.5-4.5a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autofocus class="form-control" placeholder="votre@email.com">
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="flex space-x-3 justify-between items-center w-full">
                        <div>
                            <label for="password">Mot de passe</label>
                        </div>


                        @if (Route::has('password.request'))
                            <div >

                                <a href="{{ route('password.request') }}" class="forgot-password">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="input-wrapper">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.125 11.25h11.25a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25h-11.25a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="form-control" placeholder="••••••••">
                        <button type="button" class="toggle-visibility" aria-label="Afficher le mot de passe"
                            data-target="password">
                            <svg class="eye-open h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg class="eye-closed h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.5a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Se souvenir de moi</label>
                </div>



                <div style="margin: 1.5rem 0;">
                    <button type="submit" class="btn-primary" id="submitButton">
                        <span class="spinner"></span>
                        <span class="button-text">Se connecter</span>
                    </button>
                </div>

                <div class="register-link">
                    <span style="margin-right: 0.5rem ;">Pas de compte ?</span><a href="{{ route('register') }}">Créer
                        un compte</a>
                </div>

                <div class="footer">
                    <p>&copy; 2025 EventManager. Tous droits réservés.</p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            document.querySelectorAll('.toggle-visibility').forEach(function(button) {
                const targetId = button.getAttribute('data-target');
                const input = document.getElementById(targetId);
                if (!input) return;

                button.addEventListener('click', function() {
                    const isPassword = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isPassword ? 'text' : 'password');
                    button.setAttribute('aria-label', isPassword ? 'Masquer le mot de passe' :
                        'Afficher le mot de passe');

                    const eyeOpen = button.querySelector('.eye-open');
                    const eyeClosed = button.querySelector('.eye-closed');
                    if (eyeOpen && eyeClosed) {
                        if (isPassword) {
                            eyeOpen.style.display = 'none';
                            eyeClosed.style.display = 'block';
                        } else {
                            eyeOpen.style.display = 'block';
                            eyeClosed.style.display = 'none';
                        }
                    }
                });
            });

            // Form submission with loading animation
            const loginForm = document.getElementById('loginForm');
            const submitButton = document.getElementById('submitButton');

            loginForm.addEventListener('submit', function(e) {
                // Basic form validation
                const requiredFields = loginForm.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#EF4444';
                    } else {
                        field.style.borderColor = '#E5E7EB';
                    }
                });

                if (isValid) {
                    submitButton.classList.add('loading');
                    submitButton.disabled = true;

                    // Simulate form submission (remove this in production)
                    setTimeout(() => {
                        submitButton.classList.remove('loading');
                        submitButton.disabled = false;
                    }, 2000);
                } else {
                    e.preventDefault();
                }
            });

            // Input focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.querySelector('.input-icon').style.color = '#4F46E5';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.querySelector('.input-icon').style.color = '#6B7280';
                });
            });

            // Remember me checkbox styling
            const rememberCheckbox = document.getElementById('remember');
            if (rememberCheckbox) {
                rememberCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        this.style.backgroundColor = '#4F46E5';
                        this.style.borderColor = '#4F46E5';
                    } else {
                        this.style.backgroundColor = 'white';
                        this.style.borderColor = '#D1D5DB';
                    }
                });
            }
        });
    </script>
</body>

</html>
