<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizerSubscriptionConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $plan, public \Carbon\Carbon $expiresAt)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Abonnement activé — ' . ucfirst($this->plan))
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre abonnement organisateur a été activé avec succès.')
            ->line('Offre: ' . ucfirst($this->plan))
            ->line('Expiration: ' . $this->expiresAt->translatedFormat('d M Y à H\hi'))
            ->action('Accéder au tableau de bord', route('dashboard'))
            ->line('Merci pour votre confiance !');
    }
}
