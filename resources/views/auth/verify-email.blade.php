<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vérification de l'email - EventManager</title>

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

        .verify-container {
            width: 100%;
            max-width: 420px;
        }

        .verify-card {
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
        .verification-icon {
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

        /* Hint Text */
        .hint {
            color: #6b7280;
            font-size: 0.85rem;
            line-height: 1.5;
            text-align: center;
            margin-bottom: 1.5rem;
            padding: 0 0.25rem;
        }

        /* Button Row */
        .btn-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        /* Primary Button */
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

        /* Link Button */
        .btn-link {
            color: #4F46E5;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            transition: all 0.2s ease;
            background: #f8fafc;
            font-size: 0.85rem;
        }

        .btn-link:hover {
            background: #f1f5f9;
            border-color: #d1d5db;
            color: #3730A3;
        }

        /* Help Section */
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

        /* Footer Text */
        .footer-text {
            text-align: center;
            color: #9ca3af;
            font-size: 0.75rem;
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .verify-container {
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

            .hint {
                font-size: 0.8rem;
            }

            .btn-link {
                font-size: 0.8rem;
                padding: 0.65rem;
            }
        }
    </style>
</head>

<body>
    <div class="verify-container">
        <div class="verify-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-shield-check"></i>
                    Vérification email
                </h2>
                <p>Confirmez votre adresse email</p>
            </div>

            <div class="card-body">
                <!-- Icon -->
                <div class="verification-icon">
                    <div class="icon-container">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                </div>

                <!-- Status Messages -->
                @if (session('status') == 'verification-link-sent')
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        Un nouveau lien de vérification a été envoyé à votre email.
                    </div>
                @endif

                @if (session('error'))
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Hint Text -->
                <div class="hint">
                    Avant de continuer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.
                </div>

                <!-- Action Buttons -->
                <div class="btn-row">
                    <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                        @csrf
                        <button type="submit" class="btn-primary" id="resendButton">
                            <span class="spinner"></span>
                            <i class="fas fa-paper-plane"></i>
                            <span class="button-text">Renvoyer le lien</span>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-link w-full">
                            <i class="fas fa-sign-out-alt"></i>
                            Se déconnecter
                        </button>
                    </form>
                </div>

                <!-- Help Section -->
                <div class="help-section">
                    <div class="help-title">
                        <i class="fas fa-question-circle"></i>
                        Besoin d'aide ?
                    </div>
                    <div class="help-tips">
                        <div class="tip">
                            <i class="fas fa-search"></i>
                            Vérifiez vos spams
                        </div>
                        <div class="tip">
                            <i class="fas fa-clock"></i>
                            Patientez quelques minutes
                        </div>
                        <div class="tip">
                            <i class="fas fa-at"></i>
                            Vérifiez votre adresse email
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="footer-text">
                    <i class="fas fa-life-ring"></i>
                    Contactez le support si nécessaire
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resendButton = document.getElementById('resendButton');
            const resendForm = document.getElementById('resendForm');

            if (resendForm && resendButton) {
                // Form submission with loading animation
                resendForm.addEventListener('submit', function(e) {
                    // Prevent multiple submissions
                    if (resendButton.classList.contains('loading')) {
                        e.preventDefault();
                        return;
                    }

                    resendButton.classList.add('loading');
                    resendButton.disabled = true;

                    // Add cooldown to prevent spam
                    let canResend = false;
                    let countdown = 30;

                    const countdownInterval = setInterval(() => {
                        if (countdown > 0) {
                            resendButton.querySelector('.button-text').textContent = `Réessayer dans ${countdown}s`;
                            countdown--;
                        } else {
                            clearInterval(countdownInterval);
                            resendButton.classList.remove('loading');
                            resendButton.disabled = false;
                            resendButton.querySelector('.button-text').textContent = 'Renvoyer le lien';
                            canResend = true;
                        }
                    }, 1000);
                });
            }

            // Clear button state on page refresh
            window.addEventListener('beforeunload', function() {
                if (resendButton) {
                    resendButton.classList.remove('loading');
                    resendButton.disabled = false;
                }
            });
        });
    </script>
</body>
</html>
