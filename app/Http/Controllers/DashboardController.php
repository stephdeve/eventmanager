<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();
        
        // Rediriger en fonction du rôle de l'utilisateur
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isOrganizer()) {
            return $this->organizerDashboard($user);
        } elseif ($user->isStudent()) {
            return $this->studentDashboard($user);
        }

        // Par défaut, rediriger vers la page d'accueil
        return redirect()->route('home');
    }
    /**
     * Afficher le tableau de bord de l'organisateur.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\View\View
     */
    protected function organizerDashboard($user)
    {
        // Identifiants de tous les événements gérés par l'organisateur (évite de recalculer plusieurs fois la même requête)
        $organizedEventIds = $user->organizedEvents()->pluck('id');

        // Événements à venir organisés par l'utilisateur
        $upcomingEvents = $user->organizedEvents()
            ->upcoming()
            ->withCount('registrations')
            ->orderBy('start_date')
            ->take(5)
            ->get();
        
        // Événements passés avec statistiques
        $pastEvents = $user->organizedEvents()
            ->where('start_date', '<', now())
            ->withCount('registrations')
            ->orderBy('start_date', 'desc')
            ->take(5)
            ->get();
            
        // Dernières inscriptions à réutiliser dans plusieurs widgets
        $recentRegistrations = Registration::whereIn('event_id', $organizedEventIds)
            ->with(['event', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Statistiques globales (cartes de synthèse)
        $stats = [
            'total_events' => $user->organizedEvents()->count(),
            'upcoming_events' => $user->organizedEvents()->upcoming()->count(),
            'total_registrations' => $user->organizedEvents()->withCount('registrations')->get()->sum('registrations_count'),
            'recent_registrations' => $recentRegistrations,
        ];

        // Préparation du graphique « inscriptions sur 7 jours »
        $startOfPeriod = Carbon::now()->subDays(6)->startOfDay();
        $rawWeeklyRegistrations = Registration::select(DB::raw('DATE(created_at) as registration_day'), DB::raw('COUNT(*) as total'))
            ->whereIn('event_id', $organizedEventIds)
            ->where('created_at', '>=', $startOfPeriod)
            ->groupBy('registration_day')
            ->orderBy('registration_day')
            ->get()
            ->keyBy('registration_day');

        $weeklyLabels = [];
        $weeklySeries = [];
        for ($offset = 0; $offset < 7; $offset++) {
            $currentDay = $startOfPeriod->copy()->addDays($offset);
            $dateKey = $currentDay->toDateString();

            $weeklyLabels[] = $currentDay->translatedFormat('d M');
            $weeklySeries[] = (int) ($rawWeeklyRegistrations[$dateKey]->total ?? 0);
        }

        $weeklyToday = $weeklySeries[count($weeklySeries) - 1] ?? 0;
        $weeklyPrevious = $weeklySeries[count($weeklySeries) - 2] ?? 0;
        $weeklyGrowth = 0;
        if ($weeklyPrevious > 0) {
            $weeklyGrowth = (int) round((($weeklyToday - $weeklyPrevious) / $weeklyPrevious) * 100);
        } elseif ($weeklyToday > 0) {
            $weeklyGrowth = 100;
        }

        // Calcul des taux d'occupation (événements les plus remplis)
        $topOccupancyEvents = $user->organizedEvents()
            ->withCount('registrations')
            ->whereNotNull('capacity')
            ->where('capacity', '>', 0)
            ->orderBy('registrations_count', 'desc')
            ->take(4)
            ->get();

        $occupancySeries = [];
        $occupancyLabels = [];
        $occupancyBreakdown = [];
        foreach ($topOccupancyEvents as $event) {
            $capacity = max(1, (int) $event->capacity);
            $occupancy = (int) min(100, round(($event->registrations_count / $capacity) * 100));

            $occupancySeries[] = $occupancy;
            $occupancyLabels[] = $event->title;
            $occupancyBreakdown[] = [
                'event' => $event,
                'occupancy' => $occupancy,
            ];
        }

        // Alertes de capacité (événements proches de la saturation)
        $capacityAlerts = $user->organizedEvents()
            ->withCount('registrations')
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->get()
            ->map(function ($event) {
                if (is_null($event->capacity) || $event->capacity <= 0) {
                    return null;
                }

                $remaining = max(0, $event->capacity - $event->registrations_count);

                return $remaining <= 5 ? [
                    'event' => $event,
                    'remaining' => $remaining,
                ] : null;
            })
            ->filter()
            ->take(5)
            ->values();

        // Aperçu condensé des prochains événements (colonne latérale)
        $upcomingOverview = $user->organizedEvents()
            ->upcoming()
            ->withCount('registrations')
            ->orderBy('start_date')
            ->take(5)
            ->get()
            ->map(function ($event) {
                return [
                    'event' => $event,
                    'registrations' => $event->registrations_count,
                ];
            });

        // Structure envoyée à la vue pour les graphiques
        $charts = [
            'weekly_registrations' => [
                'labels' => $weeklyLabels,
                'series' => $weeklySeries,
                'growth_percentage' => $weeklyGrowth,
            ],
            'occupancy' => [
                'labels' => $occupancyLabels,
                'series' => $occupancySeries,
            ],
        ];

        // Structure envoyée à la vue pour les autres widgets
        $widgets = [
            'capacity_alerts' => $capacityAlerts,
            'occupancy_breakdown' => $occupancyBreakdown,
            'upcoming_overview' => $upcomingOverview,
        ];

        return view('dashboard.organizer', [
            'upcomingEvents' => $upcomingEvents,
            'pastEvents' => $pastEvents,
            'stats' => $stats,
            'charts' => $charts,
            'widgets' => $widgets,
        ]);
    }
    
    /**
     * Afficher le tableau de bord de l'étudiant.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\View\View
     */
    protected function studentDashboard($user)
    {
        // Prochains événements auxquels l'utilisateur est inscrit
        $upcomingRegistrations = $user->registrations()
            ->with(['event' => function($query) {
                $query->withCount('registrations')
                      ->select('*', \DB::raw('(capacity - (SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id)) as available_seats_calculated'));
            }])
            ->whereHas('event', function($query) {
                $query->where('start_date', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Événements passés auxquels l'utilisateur était inscrit
        $pastRegistrations = $user->registrations()
            ->with(['event' => function($query) {
                $query->withCount('registrations')
                      ->select('*', \DB::raw('(capacity - (SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id)) as available_seats_calculated'));
            }])
            ->whereHas('event', function($query) {
                $query->where('start_date', '<', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Événements recommandés (événements à venir non encore inscrits)
        $recommendedEvents = Event::select('events.*')
            ->selectRaw('(events.capacity - (SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id)) as available_seats_calculated')
            ->where('start_date', '>=', now())
            ->whereDoesntHave('registrations', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereRaw('(events.capacity - (SELECT COUNT(*) FROM registrations WHERE registrations.event_id = events.id)) > 0')
            ->orderBy('start_date')
            ->take(3)
            ->get();
            
        return view('dashboard.student', [
            'upcomingRegistrations' => $upcomingRegistrations,
            'pastRegistrations' => $pastRegistrations,
            'recommendedEvents' => $recommendedEvents,
        ]);
    }
}