<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié - EventManager</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: white;
            padding: 2.5rem 2rem;
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
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 1rem;
            position: relative;
        }

        .card-body {
            padding: 2.5rem 2rem;
        }

        /* Icon Section */
        .password-icon {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .icon-container {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .icon-container i {
            font-size: 2rem;
            color: white;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #6B7280;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 12px;
            font-size: 1rem;
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
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25);
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
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.35);
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
            font-size: 0.9rem;
            color: #4F46E5;
            margin-bottom: 1.5rem;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #f9fafb;
            transition: all 0.3s ease;
        }

        .back-to-login:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
            transform: translateY(-1px);
            color: #3730A3;
        }

        .instruction-text {
            text-align: center;
            color: #6B7280;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            padding: 0 0.5rem;
        }

        .register-link {
            text-align: center;
            font-size: 0.95rem;
            color: #6B7280;
            margin-top: 2rem;
        }

        .register-link a {
            color: #4F46E5;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
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
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background: #fef2f2;
            border-radius: 8px;
            border: 1px solid #fecaca;
        }

        .success-message {
            background: #F0FDF4;
            color: #166534;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            text-align: center;
            border: 1.5px solid #BBF7D0;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
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

        .help-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px solid #e5e7eb;
        }

        .help-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .help-tips {
            display: grid;
            gap: 0.75rem;
        }

        .tip {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .tip i {
            color: #4F46E5;
            width: 16px;
        }

        .footer {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        @media (max-width: 480px) {
            .login-card {
                max-width: 100%;
            }

            .card-body {
                padding: 2rem 1.5rem;
            }

            .card-header {
                padding: 2rem 1.5rem;
            }
        }

        /* Animation pour l'envoi */
        @keyframes sendAnimation {
            0% { transform: translateX(0); }
            50% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }

        .sending i {
            animation: sendAnimation 0.6s ease;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="card-header">
            <h2>
                <i class="fas fa-key"></i>
                Mot de passe oublié
            </h2>
            <p>Recevez un lien de réinitialisation par email</p>
        </div>

        <div class="card-body">
            <!-- Icône centrale -->
            <div class="password-icon">
                <div class="icon-container">
                    <i class="fas fa-unlock-alt"></i>
                </div>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <div class="instruction-text">
                {{ __('Mot de passe oublié ? Aucun problème. Indiquez-nous simplement votre adresse email et nous vous enverrons un lien de réinitialisation de mot de passe qui vous permettra d\'en choisir un nouveau.') }}
            </div>

            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                @csrf

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Adresse email
                    </label>
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
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Bouton d'envoi -->
                <div style="margin: 2rem 0;">
                    <button type="submit" class="btn-primary" id="submitButton">
                        <span class="spinner"></span>
                        <i class="fas fa-paper-plane"></i>
                        <span class="button-text">Envoyer le lien de réinitialisation</span>
                    </button>
                </div>

                <!-- Bouton retour -->
                <a href="{{ route('login') }}" class="back-to-login">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la connexion
                </a>

                <!-- Section d'aide -->
                <div class="help-section">
                    <div class="help-title">
                        <i class="fas fa-question-circle"></i>
                        Informations importantes
                    </div>
                    <div class="help-tips">
                        <div class="tip">
                            <i class="fas fa-check"></i>
                            Le lien de réinitialisation expire après 1 heure
                        </div>
                        <div class="tip">
                            <i class="fas fa-check"></i>
                            Vérifiez vos spams si vous ne recevez pas l'email
                        </div>
                        <div class="tip">
                            <i class="fas fa-check"></i>
                            Utilisez l'adresse email associée à votre compte
                        </div>
                    </div>
                </div>

                <!-- Lien d'inscription -->
                <div class="register-link">
                    <span>Pas de compte ?</span>
                    <a href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i>
                        Créer un compte
                    </a>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <i class="fas fa-shield-alt"></i>
                    <p>&copy; 2025 EventManager. Tous droits réservés.</p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forgotPasswordForm = document.getElementById('forgotPasswordForm');
            const submitButton = document.getElementById('submitButton');

            // Animation lors de l'envoi
            forgotPasswordForm.addEventListener('submit', function(e) {
                const icon = submitButton.querySelector('i');
                submitButton.classList.add('sending');

                setTimeout(() => {
                    submitButton.classList.remove('sending');
                }, 600);
            });

            // Form submission with loading animation
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
                        errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i> Veuillez entrer une adresse email valide';
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

            // Empêcher le spam avec un délai
            let canSubmit = true;

            forgotPasswordForm.addEventListener('submit', function(e) {
                if (!canSubmit) {
                    e.preventDefault();
                    return;
                }

                canSubmit = false;
                submitButton.disabled = true;
                const originalText = submitButton.querySelector('.button-text').textContent;

                // Compte à rebours de 30 secondes
                let countdown = 30;
                const countdownInterval = setInterval(() => {
                    if (countdown > 0) {
                        submitButton.querySelector('.button-text').textContent = `Réessayer dans ${countdown}s`;
                        countdown--;
                    } else {
                        clearInterval(countdownInterval);
                        submitButton.querySelector('.button-text').textContent = originalText;
                        submitButton.disabled = false;
                        canSubmit = true;
                    }
                }, 1000);
            });
        });
    </script>
</body>
</html>
