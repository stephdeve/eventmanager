<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confirmer le mot de passe - EventManager</title>

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

        .confirm-container {
            width: 100%;
            max-width: 420px;
        }

        .confirm-card {
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

        /* Info Message */
        .info-message {
            background: #EFF6FF;
            color: #1E40AF;
            padding: 0.875rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            border: 1.5px solid #BFDBFE;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .info-icon {
            color: #3B82F6;
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            margin-top: 0.125rem;
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

        .toggle-visibility {
            position: absolute;
            top: 50%;
            right: 0.875rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0.4rem;
            cursor: pointer;
            color: #6B7280;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border-radius: 5px;
        }

        .toggle-visibility:hover {
            color: #4F46E5;
            background: rgba(79, 70, 229, 0.08);
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

        /* Cancel Link */
        .cancel-link {
            display: block;
            text-align: center;
            font-size: 0.85rem;
            color: #6B7280;
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

        .cancel-link:hover {
            background: #f1f5f9;
            border-color: #d1d5db;
            color: #374151;
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
            .confirm-container {
                max-width: 100%;
            }

            .card-body {
                padding: 1.5rem 1.25rem;
            }

            .card-header {
                padding: 1.5rem 1.25rem;
            }

            .btn-primary {
                padding: 0.75rem 1rem;
            }

            .info-message {
                padding: 0.75rem;
                font-size: 0.8rem;
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

            .info-message {
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <div class="confirm-container">
        <div class="confirm-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-shield-alt"></i>
                    Confirmation requise
                </h2>
                <p>Zone sécurisée de l'application</p>
            </div>

            <div class="card-body">
                <!-- Info Message -->
                <div class="info-message">
                    <svg class="info-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.</span>
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

                <form method="POST" action="{{ route('password.confirm') }}" id="confirmForm">
                    @csrf

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Mot de passe
                        </label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.125 11.25h11.25a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25h-11.25a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="form-control" placeholder="••••••••">
                            <button type="button" class="toggle-visibility" aria-label="Afficher le mot de passe"
                                    data-target="password">
                                <svg class="eye-open" width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <svg class="eye-closed" width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.5a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
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
                            <i class="fas fa-shield-alt"></i>
                            <span class="button-text">Confirmer le mot de passe</span>
                        </button>
                    </div>

                    <!-- Cancel Link -->
                    @if (Route::has('home'))
                        <a href="{{ route('home') }}" class="cancel-link">
                            <i class="fas fa-times"></i>
                            Annuler et retourner à l'accueil
                        </a>
                    @else
                        <a href="{{ url('/') }}" class="cancel-link">
                            <i class="fas fa-times"></i>
                            Annuler et retourner à l'accueil
                        </a>
                    @endif

                    <!-- Footer -->
                    <div class="footer">
                        <i class="fas fa-lock"></i>
                        <p>&copy; 2025 EventManager. Tous droits réservés.</p>
                    </div>
                </form>
            </div>
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
            const confirmForm = document.getElementById('confirmForm');
            const submitButton = document.getElementById('submitButton');

            if (confirmForm && submitButton) {
                confirmForm.addEventListener('submit', function(e) {
                    const requiredFields = confirmForm.querySelectorAll('[required]');
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

                // Clear error styling on input
                input.addEventListener('input', function() {
                    this.style.borderColor = '#E5E7EB';
                    const existingError = this.parentElement.nextElementSibling;
                    if (existingError && existingError.classList.contains('form-error')) {
                        existingError.remove();
                    }
                });
            });
        });
    </script>
</body>
</html>
