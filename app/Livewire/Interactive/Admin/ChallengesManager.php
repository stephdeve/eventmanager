<?php

namespace App\Livewire\Interactive\Admin;

use App\Models\Challenge;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ChallengesManager extends Component
{
    use AuthorizesRequests;

    public Event $event;

    public string $title = '';
    public ?string $description = null;
    public ?string $date = null; // Y-m-dTH:i
    public ?string $type = null;
    public int $max_points = 0;

    public ?string $editingId = null;

    public function mount(Event $event): void
    {
        $this->authorize('update', $event);
        $this->event = $event->load('challenges');
    }

    public function save(): void
    {
        try {
            $data = $this->validate([
                'title' => ['required','string','min:2','max:200'],
                'description' => ['nullable','string'],
                'date' => ['nullable','date'],
                'type' => ['nullable','string','max:100'],
                'max_points' => ['required','integer','min:0','max:100000'],
            ]);

            $payload = [
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'date' => $data['date'] ? now()->parse($data['date']) : null,
                'type' => $data['type'] ?? null,
                'max_points' => (int) $data['max_points'],
            ];

            if ($this->editingId) {
                $c = Challenge::where('event_id', $this->event->id)->findOrFail($this->editingId);
                $c->update($payload);
            } else {
                $this->event->challenges()->create($payload + ['event_id' => $this->event->id]);
            }

            $this->resetForm();
            $this->event->refresh();
            $this->dispatch('toast', type: 'success', message: 'Défi enregistré.');
        } catch (\Throwable $e) {
            report($e);
            $this->dispatch('toast', type: 'error', message: 'Échec de l\'enregistrement du défi: ' . $e->getMessage());
        }
    }

    public function edit(string $id): void
    {
        $c = Challenge::where('event_id', $this->event->id)->findOrFail($id);
        $this->editingId = $c->id;
        $this->title = $c->title;
        $this->description = $c->description;
        $this->date = optional($c->date)->format('Y-m-d\TH:i');
        $this->type = $c->type;
        $this->max_points = (int) $c->max_points;
    }

    public function delete(string $id): void
    {
        Challenge::where('event_id', $this->event->id)->findOrFail($id)->delete();
        $this->event->refresh();
        $this->dispatch('toast', type: 'success', message: 'Défi supprimé.');
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->title = '';
        $this->description = null;
        $this->date = null;
        $this->type = null;
        $this->max_points = 0;
    }

    public function render()
    {
        return view('livewire.interactive.admin.challenges-manager');
    }
}
