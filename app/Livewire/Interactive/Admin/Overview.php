<?php

namespace App\Livewire\Interactive\Admin;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Overview extends Component
{
    use WithPagination;

    public int $totalParticipants = 0;
    public int $totalVotes = 0;
    public int $totalRevenueMinor = 0;
    public int $totalTicketsSold = 0;

    public string $search = '';
    public string $status = '';
    public ?string $from = null;
    public ?string $to = null;
    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'from' => ['except' => null],
        'to' => ['except' => null],
        'page' => ['except' => 1],
    ];

    public function updating($name, $value)
    {
        if (in_array($name, ['search','status','from','to','perPage'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $userId = Auth::id();

        // Base query (événements de l'organisateur)
        $base = Event::query()->where('organizer_id', $userId);

        // KPI globaux (sans filtres)
        $allEvents = (clone $base)->get(['id','total_revenue_minor','total_tickets_sold']);
        $eventIdsAll = $allEvents->pluck('id');
        $this->totalParticipants = (int) Participant::whereIn('event_id', $eventIdsAll)->count();
        $this->totalVotes = (int) Vote::whereIn('event_id', $eventIdsAll)->sum('value');
        $this->totalRevenueMinor = (int) ($allEvents->sum('total_revenue_minor') ?? 0);
        $this->totalTicketsSold = (int) ($allEvents->sum('total_tickets_sold') ?? 0);

        // Filtres pour la liste
        $eventsQ = (clone $base)
            ->when($this->search !== '', fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->status !== '', fn($q) => $q->where('status', $this->status))
            ->when($this->from, fn($q) => $q->whereDate('start_date', '>=', $this->from))
            ->when($this->to, fn($q) => $q->whereDate('end_date', '<=', $this->to))
            ->orderByDesc('start_date');

        $events = $eventsQ->paginate($this->perPage);

        // Compteurs de statut (dynamiques, sur tous les événements de l'organisateur)
        $statusCounts = (clone $base)
            ->selectRaw('COALESCE(status, "draft") as s, COUNT(*) as c')
            ->groupBy('s')
            ->pluck('c', 's');

        return view('livewire.interactive.admin.overview', [
            'events' => $events,
            'statusCounts' => $statusCounts,
        ]);
    }
}
