<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizerPhysicalUnpaidScanned extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Event $event, public ?Ticket $ticket = null)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $event = $this->event;
        $title = $event->title;
        $attendeesUrl = route('events.attendees', $event);

        $msg = (new MailMessage)
            ->subject("Alerte: Billet non payé scanné — {$title}")
            ->greeting('Bonjour ' . $notifiable->name)
            ->line("Un billet marqué comme non payé (paiement sur place) vient d'être scanné pour l'événement \"{$title}\".")
            ->action('Gérer les participants', $attendeesUrl)
            ->line('Pensez à encaisser le paiement et à mettre à jour le statut si nécessaire.');

        if ($this->ticket) {
            $owner = optional($this->ticket->owner)->name;
            $msg->line('Détenteur du billet: ' . ($owner ?: 'Inconnu'));
        }

        return $msg;
    }
}
