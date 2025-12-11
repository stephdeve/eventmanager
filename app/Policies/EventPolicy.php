<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Tous les utilisateurs peuvent voir la liste des événements
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Event $event): bool
    {
        // Tous les utilisateurs peuvent voir un événement
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Seuls les organisateurs avec abonnement actif (ou admins) peuvent créer des événements
        return $user->isAdmin() || ($user->isOrganizer() && $user->hasActiveSubscription());
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        // Organisateur avec abonnement actif, ou admin
        if ($user->isAdmin()) {
            return true;
        }
        return $user->is($event->organizer) && $user->hasActiveSubscription();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        // Organisateur avec abonnement actif, ou admin
        if ($user->isAdmin()) {
            return true;
        }
        return $user->is($event->organizer) && $user->hasActiveSubscription();
    }

    /**
     * Determine whether the user can register for the event.
     */
    public function register(User $user, Event $event): bool
    {
        // Un utilisateur ne peut s'inscrire que s'il est étudiant
        // et qu'il n'est pas déjà inscrit
        // et qu'il reste des places disponibles
        // et que la date de l'événement est dans le futur
        $eventDate = $event->start_date ?? $event->event_date;

        // Use direct query instead of collection to avoid UUID comparison issues
        $alreadyRegistered = \App\Models\Registration::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->exists();

        return $user->isStudent()
            && !$alreadyRegistered
            && $event->hasAvailableSeats()
            && $eventDate instanceof \Carbon\Carbon
            && $eventDate->isFuture();
    }

    /**
     * Determine whether the user can view the event's attendees.
     */
    public function viewAttendees(User $user, Event $event): bool
    {
        // Seul l'organisateur avec abonnement actif, ou admin
        if ($user->isAdmin()) {
            return true;
        }
        return $user->is($event->organizer) && $user->hasActiveSubscription();
    }
}
