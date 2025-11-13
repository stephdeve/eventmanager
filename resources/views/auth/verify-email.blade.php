<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vérification de l'email - EventManager</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); width: 100%; max-width: 560px; overflow: hidden; }
        .card-header { background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%); color: #fff; padding: 2rem; text-align: center; position: relative; }
        .card-header h2 { font-size: 1.5rem; font-weight: 600; margin-bottom: .5rem; }
        .card-header p { opacity: .95; }
        .card-body { padding: 2rem; }
        .btn-primary { width: 100%; background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%); color: #fff; padding: .875rem 1.25rem; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all .2s ease; }
        .btn-secondary { width: 100%; background: linear-gradient(135deg, #d30505 0%, #ba0505 100%); color: #fff; padding: .875rem 1.25rem; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all .2s ease; }
        .btn-secondary:hover { filter: brightness(1.05); transform: translateY(-1px); }
        .btn-primary:hover { filter: brightness(1.05); transform: translateY(-1px); }
        .btn-link { color: #4F46E5; font-weight: 500; text-decoration: none; }
        .btn-row { display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: center; }
        .success-message { background:#F0FDF4; color:#166534; padding:.875rem; border-radius:10px; margin-bottom:1rem; font-size:.9rem; border:1.5px solid #BBF7D0; }
        .error-message { background:#FEF2F2; color:#991B1B; padding:.875rem; border-radius:10px; margin-bottom:1rem; font-size:.9rem; border:1.5px solid #FECACA; }
        .hint { color:#6B7280; font-size:.95rem; line-height:1.6; }
    </style>
</head>

<body>
<div class="card border">
    <div class="card-header">
        <h2>Vérification de l'email</h2>
        <p>Confirmez votre adresse pour sécuriser votre compte</p>
    </div>
    <div class="card-body">
        @if (session('status') == 'verification-link-sent')
            <div class="success-message">
                Un nouveau lien de vérification a été envoyé à votre adresse email.
            </div>
        @endif

        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <p class="hint">
            Merci de votre inscription ! Avant de commencer, veuillez confirmer votre adresse email en cliquant sur le lien
            que nous venons de vous envoyer. Si vous n'avez pas reçu l'email, vous pouvez en demander un nouveau ci-dessous.
        </p>

        <div style="height: 1rem"></div>

        <div class="btn-row">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary">Renvoyer l'email de vérification</button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary">Se déconnecter</button>
            </form>
        </div>

        <div style="margin-top:1rem" class="hint text-sm">
            Besoin d'aide ? Vérifiez vos spams ou contactez le support.
        </div>
    </div>
</div>

</body>
</html>
