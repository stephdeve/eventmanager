<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de ventes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h1 { font-size: 18px; margin-bottom: 10px; }
        h2 { font-size: 14px; margin: 16px 0 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; }
        th { background: #f3f4f6; text-align: left; }
        .muted { color: #6b7280; }
    </style>
</head>
<body>
    <h1>Rapport de ventes</h1>
    <p class="muted">Généré le {{ now()->format('d/m/Y H:i') }}</p>

    <h2>Résumé</h2>
    <table>
        <tr>
            <th>Total des ventes (minor)</th>
            <td>{{ $total_minor }}</td>
        </tr>
        <tr>
            <th>Nombre de tickets vendus</th>
            <td>{{ $tickets_sold }}</td>
        </tr>
    </table>

    <h2>Détails des transactions</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Événement</th>
                <th>Utilisateur</th>
                <th>Status</th>
                <th>Montant (minor)</th>
                <th>Devise</th>
                <th>Méthode</th>
                <th>Référence</th>
                <th>Payé le</th>
            </tr>
        </thead>
        <tbody>
        @foreach($payments as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ optional($p->event)->title }}</td>
                <td>{{ optional($p->user)->email }}</td>
                <td>{{ strtoupper($p->status) }}</td>
                <td>{{ (int) $p->amount_minor }}</td>
                <td>{{ $p->currency }}</td>
                <td>{{ $p->method }}</td>
                <td>{{ $p->provider_reference }}</td>
                <td>{{ optional($p->paid_at)?->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
