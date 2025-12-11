<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPayment;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ParticipantHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isStudent()) {
                abort(403, 'Accès réservé aux participants');
            }
            return $next($request);
        });
    }

    /**
     * Afficher l'historique complet des participations
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Filtres
        $search = $request->query('search');
        $status = $request->query('status'); // all, upcoming, past, cancelled
        $paymentStatus = $request->query('payment'); // all, paid, unpaid, pending
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $sortBy = $request->query('sort_by', 'created_at');
        $sortOrder = $request->query('sort_order', 'desc');

        $query = $user->registrations()->with(['event' => function($q) {
            $q->select('*')
              ->withCount('registrations');
        }]);

        // Recherche
        if ($search) {
            $query->whereHas('event', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filtre par statut temporel
        if ($status && $status !== 'all') {
            switch ($status) {
                case 'upcoming':
                    $query->whereHas('event', function($q) {
                        $q->where('start_date', '>', now());
                    });
                    break;
                case 'past':
                    $query->whereHas('event', function($q) {
                        $q->where('start_date', '<', now());
                    });
                    break;
                case 'cancelled':
                    $query->where('payment_status', 'cancelled');
                    break;
            }
        }

        // Filtre par statut de paiement
        if ($paymentStatus && $paymentStatus !== 'all') {
            $query->where('payment_status', $paymentStatus);
        }

        // Filtre par plage de dates (inscription)
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Tri
        if ($sortBy === 'event_date') {
            $query->join('events', 'registrations.event_id', '=', 'events.id')
                  ->orderBy('events.start_date', $sortOrder)
                  ->select('registrations.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $participations = $query->paginate(15)->appends($request->query());

        // Statistiques personnelles
        $stats = $this->calculateParticipantStats($user);

        // Graphique participations par mois (12 derniers mois)
        $timelineData = $this->getParticipationsTimeline($user);

        return view('participant.history.index', [
            'participations' => $participations,
            'stats' => $stats,
            'timelineData' => $timelineData,
            'filters' => [
                'search' => $search,
                'status' => $status,
                'payment' => $paymentStatus,
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
    public function payments(Request $request)
    {
        $user = Auth::user();

        // Filtres
        $method = $request->query('method'); // all, kkiapay, cash, paypal
        $status = $request->query('status'); // all, success, pending, failed
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $query = EventPayment::where('user_id', $user->id)
            ->with(['event']);

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
            'total_spent' => EventPayment::where('user_id', $user->id)
                ->where('status', 'success')
                ->sum('amount_minor'),
            'total_transactions' => EventPayment::where('user_id', $user->id)
                ->where('status', 'success')
                ->count(),
            'by_method' => EventPayment::where('user_id', $user->id)
                ->where('status', 'success')
                ->select('provider', DB::raw('SUM(amount_minor) as total'), DB::raw('COUNT(*) as count'))
                ->groupBy('provider')
                ->get()
                ->keyBy('provider'),
        ];

        // Graphique dépenses mensuelles (12 derniers mois)
        $spendingChart = $this->getSpendingChart($user);

        return view('participant.history.payments', [
            'payments' => $payments,
            'paymentStats' => $paymentStats,
            'spendingChart' => $spendingChart,
            'filters' => [
                'method' => $method,
                'status' => $status,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ],
        ]);
    }

    /**
     * Télécharger un reçu de paiement
     */
    public function downloadReceipt(Registration $registration)
    {
        $this->authorize('view', $registration);

        // Récupérer le paiement associé
        $payment = EventPayment::where('registration_id', $registration->id)
            ->where('user_id', Auth::id())
            ->where('status', 'success')
            ->first();

        if (!$payment) {
            return back()->with('error', 'Aucun reçu disponible pour cette inscription.');
        }

        $pdf = Pdf::loadView('participant.history.receipt-pdf', [
            'registration' => $registration,
            'payment' => $payment,
        ]);

        return $pdf->download('recu-' . $registration->id . '-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Calculer les statistiques du participant
     */
    private function calculateParticipantStats($user)
    {
        $registrations = $user->registrations()->with('event')->get();
        $eventIds = $registrations->pluck('event_id');

        $totalSpent = EventPayment::where('user_id', $user->id)
            ->where('status', 'success')
            ->sum('amount_minor');

        // Catégories préférées (basé sur événements interactifs vs non)
        $interactiveCount = Event::whereIn('id', $eventIds)
            ->where('is_interactive', true)
            ->count();

        return [
            'total_participations' => $registrations->count(),
            'upcoming_events' => $registrations->filter(function($reg) {
                return $reg->event && $reg->event->start_date->isFuture();
            })->count(),
            'past_events' => $registrations->filter(function($reg) {
                return $reg->event && $reg->event->start_date->isPast();
            })->count(),
            'total_spent' => $totalSpent,
            'avg_per_event' => $registrations->count() > 0 
                ? round($totalSpent / $registrations->count())
                : 0,
            'interactive_events' => $interactiveCount,
            'regular_events' => $registrations->count() - $interactiveCount,
        ];
    }

    /**
     * Obtenir la timeline des participations (par mois)
     */
    private function getParticipationsTimeline($user)
    {
        $start = now()->subMonths(11)->startOfMonth();

        $rawData = $user->registrations()
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
     * Obtenir le graphique des dépenses mensuelles
     */
    private function getSpendingChart($user)
    {
        $start = now()->subMonths(11)->startOfMonth();

        $rawData = EventPayment::where('user_id', $user->id)
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
}
