<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié - EventManager</title>

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

        .back-to-login {
            display: block;
            text-align: center;
            font-size: 0.85rem;
            color: #4F46E5;
            margin-bottom: 1.5rem;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
        }

        .back-to-login:hover {
            color: #3730A3;
        }

        .back-to-login::before {
            content: '←';
            margin-right: 0.5rem;
            font-weight: bold;
        }

        .instruction-text {
            text-align: center;
            color: #6B7280;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            padding: 0 1rem;
        }

        .register-link {
            text-align: center;
            font-size: 0.9rem;
            color: #6B7280;
            margin-top: 1.5rem;
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
            <h2>Réinitialisation du mot de passe</h2>
            <p>Recevez un lien de réinitialisation par email</p>
        </div>

        <div class="card-body border">
            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            <div class="instruction-text">
                {{ __('Mot de passe oublié ? Aucun problème. Indiquez-nous simplement votre adresse email et nous vous enverrons un lien de réinitialisation de mot de passe qui vous permettra d\'en choisir un nouveau.') }}
            </div>

            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
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

                <a href="{{ route('login') }}" class="back-to-login">
                    Retour à la connexion
                </a>

                <div style="margin: 1.5rem 0;">
                    <button type="submit" class="btn-primary" id="submitButton">
                        <span class="spinner"></span>
                        <span class="button-text">Envoyer le lien de réinitialisation</span>
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
            // Form submission with loading animation
            const forgotPasswordForm = document.getElementById('forgotPasswordForm');
            const submitButton = document.getElementById('submitButton');

            forgotPasswordForm.addEventListener('submit', function(e) {
                // Basic form validation
                const requiredFields = forgotPasswordForm.querySelectorAll('[required]');
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

            // Email validation
            const emailInput = document.getElementById('email');
            emailInput.addEventListener('blur', function() {
                const email = this.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email && !emailRegex.test(email)) {
                    this.style.borderColor = '#EF4444';
                    if (!this.parentElement.nextElementSibling?.classList.contains('error-message')) {
                        const errorElement = document.createElement('span');
                        errorElement.className = 'error-message';
                        errorElement.textContent = 'Veuillez entrer une adresse email valide';
                        this.parentElement.after(errorElement);
                    }
                } else {
                    this.style.borderColor = '#E5E7EB';
                    const existingError = this.parentElement.nextElementSibling;
                    if (existingError && existingError.classList.contains('error-message')) {
                        existingError.remove();
                    }
                }
            });
        });
    </script>
</body>

</html>
