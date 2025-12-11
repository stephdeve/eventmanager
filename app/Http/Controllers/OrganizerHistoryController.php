<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPayment;
use App\Models\Registration;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrganizerHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isOrganizer()) {
                abort(403, 'Accès réservé aux organisateurs');
            }
            return $next($request);
        });
    }

    /**
     * Afficher l'historique complet des événements de l'organisateur
     */
    public function eventsHistory(Request $request)
    {
        $user = Auth::user();
        
        // Récupérer les paramètres de filtrage
        $search = $request->query('search');
        $status = $request->query('status'); // all, upcoming, ongoing, past
        $type = $request->query('type'); // all, paid, free, interactive
        $capacity = $request->query('capacity'); // all, available, full
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $sortBy = $request->query('sort_by', 'start_date'); // start_date, participants, revenue, title
        $sortOrder = $request->query('sort_order', 'desc');
        
        // Query de base
        $query = $user->organizedEvents()
            ->withCount('registrations')
            ->withSum('registrations', 'quantity');

        // Filtres de recherche
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filtre par statut temporel
        if ($status && $status !== 'all') {
            switch ($status) {
                case 'upcoming':
                    $query->where('start_date', '>', now());
                    break;
                case 'ongoing':
                    $query->where('start_date', '<=', now())
                          ->where(function($q) {
                              $q->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                          });
                    break;
                case 'past':
                    $query->where(function($q) {
                        $q->where('start_date', '<', now())
                          ->where(function($subQ) {
                              $subQ->whereNotNull('end_date')
                                   ->where('end_date', '<', now());
                          })
                          ->orWhere(DB::raw('DATE_ADD(start_date, INTERVAL 1 DAY)'), '<', now());
                    });
                    break;
            }
        }

        // Filtre par type
        if ($type && $type !== 'all') {
            switch ($type) {
                case 'paid':
                    $query->where('price', '>', 0);
                    break;
                case 'free':
                    $query->where(function($q) {
                        $q->where('price', 0)->orWhereNull('price');
                    });
                    break;
                case 'interactive':
                    $query->where('is_interactive', true);
                    break;
            }
        }

        // Filtre par capacité
        if ($capacity && $capacity !== 'all') {
            if ($capacity === 'full') {
                $query->whereNotNull('capacity')
                      ->whereRaw('(SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id) >= capacity');
            } elseif ($capacity === 'available') {
                $query->whereNotNull('capacity')
                      ->whereRaw('(SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id) < capacity');
            }
        }

        // Filtre par plage de dates
        if ($dateFrom) {
            $query->where('start_date', '>=', Carbon::parse($dateFrom));
        }
        if ($dateTo) {
            $query->where('start_date', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        // Tri
        switch ($sortBy) {
            case 'participants':
                $query->orderBy('registrations_count', $sortOrder);
                break;
            case 'revenue':
                $query->orderBy('total_revenue_minor', $sortOrder);
                break;
            case 'title':
                $query->orderBy('title', $sortOrder);
                break;
            default:
                $query->orderBy('start_date', $sortOrder);
        }

        // Pagination
        $events = $query->paginate(15)->appends($request->query());

        // Statistiques globales pour l'historique
        $stats = $this->calculateHistoryStats($user);

        // Graphique timeline (événements créés par mois sur 12 derniers mois)
        $timelineData = $this->getEventsTimeline($user);

        return view('organizer.history.events', [
            'events' => $events,
            'stats' => $stats,
            'timelineData' => $timelineData,
            'filters' => [
                'search' => $search,
                'status' => $status,
                'type' => $type,
                'capacity' => $capacity,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
            ],
        ]);
    }

    /**
     * Afficher l'historique des paiements
     */
    public function paymentsHistory(Request $request)
    {
        $user = Auth::user();
        $organizedEventIds = $user->organizedEvents()->pluck('id');

        // Filtres
        $method = $request->query('method'); // all, kkiapay, cash, paypal
        $status = $request->query('status'); // all, success, pending, failed
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $query = EventPayment::whereIn('event_id', $organizedEventIds)
            ->with(['event', 'user']);

        // Appliquer filtres
        if ($method && $method !== 'all') {
            $query->where('provider', $method);
        }
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        if ($dateFrom) {
            $query->whereDate(DB::raw('COALESCE(paid_at, created_at)'), '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate(DB::raw('COALESCE(paid_at, created_at)'), '<=', $dateTo);
        }

        $payments = $query->orderByDesc(DB::raw('COALESCE(paid_at, created_at)'))
            ->paginate(20)
            ->appends($request->query());

        // Stats paiements
        $paymentStats = [
            'total_amount' => EventPayment::whereIn('event_id', $organizedEventIds)
                ->where('status', 'success')
                ->sum('amount_minor'),
            'total_transactions' => EventPayment::whereIn('event_id', $organizedEventIds)
                ->where('status', 'success')
                ->count(),
            'by_method' => EventPayment::whereIn('event_id', $organizedEventIds)
                ->where('status', 'success')
                ->select('provider', DB::raw('SUM(amount_minor) as total'), DB::raw('COUNT(*) as count'))
                ->groupBy('provider')
                ->get()
                ->keyBy('provider'),
        ];

        // Graphique revenus mensuels (12 derniers mois)
        $revenueChart = $this->getRevenueChart($organizedEventIds);

        return view('organizer.history.payments', [
            'payments' => $payments,
            'paymentStats' => $paymentStats,
            'revenueChart' => $revenueChart,
            'filters' => [
                'method' => $method,
                'status' => $status,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ],
        ]);
    }

    /**
     * Exporter les données d'un événement spécifique
     */
    public function exportEventData(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $format = $request->query('format', 'csv'); // csv, pdf

        if ($format === 'pdf') {
            return $this->exportEventPdf($event);
        }

        return $this->exportEventCsv($event);
    }

    /**
     * Exporter tous les événements en CSV
     */
    public function exportAllEvents()
    {
        $user = Auth::user();
        $events = $user->organizedEvents()
            ->withCount('registrations')
            ->orderBy('start_date', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="mes-evenements-' . now()->format('Y-m-d') . '.csv"',
        ];

        return response()->streamDownload(function () use ($events) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM

            // En-têtes
            fputcsv($out, [
                'Titre',
                'Date',
                'Lieu',
                'Capacité',
                'Participants',
                'Prix',
                'Revenus',
                'Statut',
                'Type',
            ]);

            foreach ($events as $event) {
                $status = $event->start_date->isFuture() ? 'À venir' : ($event->start_date->isToday() ? 'En cours' : 'Passé');
                $type = [];
                if ($event->price > 0) $type[] = 'Payant';
                if ($event->is_interactive) $type[] = 'Interactif';
                if (empty($type)) $type[] = 'Gratuit';

                fputcsv($out, [
                    $event->title,
                    optional($event->start_date)->format('d/m/Y H:i'),
                    $event->location,
                    $event->capacity ?? 'Illimitée',
                    $event->registrations_count ?? 0,
                    $event->price ? number_format($event->price, 0, ',', ' ') . ' ' . ($event->currency ?? 'XOF') : 'Gratuit',
                    $event->total_revenue_minor ? \App\Support\Currency::format($event->total_revenue_minor, $event->currency ?? 'XOF') : '0',
                    $status,
                    implode(', ', $type),
                ]);
            }

            fclose($out);
        }, 200, $headers);
    }

    /**
     * Calculer les statistiques de l'historique
     */
    private function calculateHistoryStats($user)
    {
        $events = $user->organizedEvents;
        $organizedEventIds = $events->pluck('id');

        return [
            'total_events' => $events->count(),
            'total_participants' => Registration::whereIn('event_id', $organizedEventIds)->count(),
            'total_revenue' => Event::whereIn('id', $organizedEventIds)->sum('total_revenue_minor'),
            'avg_attendance' => $events->count() > 0 
                ? round(Registration::whereIn('event_id', $organizedEventIds)->count() / $events->count())
                : 0,
            'bestseller' => $user->organizedEvents()
                ->withCount('registrations')
                ->orderBy('registrations_count', 'desc')
                ->first(),
        ];
    }

    /**
     * Obtenir la timeline des événements (par mois)
     */
    private function getEventsTimeline($user)
    {
        $start = now()->subMonths(11)->startOfMonth();
        
        $rawData = $user->organizedEvents()
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $start)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $data = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $start->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $labels[] = $month->translatedFormat('M Y');
            $data[] = $rawData->get($key)->count ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Obtenir le graphique des revenus mensuels
     */
    private function getRevenueChart($eventIds)
    {
        $start = now()->subMonths(11)->startOfMonth();

        $rawData = EventPayment::whereIn('event_id', $eventIds)
            ->where('status', 'success')
            ->select(
                DB::raw('DATE_FORMAT(COALESCE(paid_at, created_at), "%Y-%m") as month'),
                DB::raw('SUM(amount_minor) as total')
            )
            ->where(DB::raw('COALESCE(paid_at, created_at)'), '>=', $start)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $data = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $start->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $labels[] = $month->translatedFormat('M Y');
            $data[] = $rawData->get($key)->total ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Exporter un événement en CSV
     */
    private function exportEventCsv(Event $event)
    {
        $registrations = $event->registrations()->with('user')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="event-' . $event->slug . '-' . now()->format('Y-m-d') . '.csv"',
        ];

        return response()->streamDownload(function () use ($event, $registrations) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, ['Événement', $event->title]);
            fputcsv($out, ['Date', optional($event->start_date)->format('d/m/Y H:i')]);
            fputcsv($out, ['Lieu', $event->location]);
            fputcsv($out, []);

            fputcsv($out, ['Nom', 'Email', 'Inscrit le', 'Statut paiement', 'Validé']);

            foreach ($registrations as $reg) {
                fputcsv($out, [
                    optional($reg->user)->name,
                    optional($reg->user)->email,
                    optional($reg->created_at)->format('d/m/Y H:i'),
                    $reg->payment_status,
                    $reg->is_validated ? 'Oui' : 'Non',
                ]);
            }

            fclose($out);
        }, 200, $headers);
    }

    /**
     * Exporter un événement en PDF
     */
    private function exportEventPdf(Event $event)
    {
        $registrations = $event->registrations()->with('user')->get();

        $pdf = Pdf::loadView('organizer.history.event-pdf', [
            'event' => $event,
            'registrations' => $registrations,
        ]);

        return $pdf->download('event-' . $event->slug . '-' . now()->format('Y-m-d') . '.pdf');
    }
}
