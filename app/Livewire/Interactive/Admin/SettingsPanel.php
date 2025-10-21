<?php

namespace App\Livewire\Interactive\Admin;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SettingsPanel extends Component
{
    use AuthorizesRequests;

    public int $premium_vote_cost = 10; // coins
    public int $coin_price_minor = 100; // 1 coin = 100 minor units (XOF)

    public function mount(): void
    {
        // L'accès est déjà limité par le middleware 'admin' dans les routes
        $this->premium_vote_cost = (int) (Setting::get('interactive.premium_vote_cost', 10) ?? 10);
        $this->coin_price_minor = (int) (Setting::get('interactive.coin_price_minor', 100) ?? 100);
    }

    public function save(): void
    {
        $data = $this->validate([
            'premium_vote_cost' => ['required','integer','min:1','max:100000'],
            'coin_price_minor' => ['required','integer','min:1','max:1000000'],
        ]);

        Setting::set('interactive.premium_vote_cost', (string) $data['premium_vote_cost']);
        Setting::set('interactive.coin_price_minor', (string) $data['coin_price_minor']);

        $this->dispatch('toast', type: 'success', message: 'Paramètres sauvegardés.');
    }

    public function render()
    {
        return view('livewire.interactive.admin.settings-panel');
    }
}
