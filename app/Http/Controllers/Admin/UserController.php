<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();

        $roleStats = User::select('role', DB::raw('COUNT(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');

        $signupsScopeStart = Carbon::now()->subMonths(5)->startOfMonth();

        $rawMonthlySignups = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $signupsScopeStart)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $monthlyLabels = [];
        $monthlySeries = [];

        for ($offset = 0; $offset <= 5; $offset++) {
            $current = $signupsScopeStart->copy()->addMonths($offset);
            $key = $current->format('Y-m');

            $monthlyLabels[] = $current->translatedFormat('M Y');
            $monthlySeries[] = (int) ($rawMonthlySignups[$key]->total ?? 0);
        }

        return view('admin.users.index', [
            'users' => $users,
            'charts' => [
                'roles' => [
                    'labels' => $roleStats->keys()->map(fn ($role) => __("roles.$role") ?? ucfirst($role)),
                    'series' => $roleStats->values()->map(fn ($value) => (int) $value),
                ],
                'signups' => [
                    'labels' => $monthlyLabels,
                    'series' => $monthlySeries,
                ],
            ],
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        
        $roles = [
            'student' => 'Étudiant',
            'organizer' => 'Organisateur',
            'admin' => 'Administrateur'
        ];
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user's role.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        $validated = $request->validate([
            'role' => 'required|in:student,organizer,admin',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
                         ->with('success', 'Rôle utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Export the users list as a CSV file.
     */
    public function export(): StreamedResponse
    {
        $this->authorize('viewAny', User::class);

        $fileName = 'users-' . now()->format('Ymd_His') . '.csv';

        $callback = function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Nom', 'Email', 'Rôle', 'Créé le']);

            User::orderBy('id')->chunk(200, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->role,
                        optional($user->created_at)->format('Y-m-d H:i'),
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
