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

        return view('promo.show', [
            'event' => $event,
            'ref' => $ref,
        ]);
    }
}
