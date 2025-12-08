<?php

namespace App\Livewire\Interactive\Admin;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ParticipantsManager extends Component
{
    use AuthorizesRequests;

    public Event $event;

    public string $name = '';
    public ?string $country = null;
    public ?string $photo_path = null;
    public ?string $bio = null;
    public ?string $video_url = null;

    public ?int $editingId = null;

    public function mount(Event $event): void
    {
        $this->authorize('update', $event);
        $this->event = $event->load('participants');
    }

    public function save(): void
    {
        try {
            $data = $this->validate([
                'name' => ['required','string','min:2','max:150'],
                'country' => ['nullable','string','max:100'],
                'photo_path' => ['nullable','string','max:255'],
                'bio' => ['nullable','string'],
                'video_url' => ['nullable','string','max:255'],
            ]);

            if ($this->editingId) {
                $p = Participant::where('event_id', $this->event->id)->findOrFail($this->editingId);
                $p->update($data);
            } else {
                $this->event->participants()->create($data + ['event_id' => $this->event->id]);
            }

            $this->resetForm();
            $this->event->refresh();
            $this->dispatch('toast', type: 'success', message: 'Participant enregistré.');
        } catch (\Throwable $e) {
            report($e);
            $this->dispatch('toast', type: 'error', message: 'Échec de l\'enregistrement du participant: ' . $e->getMessage());
        }
    }

    public function edit(int $id): void
    {
        $p = Participant::where('event_id', $this->event->id)->findOrFail($id);
        $this->editingId = $p->id;
        $this->name = $p->name;
        $this->country = $p->country;
        $this->photo_path = $p->photo_path;
        $this->bio = $p->bio;
        $this->video_url = $p->video_url;
    }

    public function delete(int $id): void
    {
        Participant::where('event_id', $this->event->id)->findOrFail($id)->delete();
        $this->event->refresh();
        $this->dispatch('toast', type: 'success', message: 'Participant supprimé.');
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->country = null;
        $this->photo_path = null;
        $this->bio = null;
        $this->video_url = null;
    }

    public function render()
    {
        return view('livewire.interactive.admin.participants-manager');
    }
}
