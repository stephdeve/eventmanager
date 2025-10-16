<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParticipantEventReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Registration $registration, public string $window)
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
        $title = sprintf('Rappel %s • %s', $this->window, $event->title);

        $message = (new MailMessage)
            ->subject($title)
            ->greeting('Bonjour ' . $registration->user->name)
            ->line('Un rappel pour votre événement à venir: "' . $event->title . '"')
            ->line('Lieu: ' . $event->location)
            ->line('Date: ' . optional($event->start_date)->translatedFormat('d M Y à H\hi'));

        if ($registration->payment_status === 'pending') {
            $message->line('Votre paiement est en attente.')->action('Finaliser le paiement', route('payments.pending', $registration));
        } else {
            $message->action('Voir mon billet', route('registrations.show', $registration->qr_code_data));
        }

        return $message->line('À très bientôt !');
    }
}
