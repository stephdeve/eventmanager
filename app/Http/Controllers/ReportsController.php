<?php

namespace App\Http\Controllers;

use App\Models\EventPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Export organizer sales (all events) as CSV.
     */
    public function exportSalesCsv(Request $request): StreamedResponse
    {
        $user = Auth::user();
        $eventIds = $user->organizedEvents()->pluck('id');

        $payments = EventPayment::whereIn('event_id', $eventIds)
            ->with(['event', 'user'])
            ->orderByDesc('paid_at')
            ->orderByDesc('created_at')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="sales_report.csv"',
        ];

        return response()->streamDownload(function () use ($payments) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, [
                'Payment ID', 'Event', 'User', 'Email', 'Status', 'Amount (minor)', 'Currency', 'Method', 'Provider', 'Provider Ref', 'Paid At', 'Created At'
            ]);
            foreach ($payments as $p) {
                fputcsv($out, [
                    $p->id,
                    optional($p->event)->title,
                    optional($p->user)->name,
                    optional($p->user)->email,
                    $p->status,
                    (int) $p->amount_minor,
                    $p->currency,
                    $p->method,
                    $p->provider,
                    $p->provider_reference,
                    optional($p->paid_at)?->toDateTimeString(),
                    optional($p->created_at)?->toDateTimeString(),
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }

    /**
     * Export organizer sales (all events) as PDF.
     */
    public function exportSalesPdf(Request $request)
    {
        $user = Auth::user();
        $eventIds = $user->organizedEvents()->pluck('id');

        $payments = EventPayment::whereIn('event_id', $eventIds)
            ->where('status', 'success')
            ->with(['event', 'user'])
            ->orderByDesc('paid_at')
            ->orderByDesc('created_at')
            ->get();

        $totalMinor = (int) $payments->sum('amount_minor');
        $ticketsSold = (int) $payments->count();

        $pdf = Pdf::loadView('reports.sales_pdf', [
            'payments' => $payments,
            'total_minor' => $totalMinor,
            'tickets_sold' => $ticketsSold,
        ]);

        return $pdf->download('sales_report.pdf');
    }
}
