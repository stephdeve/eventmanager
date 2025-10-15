<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizerRevenueThresholdReached extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Event $event)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $amount = (int) ($this->event->total_revenue_minor ?? 0);
        $formatted = \App\Support\Currency::format($amount, $this->event->currency ?? 'XOF');
        return (new MailMessage)
            ->subject('Seuil de ventes atteint • ' . $this->event->title)
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre événement "' . $this->event->title . '" a franchi le seuil de revenus configuré.')
            ->line('Revenu total actuel: ' . $formatted)
            ->action('Voir l\'événement', route('events.show', $this->event))
            ->line('Félicitations !');
    }
}
