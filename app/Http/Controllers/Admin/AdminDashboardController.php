<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        $roleStats = User::select('role', DB::raw('COUNT(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');

        $monthlyScopeStart = Carbon::now()->subMonths(5)->startOfMonth();

        $rawMonthlyRegistrations = Registration::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN is_validated = 1 THEN 1 ELSE 0 END) as validated_total')
            )
            ->where('created_at', '>=', $monthlyScopeStart)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $monthlyLabels = [];
        $monthlyTotalSeries = [];
        $monthlyValidatedSeries = [];

        for ($offset = 0; $offset <= 5; $offset++) {
            $current = $monthlyScopeStart->copy()->addMonths($offset);
            $key = $current->format('Y-m');

            $monthlyLabels[] = $current->translatedFormat('M Y');
            $monthlyTotalSeries[] = (int) ($rawMonthlyRegistrations[$key]->total ?? 0);
            $monthlyValidatedSeries[] = (int) ($rawMonthlyRegistrations[$key]->validated_total ?? 0);
        }

        $topParticipationEvents = Event::withCount('registrations')
            ->withCount(['registrations as validated_registrations_count' => function ($query) {
                $query->where('is_validated', true);
            }])
            ->orderByDesc('registrations_count')
            ->take(5)
            ->get();

        $participationLabels = $topParticipationEvents->pluck('title');
        $participationValidated = $topParticipationEvents->pluck('validated_registrations_count')->map(fn ($value) => (int) $value);
        $participationPending = $topParticipationEvents->map(function ($event) {
            return (int) max(0, $event->registrations_count - $event->validated_registrations_count);
        });

        $capacityEvents = Event::whereNotNull('capacity')
            ->where('capacity', '>', 0)
            ->withCount('registrations')
            ->orderByDesc('registrations_count')
            ->take(5)
            ->get();

        $capacityLabels = $capacityEvents->pluck('title');
        $capacityValues = $capacityEvents->map(fn ($event) => (int) $event->registrations_count);
        $capacityMax = $capacityEvents->map(fn ($event) => (int) $event->capacity);

        $topOrganizers = User::where('role', 'organizer')
            ->withCount('organizedEvents')
            ->orderByDesc('organized_events_count')
            ->take(5)
            ->get();

        $organizerLabels = $topOrganizers->pluck('name');
        $organizerSeries = $topOrganizers->pluck('organized_events_count')->map(fn ($value) => (int) $value);

        $chartData = [
            'roles' => [
                'labels' => $roleStats->keys()->map(fn ($role) => __("roles.$role") ?? ucfirst($role)),
                'series' => $roleStats->values()->map(fn ($value) => (int) $value),
            ],
            'monthly_registrations' => [
                'labels' => $monthlyLabels,
                'total' => $monthlyTotalSeries,
                'validated' => $monthlyValidatedSeries,
            ],
            'participation' => [
                'labels' => $participationLabels,
                'validated' => $participationValidated,
                'pending' => $participationPending,
            ],
            'capacity' => [
                'labels' => $capacityLabels,
                'registrations' => $capacityValues,
                'capacities' => $capacityMax,
            ],
            'organizers' => [
                'labels' => $organizerLabels,
                'series' => $organizerSeries,
            ],
        ];

        return view('admin.dashboard', [
            'charts' => $chartData,
            'metrics' => [
                'total_users' => User::count(),
                'total_events' => Event::count(),
                'total_registrations' => Registration::count(),
                'validated_registrations' => Registration::where('is_validated', true)->count(),
            ],
        ]);
    }
}
