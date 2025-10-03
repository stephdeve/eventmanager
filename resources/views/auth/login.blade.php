<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - EventManager</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            margin: 1rem;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            font-weight: 600;
            font-size: 1.25rem;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35);
            margin-bottom: 0.75rem;
        }

        .logo-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            top: 50%;
            left: 0.9rem;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #9ca3af;
            pointer-events: none;
        }
        
        .form-control {
            width: 100%;
            padding: 0.625rem 2.75rem 0.625rem 2.6rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            box-sizing: border-box;
        }

        .toggle-visibility {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0;
            width: 2rem;
            height: 2rem;
            cursor: pointer;
            color: #9ca3af;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .toggle-visibility:focus-visible {
            outline: 2px solid #4f46e5;
            outline-offset: 2px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2);
        }
        
        .btn-primary {
            width: 100%;
            background-color: #4f46e5;
            color: white;
            padding: 0.625rem 1.25rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
        }
        
        .forgot-password {
            display: block;
            text-align: right;
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.5rem;
            text-decoration: none;
        }
        
        .forgot-password:hover {
            color: #4f46e5;
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .register-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <span class="logo-badge">EM</span>
            <p class="logo-title">EventManager</p>
        </div>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Adresse email</label>
                <div class="input-wrapper">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.5a2.25 2.25 0 01-2.26 0l-7.5-4.5a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="form-control" placeholder="votre@email.com">
                </div>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label for="password">Mot de passe</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>
                <div class="input-wrapper">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.125 11.25h11.25a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25h-11.25a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                           class="form-control" placeholder="••••••••">
                    <button type="button" class="toggle-visibility" aria-label="Afficher le mot de passe" data-target="password">
                        <svg class="eye-open h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <svg class="eye-closed h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.5a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div style="margin: 1.5rem 0;">
                <button type="submit" class="btn-primary">
                    Se connecter
                </button>
            </div>
            
            <div class="register-link">
                Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-visibility').forEach(function (button) {
                const targetId = button.getAttribute('data-target');
                const input = document.getElementById(targetId);
                if (!input) {
                    return;
                }

                button.addEventListener('click', function () {
                    const isPassword = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isPassword ? 'text' : 'password');
                    button.setAttribute('aria-label', isPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe');

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
        });
    </script>
</body>
</html>
