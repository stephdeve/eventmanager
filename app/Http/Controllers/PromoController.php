<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        // Compter un clic promo
        $event->increment('promo_clicks');

        // Conserver le paramètre ref pour l'entonnoir
        $ref = $request->query('ref');

        // Recommandations simples: mêmes catégorie et à venir, exclure l'événement courant
        $recommended = Event::query()
            ->where('id', '!=', $event->id)
            ->when($event->category, fn($q) => $q->where('category', $event->category))
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(6)
            ->get();

        return view('promo.show', [
            'event' => $event,
            'ref' => $ref,
            'recommendedEvents' => $recommended,
        ]);
    }
}
