<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vérification de l'email - EventManager</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background */
        .auth-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            z-index: -2;
        }

        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.15;
            object-fit: cover;
        }

        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(79, 70, 229, 0.3) 0%, 
                rgba(99, 102, 241, 0.2) 50%, 
                rgba(139, 92, 246, 0.3) 100%);
        }

        /* Animated Elements */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.6;
            animation: float 8s ease-in-out infinite;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #4F46E5, #6366F1);
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #8B5CF6, #A78BFA);
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #3B82F6, #60A5FA);
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) translateX(0px) scale(1);
            }
            25% {
                transform: translateY(-20px) translateX(10px) scale(1.05);
            }
            50% {
                transform: translateY(-10px) translateX(-5px) scale(0.95);
            }
            75% {
                transform: translateY(-30px) translateX(15px) scale(1.02);
            }
        }

        /* Particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: particleFloat 15s linear infinite;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Main Container */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 1;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            width: 100%;
            max-width: 560px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        /* Header */
        .auth-header {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.9), rgba(99, 102, 241, 0.9));
            backdrop-filter: blur(10px);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
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

        .auth-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .auth-header p {
            opacity: 0.9;
            font-size: 1rem;
            position: relative;
        }

        /* Body */
        .auth-body {
            padding: 2.5rem 2rem;
        }

        /* Email Display */
        .email-display {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin: 1.5rem 0;
            color: white;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .email-icon {
            width: 20px;
            height: 20px;
            color: rgba(255, 255, 255, 0.8);
            flex-shrink: 0;
        }

        .email-text {
            flex: 1;
        }

        .email-address {
            font-weight: 600;
            color: white;
        }

        /* Hint Text */
        .hint-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* Button Row */
        .button-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: center;
            margin-bottom: 2rem;
        }

        /* Button */
        .btn-primary {
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
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
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
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Link Button */
        .btn-link {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            padding: 1rem 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .btn-link:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Messages */
        .success-message {
            background: rgba(34, 197, 94, 0.1);
            backdrop-filter: blur(10px);
            color: #86EFAC;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            text-align: center;
            border: 1px solid rgba(34, 197, 94, 0.3);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            backdrop-filter: blur(10px);
            color: #FCA5A5;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            text-align: center;
            border: 1px solid rgba(239, 68, 68, 0.3);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .message-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* Footer */
        .auth-footer {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .button-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .btn-link {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                max-width: 100%;
            }

            .auth-body {
                padding: 2rem 1.5rem;
            }

            .auth-header {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="auth-background">
        <img src="https://images.unsplash.com/photo-1472653431158-636457a7753f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Background" 
             class="background-image"
             onerror="this.style.display='none'">
        <div class="background-overlay"></div>
        
        <!-- Floating Shapes -->
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        
        <!-- Particles -->
        <div class="particles">
            <div class="particle" style="width: 4px; height: 4px; left: 10%; animation-delay: 0s; animation-duration: 12s;"></div>
            <div class="particle" style="width: 3px; height: 3px; left: 20%; animation-delay: 2s; animation-duration: 15s;"></div>
            <div class="particle" style="width: 5px; height: 5px; left: 30%; animation-delay: 4s; animation-duration: 10s;"></div>
            <div class="particle" style="width: 2px; height: 2px; left: 40%; animation-delay: 6s; animation-duration: 18s;"></div>
            <div class="particle" style="width: 6px; height: 6px; left: 50%; animation-delay: 8s; animation-duration: 14s;"></div>
            <div class="particle" style="width: 3px; height: 3px; left: 60%; animation-delay: 10s; animation-duration: 16s;"></div>
            <div class="particle" style="width: 4px; height: 4px; left: 70%; animation-delay: 12s; animation-duration: 13s;"></div>
            <div class="particle" style="width: 5px; height: 5px; left: 80%; animation-delay: 14s; animation-duration: 11s;"></div>
            <div class="particle" style="width: 2px; height: 2px; left: 90%; animation-delay: 16s; animation-duration: 17s;"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Vérification de l'email</h2>
                <p>Confirmez votre adresse pour sécuriser votre compte</p>
            </div>

            <div class="auth-body">
                <!-- Success Message -->
                @if (session('status') == 'verification-link-sent')
                    <div class="success-message">
                        <svg class="message-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Un nouveau lien de vérification a été envoyé à votre adresse email.</span>
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div class="error-message">
                        <svg class="message-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Email Display -->
                <div class="email-display">
                    <svg class="email-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div class="email-text">
                        <span>Adresse email de vérification : </span>
                        <span class="email-address">{{ auth()->user()->email }}</span>
                    </div>
                </div>

                <!-- Hint Text -->
                <p class="hint-text">
                    Avant de continuer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? 
                    Si vous n'avez pas reçu l'email, nous vous en enverrons volontiers un autre.
                </p>

                <!-- Resend Verification Form -->
                <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                    @csrf

                    <div class="button-row">
                        <button type="submit" class="btn-primary" id="resendButton">
                            <span class="spinner"></span>
                            <span class="button-text">Renvoyer l'email de vérification</span>
                        </button>

                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" 
                           class="btn-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            Déconnexion
                        </a>
                    </div>
                </form>

                <!-- Logout Form (Hidden) -->
                <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>

                <div class="auth-footer">
                    <p>&copy; 2025 EventManager. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission with loading animation
            const resendForm = document.getElementById('resendForm');
            const resendButton = document.getElementById('resendButton');

            resendForm.addEventListener('submit', function(e) {
                resendButton.classList.add('loading');
                resendButton.disabled = true;
            });

            // Add hover effects to email display
            const emailDisplay = document.querySelector('.email-display');
            if (emailDisplay) {
                emailDisplay.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 8px 20px rgba(79, 70, 229, 0.2)';
                });

                emailDisplay.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            }
        });
    </script>
</body>

</html>
