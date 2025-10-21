<?php

namespace App\Livewire\Interactive\Admin;

use App\Models\Event;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class EventEditor extends Component
{
    use AuthorizesRequests;
    public Event $event;

    public string $title = '';
    public ?string $description = '';
    public ?string $start_date = null;
    public ?string $end_date = null;
    public ?string $status = 'draft';
    public ?string $youtube_url = null;
    public ?string $tiktok_url = null;
    public bool $is_interactive = false;
    public bool $interactive_public = false;
    public ?string $interactive_starts_at = null;
    public ?string $interactive_ends_at = null;

    public function mount(Event $event)
    {
        $this->authorize('update', $event);
        $this->event = $event;
        $this->title = (string) $event->title;
        $this->description = (string) ($event->description ?? '');
        $this->start_date = optional($event->start_date)->format('Y-m-d\TH:i');
        $this->end_date = optional($event->end_date)->format('Y-m-d\TH:i');
        $this->status = (string) ($event->status ?? 'draft');
        $this->youtube_url = $event->youtube_url;
        $this->tiktok_url = $event->tiktok_url;
        $this->is_interactive = (bool) $event->is_interactive;
        $this->interactive_public = (bool) $event->interactive_public;
        $this->interactive_starts_at = optional($event->interactive_starts_at)->format('Y-m-d\TH:i');
        $this->interactive_ends_at = optional($event->interactive_ends_at)->format('Y-m-d\TH:i');
    }

    public function save(): void
    {
        $data = $this->validate([
            'title' => ['required','string','min:3','max:200'],
            'description' => ['nullable','string'],
            'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date','after_or_equal:start_date'],
            'status' => ['required', Rule::in(['draft','published','running','finished'])],
            'youtube_url' => ['nullable','string','max:255'],
            'tiktok_url' => ['nullable','string','max:255'],
            'is_interactive' => ['boolean'],
            'interactive_public' => ['boolean'],
            'interactive_starts_at' => ['nullable','date'],
            'interactive_ends_at' => ['nullable','date','after_or_equal:interactive_starts_at'],
        ]);

        $this->event->fill([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ? Carbon::parse($data['start_date']) : null,
            'end_date' => $data['end_date'] ? Carbon::parse($data['end_date']) : null,
            'status' => $data['status'],
            'youtube_url' => $data['youtube_url'] ?? null,
            'tiktok_url' => $data['tiktok_url'] ?? null,
            'is_interactive' => (bool) ($data['is_interactive'] ?? false),
            'interactive_public' => (bool) ($data['interactive_public'] ?? false),
            'interactive_starts_at' => !empty($data['interactive_starts_at']) ? Carbon::parse($data['interactive_starts_at']) : null,
            'interactive_ends_at' => !empty($data['interactive_ends_at']) ? Carbon::parse($data['interactive_ends_at']) : null,
        ])->save();

        $this->dispatch('toast', type: 'success', message: 'Événement mis à jour.');
    }

    public function render()
    {
        return view('livewire.interactive.admin.event-editor');
    }
}
