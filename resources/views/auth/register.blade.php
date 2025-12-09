<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - EventManager</title>

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
            display: flex;
            height: fit-content;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .register-container {
            width: 100%;
            max-width: 420px;
        }

        .register-card {
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

        /* Google Button */
        .google-section {
            margin-bottom: 1.5rem;
        }

        .google-btn {
            width: 100%;
            background: #ffffff;
            color: #374151;
            padding: 0.875rem 1.25rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            text-decoration: none;
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .google-btn:hover {
            background: #f9fafb;
            border-color: #D1D5DB;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .google-icon {
            width: 18px;
            height: 18px;
        }

        /* Séparateur */
        .separator {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #6B7280;
            font-size: 0.85rem;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #E5E7EB;
        }

        .separator span {
            padding: 0 0.75rem;
            background: white;
        }

        /* Account Type Selection Compact */
        .account-type-section {
            margin-bottom: 1.25rem;
        }

        .account-type-label {
            display: block;
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .account-type-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .account-card {
            position: relative;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            padding: 1rem 0.75rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
        }

        .account-card:hover {
            border-color: #4F46E5;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        }

        .account-card.selected {
            border-color: #4F46E5;
            background: #F8FAFF;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        }

        .account-icon {
            width: 36px;
            height: 36px;
            margin: 0 auto 0.5rem;
            border-radius: 10px;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: white;
        }

        .account-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1E3A8A;
            margin-bottom: 0.25rem;
        }

        .account-description {
            font-size: 0.7rem;
            color: #6B7280;
            line-height: 1.3;
        }

        .account-radio {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .selected-indicator {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            width: 16px;
            height: 16px;
            border: 2px solid #D1D5DB;
            border-radius: 50%;
            background: white;
            transition: all 0.2s ease;
        }

        .account-card.selected .selected-indicator {
            border-color: #4F46E5;
            background: #4F46E5;
        }

        .account-card.selected .selected-indicator::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
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

        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
            height: 3px;
            border-radius: 1.5px;
            background: #E5E7EB;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 1.5px;
            transition: all 0.2s ease;
        }

        .strength-weak {
            background: #EF4444;
        }

        .strength-medium {
            background: #F59E0B;
        }

        .strength-strong {
            background: #10B981;
        }

        .strength-text {
            font-size: 0.7rem;
            margin-top: 0.25rem;
            color: #6B7280;
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

        /* Login Link */
        .login-link {
            text-align: center;
            font-size: 0.9rem;
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
            .register-container {
                max-width: 100%;
            }

            .card-body {
                padding: 1.5rem 1.25rem;
            }

            .card-header {
                padding: 1.5rem 1.25rem;
            }

            .account-type-cards {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .account-card {
                padding: 0.875rem 0.5rem;
            }

            .google-btn, .btn-primary {
                padding: 0.75rem 1rem;
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

            .account-icon {
                width: 32px;
                height: 32px;
                padding: 6px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-user-plus"></i>
                    Inscription
                </h2>
                <p>Créez votre compte EventManager</p>
            </div>

            <div class="card-body">
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

                <!-- Google Login -->
                <div class="google-section">
                    <a href="{{ route('auth.google.redirect') }}" class="google-btn">
                        <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12 s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C33.602,6.053,29.062,4,24,4C12.955,4,4,12.955,4,24 s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,16.108,18.961,14,24,14c3.059,0,5.842,1.154,7.961,3.039 l5.657-5.657C33.602,6.053,29.062,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.193l-6.191-5.238C29.211,35.091,26.715,36,24,36 c-5.202,0-9.619-3.317-11.283-7.946l-6.541,5.036C9.507,39.556,16.227,44,24,44z"/>
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.794,2.241-2.231,4.166-4.095,5.569 c0.001-0.001,0.002-0.001,0.003-0.002l6.191,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                        </svg>
                        <span>Continuer avec Google</span>
                    </a>
                </div>

                <!-- Séparateur -->
                <div class="separator">
                    <span>ou créez un compte avec email</span>
                </div>

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <!-- Account Type Selection -->
                    <div class="account-type-section">
                        <label class="account-type-label">
                            <i class="fas fa-user-tag"></i>
                            Type de compte
                        </label>
                        <div class="account-type-cards">
                            <!-- User Card -->
                            <label class="account-card {{ old('account_type', 'user') === 'user' ? 'selected' : '' }}">
                                <input type="radio" name="account_type" value="user" class="account-radio"
                                    {{ old('account_type', 'user') === 'user' ? 'checked' : '' }}>
                                <div class="selected-indicator"></div>
                                <div class="account-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="account-title">Participant</div>
                                <div class="account-description">
                                    Participer aux événements
                                </div>
                            </label>

                            <!-- Organizer Card -->
                            <label class="account-card {{ old('account_type') === 'organizer' ? 'selected' : '' }}">
                                <input type="radio" name="account_type" value="organizer" class="account-radio"
                                    {{ old('account_type') === 'organizer' ? 'checked' : '' }}>
                                <div class="selected-indicator"></div>
                                <div class="account-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="account-title">Organisateur</div>
                                <div class="account-description">
                                    Créer des événements
                                </div>
                            </label>
                        </div>
                        @error('account_type')
                            <span class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Nom complet -->
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            Nom complet
                        </label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                            </svg>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="form-control" placeholder="Votre nom complet">
                        </div>
                        @error('name')
                            <span class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Adresse email
                        </label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.5a2.25 2.25 0 01-2.26 0l-7.5-4.5a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="form-control" placeholder="votre@email.com">
                        </div>
                        @error('email')
                            <span class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Mot de passe
                        </label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.125 11.25h11.25a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25h-11.25a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <input id="password" type="password" name="password" required
                                   class="form-control" placeholder="••••••••" autocomplete="new-password">
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
                        <!-- Password Strength Indicator -->
                        <div class="password-strength">
                            <div class="strength-bar" id="passwordStrengthBar"></div>
                        </div>
                        <div class="strength-text" id="passwordStrengthText"></div>
                        @error('password')
                            <span class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">
                            <i class="fas fa-lock"></i>
                            Confirmer le mot de passe
                        </label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.125 11.25h11.25a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25h-11.25a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="form-control" placeholder="••••••••">
                            <button type="button" class="toggle-visibility" aria-label="Afficher le mot de passe"
                                    data-target="password_confirmation">
                                <svg class="eye-open" width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <svg class="eye-closed" width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.5a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88"/>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
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
                            <i class="fas fa-user-plus"></i>
                            <span class="button-text">Créer mon compte</span>
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="login-link">
                        <span>Déjà un compte ?</span>
                        <a href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i>
                            Se connecter
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
            // Account type card selection
            const accountCards = document.querySelectorAll('.account-card');

            accountCards.forEach(card => {
                card.addEventListener('click', function() {
                    accountCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');

                    const radio = this.querySelector('.account-radio');
                    if (radio) {
                        radio.checked = true;
                    }
                });
            });

            // Password visibility toggle (identique au login)
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

            // Password strength checker (version simplifiée)
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');

            if (passwordInput && strengthBar && strengthText) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;

                    if (password.length === 0) {
                        strengthBar.style.width = '0%';
                        strengthBar.className = 'strength-bar';
                        strengthText.textContent = '';
                        return;
                    }

                    let score = 0;
                    if (password.length >= 8) score++;
                    if (/[A-Z]/.test(password)) score++;
                    if (/[0-9]/.test(password)) score++;
                    if (/[^A-Za-z0-9]/.test(password)) score++;

                    const percentage = (score / 4) * 100;
                    strengthBar.style.width = percentage + '%';

                    if (score <= 1) {
                        strengthBar.className = 'strength-bar strength-weak';
                        strengthText.textContent = 'Faible';
                    } else if (score <= 2) {
                        strengthBar.className = 'strength-bar strength-medium';
                        strengthText.textContent = 'Moyen';
                    } else {
                        strengthBar.className = 'strength-bar strength-strong';
                        strengthText.textContent = 'Fort';
                    }
                });
            }

            // Form submission with loading animation (identique au login)
            const registerForm = document.getElementById('registerForm');
            const submitButton = document.getElementById('submitButton');

            if (registerForm && submitButton) {
                registerForm.addEventListener('submit', function(e) {
                    const requiredFields = registerForm.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.style.borderColor = '#EF4444';
                        } else {
                            field.style.borderColor = '#E5E7EB';
                        }
                    });

                    // Password confirmation validation
                    const password = document.getElementById('password')?.value;
                    const passwordConfirmation = document.getElementById('password_confirmation')?.value;

                    if (password && passwordConfirmation && password !== passwordConfirmation) {
                        isValid = false;
                        const confirmField = document.getElementById('password_confirmation');
                        if (confirmField) {
                            confirmField.style.borderColor = '#EF4444';
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

            // Input focus effects (identique au login)
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
        });
    </script>
</body>
</html>
