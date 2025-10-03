<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class RegistrationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Seul un utilisateur connecté peut voir ses propres inscriptions
        return $user->isStudent();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Registration $registration): bool
    {
        // L'utilisateur peut voir son propre billet
        // ou l'organisateur de l'événement peut voir les inscriptions
        return $user->is($registration->user) || 
               $user->is($registration->event->organizer);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // La création se fait via la méthode register du EventController
        // Cette méthode n'est pas utilisée directement
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Registration $registration): bool
    {
        // Les mises à jour sont gérées par des méthodes spécifiques
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Registration $registration): bool
    {
        // L'utilisateur peut annuler sa propre inscription
        // ou l'organisateur peut supprimer une inscription
        return $user->is($registration->user) || 
               $user->is($registration->event->organizer);
    }

    /**
     * Determine whether the user can validate a registration.
     */
    public function validate(User $user, Registration $registration): bool
    {
        // Seul l'organisateur de l'événement ou un administrateur peut valider une inscription
        return ($user->is($registration->event->organizer) || $user->isAdmin()) && 
               $registration->exists;
    }

    /**
     * Determine whether the user can view the QR code.
     */
    public function viewQrCode(User $user, Registration $registration): bool
    {
        // L'utilisateur peut voir son propre QR code
        // ou l'organisateur de l'événement peut le voir
        return $user->is($registration->user) || 
               $user->is($registration->event->organizer);
    }

    /**
     * Determine whether the user can scan a QR code.
     */
    public function scan(User $user): bool
    {
        // Seuls les organisateurs et les administrateurs peuvent scanner des QR codes
        return $user->isOrganizer() || $user->isAdmin();
    }
}
