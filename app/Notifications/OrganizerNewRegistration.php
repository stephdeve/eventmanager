<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizerNewRegistration extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Registration $registration)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $registration = $this->registration->loadMissing(['event', 'user']);
        $event = $registration->event;
        $attendeesUrl = route('events.attendees', $event);

        return (new MailMessage)
            ->subject('Nouvelle inscription à "' . $event->title . '"')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line($registration->user->name . ' s\'est inscrit(e) à votre événement "' . $event->title . '".')
            ->line('Places restantes: ' . max(0, (int) $event->available_seats))
            ->action('Voir les inscrits', $attendeesUrl)
            ->line('Bonne organisation !');
    }
}
