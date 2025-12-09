<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié - EventManager</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=sora:400,500,600,700&family=inter:400,500,600,700&display=swap" rel="stylesheet" />
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
            font-family: 'Sora', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .forgot-container {
            width: 100%;
            max-width: 420px;
        }

        .forgot-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-header {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: white;
            padding: 1.75rem 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 0.9rem;
            position: relative;
        }

        .card-body {
            padding: 1.75rem 1.5rem;
        }

        /* Messages */
        .success-message, .error-message {
            padding: 0.75rem;
            border-radius: 10px;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
            text-align: center;
            border-width: 1.5px;
            border-style: solid;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .success-message {
            background: #F0FDF4;
            color: #166534;
            border-color: #BBF7D0;
        }

        .error-message {
            background: #FEF2F2;
            color: #991B1B;
            border-color: #FECACA;
        }

        /* Icon */
        .password-icon {
            text-align: center;
            margin-bottom: 1rem;
        }

        .icon-container {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .icon-container i {
            font-size: 1.25rem;
            color: white;
        }

        /* Instruction Text */
        .instruction-text {
            text-align: center;
            color: #6B7280;
            font-size: 0.85rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            padding: 0 0.25rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 0.875rem;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: #6B7280;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            box-sizing: border-box;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.08);
        }

        .form-control:focus + .input-icon {
            color: #4F46E5;
        }

        /* Submit Button */
        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: white;
            padding: 0.875rem 1.25rem;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4338CA 0%, #5853DF 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25);
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
            width: 14px;
            height: 14px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .btn-primary.loading .spinner {
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Back to Login Button */
        .back-to-login {
            display: block;
            text-align: center;
            font-size: 0.85rem;
            color: #4F46E5;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 1.25rem;
            padding: 0.75rem;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            background: #f8fafc;
        }

        .back-to-login:hover {
            background: #f1f5f9;
            border-color: #d1d5db;
            color: #3730A3;
        }

        /* Help Section Compact */
        .help-section {
            background: #f8fafc;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1.25rem;
            border: 1px solid #e5e7eb;
        }

        .help-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
        }

        .help-tips {
            display: grid;
            gap: 0.5rem;
        }

        .tip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: #6b7280;
            line-height: 1.4;
        }

        .tip i {
            color: #4F46E5;
            width: 12px;
            flex-shrink: 0;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            font-size: 0.85rem;
            color: #6B7280;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: #4F46E5;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .login-link a:hover {
            color: #3730A3;
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        /* Form Errors */
        .form-error {
            color: #EF4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.5rem;
            background: #fef2f2;
            border-radius: 6px;
            border: 1px solid #fecaca;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .forgot-container {
                max-width: 100%;
            }

            .card-body {
                padding: 1.5rem 1.25rem;
            }

            .card-header {
                padding: 1.5rem 1.25rem;
            }

            .icon-container {
                width: 52px;
                height: 52px;
            }

            .icon-container i {
                font-size: 1.1rem;
            }

            .btn-primary {
                padding: 0.75rem 1rem;
            }

            .help-section {
                padding: 0.875rem;
            }
        }

        @media (max-width: 360px) {
            .card-header h2 {
                font-size: 1.35rem;
            }

            .form-control {
                padding: 0.65rem 0.75rem 0.65rem 2.5rem;
                font-size: 0.9rem;
            }

            .input-icon {
                left: 0.75rem;
                width: 14px;
                height: 14px;
            }

            .instruction-text {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="forgot-container">
        <div class="forgot-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-key"></i>
                    Mot de passe oublié
                </h2>
                <p>Recevez un lien de réinitialisation</p>
            </div>

            <div class="card-body">
                <!-- Icon -->
                <div class="password-icon">
                    <div class="icon-container">
                        <i class="fas fa-unlock-alt"></i>
                    </div>
                </div>

                <!-- Messages -->
                @if (session('status'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Instruction Text -->
                <div class="instruction-text">
                    {{ __('Entrez votre adresse email pour recevoir un lien de réinitialisation de mot de passe.') }}
                </div>

                <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                    @csrf

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Adresse email
                        </label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.5a2.25 2.25 0 01-2.26 0l-7.5-4.5a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="form-control" placeholder="votre@email.com">
                        </div>
                        @error('email')
                            <span class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div style="margin: 1.5rem 0;">
                        <button type="submit" class="btn-primary" id="submitButton">
                            <span class="spinner"></span>
                            <i class="fas fa-paper-plane"></i>
                            <span class="button-text">Envoyer le lien</span>
                        </button>
                    </div>

                    <!-- Back to Login -->
                    <a href="{{ route('login') }}" class="back-to-login">
                        <i class="fas fa-arrow-left"></i>
                        Retour à la connexion
                    </a>

                    <!-- Help Section -->
                    <div class="help-section">
                        <div class="help-title">
                            <i class="fas fa-info-circle"></i>
                            Informations importantes
                        </div>
                        <div class="help-tips">
                            <div class="tip">
                                <i class="fas fa-clock"></i>
                                Lien valide 1 heure
                            </div>
                            <div class="tip">
                                <i class="fas fa-envelope"></i>
                                Vérifiez vos spams
                            </div>
                            <div class="tip">
                                <i class="fas fa-at"></i>
                                Email de votre compte
                            </div>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <div class="login-link">
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forgotPasswordForm = document.getElementById('forgotPasswordForm');
            const submitButton = document.getElementById('submitButton');

            // Form submission with loading animation
            if (forgotPasswordForm && submitButton) {
                forgotPasswordForm.addEventListener('submit', function(e) {
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

                    // Email validation
                    const emailInput = document.getElementById('email');
                    if (emailInput && emailInput.value.trim()) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(emailInput.value.trim())) {
                            isValid = false;
                            emailInput.style.borderColor = '#EF4444';
                            // Remove existing error message if any
                            const existingError = emailInput.parentElement.nextElementSibling;
                            if (existingError && existingError.classList.contains('form-error')) {
                                existingError.remove();
                            }
                            // Add new error message
                            const errorElement = document.createElement('span');
                            errorElement.className = 'form-error';
                            errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i> Veuillez entrer une adresse email valide';
                            emailInput.parentElement.after(errorElement);
                        }
                    }

                    if (isValid) {
                        submitButton.classList.add('loading');
                        submitButton.disabled = true;
                    } else {
                        e.preventDefault();
                    }
                });
            }

            // Input focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    const icon = this.parentElement.querySelector('.input-icon');
                    if (icon) icon.style.color = '#4F46E5';
                });

                input.addEventListener('blur', function() {
                    const icon = this.parentElement.querySelector('.input-icon');
                    if (icon) icon.style.color = '#6B7280';
                });
            });

            // Email validation on blur
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('blur', function() {
                    const email = this.value.trim();
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (email && !emailRegex.test(email)) {
                        this.style.borderColor = '#EF4444';
                        // Remove existing error message if any
                        const existingError = this.parentElement.nextElementSibling;
                        if (existingError && existingError.classList.contains('form-error')) {
                            existingError.remove();
                        }
                        // Add new error message
                        const errorElement = document.createElement('span');
                        errorElement.className = 'form-error';
                        errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i> Veuillez entrer une adresse email valide';
                        this.parentElement.after(errorElement);
                    } else {
                        this.style.borderColor = '#E5E7EB';
                        const existingError = this.parentElement.nextElementSibling;
                        if (existingError && existingError.classList.contains('form-error')) {
                            existingError.remove();
                        }
                    }
                });
            }

            // Clear error on input
            if (emailInput) {
                emailInput.addEventListener('input', function() {
                    this.style.borderColor = '#E5E7EB';
                    const existingError = this.parentElement.nextElementSibling;
                    if (existingError && existingError.classList.contains('form-error')) {
                        existingError.remove();
                    }
                });
            }
        });
    </script>
</body>
</html>
