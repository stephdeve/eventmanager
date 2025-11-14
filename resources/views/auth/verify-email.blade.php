<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vérification de l'email - EventManager</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            overflow: hidden;

        }

        .card-header {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: #fff;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
        }

        .card-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .card-header p {
            opacity: .95;
            font-size: 1rem;
        }

        .card-body {
            padding: 2.5rem 2rem;
        }

        .verification-icon {
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

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: #fff;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.35);
        }

        .btn-link {
            color: #4F46E5;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .btn-link:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
            transform: translateY(-1px);
        }

        .btn-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .success-message {
            background: #f0fdf4;
            color: #166534;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: .9rem;
            border: 1.5px solid #bbf7d0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .error-message {
            background: #fef2f2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: .9rem;
            border: 1.5px solid #fecaca;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .hint {
            color: #6b7280;
            font-size: 1rem;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .help-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
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

        .footer-text {
            text-align: center;
            color: #9ca3af;
            font-size: 0.875rem;
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        /* Animation pour le bouton */
        @keyframes sendAnimation {
            0% { transform: translateX(0); }
            50% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }

        .sending i {
            animation: sendAnimation 0.6s ease;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card {
                max-width: 100%;
            }

            .card-body {
                padding: 2rem 1.5rem;
            }

            .card-header {
                padding: 2rem 1.5rem;
            }

            .btn-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="card border">
    <div class="card-header">
        <h2>
            <i class="fas fa-shield-check"></i>
            Vérification de l'email
        </h2>
        <p>Confirmez votre adresse pour sécuriser votre compte</p>
    </div>
    <div class="card-body">
        <!-- Icône de vérification -->
        <div class="verification-icon">
            <div class="icon-container">
                <i class="fas fa-envelope-open-text"></i>
            </div>
        </div>

        <!-- Messages de statut -->
        @if (session('status') == 'verification-link-sent')
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                Un nouveau lien de vérification a été envoyé à votre adresse email.
            </div>
        @endif

        @if (session('error'))
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Texte explicatif -->
        <p class="hint">
            Merci de votre inscription ! Avant de commencer, veuillez confirmer votre adresse email en cliquant sur le lien
            que nous venons de vous envoyer. Si vous n'avez pas reçu l'email, vous pouvez en demander un nouveau ci-dessous.
        </p>

        <!-- Boutons d'action -->
        <div class="btn-row">
            <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                @csrf
                <button type="submit" class="btn-primary" id="resendButton">
                    <i class="fas fa-paper-plane"></i>
                    Renvoyer le lien
                </button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Se déconnecter
                </button>
            </form>
        </div>

        <!-- Section d'aide -->
        <div class="help-section">
            <div class="help-title">
                <i class="fas fa-question-circle"></i>
                Besoin d'aide ?
            </div>
            <div class="help-tips">
                <div class="tip">
                    <i class="fas fa-search"></i>
                    Vérifiez vos spams ou courriers indésirables
                </div>
                <div class="tip">
                    <i class="fas fa-clock"></i>
                    L'email peut prendre quelques minutes à arriver
                </div>
                <div class="tip">
                    <i class="fas fa-envelope"></i>
                    Assurez-vous d'avoir saisi la bonne adresse email
                </div>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer-text">
            <i class="fas fa-life-ring"></i>
            Contactez le support si vous rencontrez des problèmes
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resendButton = document.getElementById('resendButton');
        const resendForm = document.getElementById('resendForm');

        // Animation lors du clic
        resendForm.addEventListener('submit', function(e) {
            const icon = resendButton.querySelector('i');
            resendButton.classList.add('sending');

            setTimeout(() => {
                resendButton.classList.remove('sending');
            }, 600);
        });

        // Empêcher le spam avec un délai
        let canResend = true;

        resendForm.addEventListener('submit', function(e) {
            if (!canResend) {
                e.preventDefault();
                return;
            }

            canResend = false;
            resendButton.disabled = true;
            const originalText = resendButton.innerHTML;

            // Compte à rebours de 30 secondes
            let countdown = 30;
            const countdownInterval = setInterval(() => {
                if (countdown > 0) {
                    resendButton.innerHTML = `<i class="fas fa-clock"></i> Réessayer dans ${countdown}s`;
                    countdown--;
                } else {
                    clearInterval(countdownInterval);
                    resendButton.innerHTML = originalText;
                    resendButton.disabled = false;
                    canResend = true;
                }
            }, 1000);
        });
    });
</script>
</body>
</html>
