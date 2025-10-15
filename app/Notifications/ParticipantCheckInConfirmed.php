<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParticipantCheckInConfirmed extends Notification implements ShouldQueue
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

        return (new MailMessage)
            ->subject('Check-in confirmé • ' . $event->title)
            ->greeting('Bonjour ' . $registration->user->name)
            ->line('Votre présence a été enregistrée pour l\'événement "' . $event->title . '".')
            ->line('Heure de validation: ' . optional($registration->validated_at)->translatedFormat('d M Y à H\hi'))
            ->line('Merci de votre participation !');
    }
}
