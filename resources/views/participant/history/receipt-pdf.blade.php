<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reçu - {{ $registration->event->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { background: #3b82f6; color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .info-box { background: #f5f5f5; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e0e0e0; }
        .label { font-weight: bold; color: #666; }
        .value { text-align: right; }
        .total { font-size: 24px; font-weight: bold; color: #3b82f6; margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REÇU DE PAIEMENT</h1>
        <p>N° {{ $payment->transaction_id }}</p>
    </div>
    
    <div class="content">
        <h2>Détails de la transaction</h2>
        <div class="info-box">
            <div class="info-row">
                <span class="label">Date:</span>
                <span class="value">{{ optional($payment->paid_at ?: $payment->created_at)->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Méthode:</span>
                <span class="value">{{ ucfirst($payment->provider) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Statut:</span>
                <span class="value">{{ ucfirst($payment->status) }}</span>
            </div>
        </div>

        <h2>Événement</h2>
        <div class="info-box">
            <div class="info-row">
                <span class="label">Titre:</span>
                <span class="value">{{ $registration->event->title }}</span>
            </div>
            <div class="info-row">
                <span class="label">Date:</span>
                <span class="value">{{ optional($registration->event->start_date)->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Lieu:</span>
                <span class="value">{{ $registration->event->location }}</span>
            </div>
        </div>

        <h2>Participant</h2>
        <div class="info-box">
            <div class="info-row">
                <span class="label">Nom:</span>
                <span class="value">{{ $registration->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email:</span>
                <span class="value">{{ $registration->user->email }}</span>
            </div>
        </div>

        <div class="total">
            Montant payé: {{ \App\Support\Currency::format($payment->amount_minor, $payment->currency ?? 'XOF') }}
        </div>

        <p style="margin-top: 60px; color: #999; font-size: 12px; text-align: center;">
            Ce reçu a été généré automatiquement le {{ now()->format('d/m/Y à H:i') }}<br>
            Pour toute question, veuillez contacter l'organisateur de l'événement.
        </p>
    </div>
</body>
</html>
