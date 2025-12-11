<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Billet - {{ $registration->event->title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: #f8fafc;
            color: #1f2937;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 32px;
        }
        .card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 12px;
            letter-spacing: 0.08em;
        }
        .content {
            padding: 32px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }
        .section {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }
        .section h2 {
            margin: 0 0 16px;
            font-size: 18px;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 12px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
        .info-item span:first-child {
            color: #6b7280;
            font-weight: 500;
        }
        .qr-wrapper {
            text-align: center;
            padding: 16px;
            background: white;
            border-radius: 12px;
            border: 1px dashed #c7d2fe;
        }
        .qr-wrapper img {
            max-width: 220px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .footer {
            padding: 24px 32px;
            background: #f1f5f9;
            border-top: 1px solid #e2e8f0;
        }
        .instructions {
            font-size: 13px;
            color: #475569;
            list-style: none;
            padding-left: 0;
            margin: 0;
        }
        .instructions li {
            margin-bottom: 8px;
            padding-left: 16px;
            position: relative;
        }
        .instructions li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #6366f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div>
                    <span class="badge">BILLET ÉLECTRONIQUE</span>
                    <h1>{{ $registration->event->title }}</h1>
                    <p style="margin: 8px 0 0; font-size: 14px; color: rgba(255,255,255,0.85);">
                        Organisé par {{ $registration->event->organizer->name }}
                    </p>
                </div>
                <div style="text-align: right; font-size: 14px;">
                    <p style="margin: 0; opacity: 0.85;">Date d'inscription</p>
                    <p style="margin: 4px 0 0; font-weight: 600;">
                        {{ $registration->created_at->format('d/m/Y H:i') }}
                    </p>
                    <p style="margin: 4px 0 0; opacity: 0.85;">
                        Statut : <strong style="color: {{ $registration->is_validated ? '#bbf7d0' : '#fde68a' }};">
                            {{ $registration->is_validated ? 'Validé' : 'En attente' }}
                        </strong>
                    </p>
                </div>
            </div>

            <div class="content">
                <div class="section">
                    <h2>Informations sur l'événement</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <span>Date</span>
                            <span>
                                @if($registration->event->start_date)
                                    {{ $registration->event->start_date->translatedFormat('l d F Y \à H\hi') }}
                                @else
                                    Date à confirmer
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span>Lieu</span>
                            <span>{{ $registration->event->location }}</span>
                        </div>
                        <div class="info-item">
                            <span>Participant</span>
                            <span>{{ $registration->user->name }}</span>
                        </div>
                        <div class="info-item">
                            <span>Email</span>
                            <span>{{ $registration->user->email }}</span>
                        </div>
                        <div class="info-item">
                            <span>Tarif</span>
                            <span>
                                @isset($registration->event->price)
                                    @if($registration->event->price > 0)
                                        {{ number_format($registration->event->price, 0, ',', ' ') }} {{ strtoupper($registration->event->currency ?? 'FCFA') }}
                                    @else
                                        Gratuit
                                    @endif
                                @else
                                    Non communiqué
                                @endisset
                            </span>
                        </div>
                        <div class="info-item">
                            <span>Code billet</span>
                            <span>{{ $registration->qr_code_data }}</span>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <h2>QR Code</h2>
                    <div class="qr-wrapper">
                        @if(!empty($qrCodeDataUrl))
                            <img src="{{ $qrCodeDataUrl }}" alt="QR Code">
                        @else
                            <p style="font-size: 12px; color: #6b7280;">
                                QR code indisponible. Veuillez télécharger à nouveau votre billet ultérieurement.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="footer">
                <ul class="instructions">
                    <li>Présentez ce billet (papier ou version mobile) lors de votre arrivée à l'événement.</li>
                    <li>Le QR code doit être scanné pour valider votre présence.</li>
                    <li>Arrivez 15 minutes avant le début pour faciliter votre accueil.</li>
                    <li>Pour toute question, contactez l'organisateur à {{ $registration->event->organizer->email ?? 'contact@eventmanager.test' }}.</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
