<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Événement - {{ $event->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { background: #7c3aed; color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .stats { display: table; width: 100%; margin: 20px 0; }
        .stat-box { display: table-cell; padding: 15px; border: 1px solid #e0e0e0; text-align: center; }
        .stat-label { font-size: 12px; color: #666; }
        .stat-value { font-size: 24px; font-weight: bold; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background: #f5f5f5; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $event->title }}</h1>
        <p>{{ optional($event->start_date)->format('d/m/Y à H:i') }} - {{ $event->location }}</p>
    </div>
    
    <div class="content">
        <h2>Statistiques</h2>
        <div class="stats">
            <div class="stat-box">
                <div class="stat-label">Participants</div>
                <div class="stat-value">{{ $registrations->count() }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Revenus</div>
                <div class="stat-value">{{ \App\Support\Currency::format($event->total_revenue_minor ?? 0, $event->currency ?? 'XOF') }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Capacité</div>
                <div class="stat-value">{{ $event->capacity ?? 'Illimitée' }}</div>
            </div>
        </div>

        <h2>Liste des participants</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Inscrit le</th>
                    <th>Statut paiement</th>
                    <th>Validé</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $reg)
                <tr>
                    <td>{{ optional($reg->user)->name }}</td>
                    <td>{{ optional($reg->user)->email }}</td>
                    <td>{{ optional($reg->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ ucfirst($reg->payment_status) }}</td>
                    <td>{{ $reg->is_validated ? 'Oui' : 'Non' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 40px; color: #999; font-size:12px;">
            Document généré le {{ now()->format('d/m/Y à H:i') }}
        </p>
    </div>
</body>
</html>
