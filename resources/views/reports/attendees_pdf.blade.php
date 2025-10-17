<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Participants - {{ $event->title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin-bottom: 8px; }
        h2 { font-size: 14px; margin: 0 0 12px 0; color: #374151; }
        .muted { color: #6b7280; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 10px; border: 1px solid #e5e7eb; }
        th { background: #f3f4f6; text-align: left; font-weight: 600; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 9999px; font-size: 11px; }
        .badge-paid { background: #d1fae5; color: #065f46; }
        .badge-unpaid { background: #fef3c7; color: #92400e; }
        .badge-pending { background: #ffedd5; color: #9a3412; }
        .badge-failed { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 12px; font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
    <h1>Participants</h1>
    <h2>{{ $event->title }}</h2>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Inscrit le</th>
                <th>Statut paiement</th>
                <th>Méthode</th>
                <th>Validé</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $r)
                @php
                    $method = $r->payment_metadata['mode'] ?? null;
                    if ($method === 'kkiapay') { $method = 'numeric'; }
                    $ps = $r->payment_status;
                @endphp
                <tr>
                    <td>{{ optional($r->user)->name }}</td>
                    <td>{{ optional($r->user)->email }}</td>
                    <td>{{ optional($r->created_at)?->toDateTimeString() }}</td>
                    <td>
                        <span class="badge {{ $ps==='paid' ? 'badge-paid' : ($ps==='unpaid' ? 'badge-unpaid' : ($ps==='pending' ? 'badge-pending' : 'badge-failed')) }}">
                            {{ $ps }}
                        </span>
                    </td>
                    <td>{{ $method }}</td>
                    <td>{{ $r->is_validated ? 'oui' : 'non' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Export généré le {{ now()->toDateTimeString() }}.
    </div>
</body>
</html>
