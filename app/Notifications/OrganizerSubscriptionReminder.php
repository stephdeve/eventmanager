<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizerSubscriptionReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $window)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $title = match ($this->window) {
            'J-7' => 'Rappel: votre abonnement expire dans 7 jours',
            'J-3' => 'Rappel: votre abonnement expire dans 3 jours',
            'J-1' => 'Dernier rappel: votre abonnement expire demain',
            default => 'Rappel abonnement organisateur',
        };

        return (new MailMessage)
            ->subject($title)
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre abonnement organisateur arrive à expiration le ' . optional($notifiable->subscription_expires_at)->translatedFormat('d M Y à H\hi') . '.')
            ->action('Renouveler maintenant', route('subscriptions.plans'))
            ->line('Merci d\'utiliser ' . config('app.name') . '.');
    }
}
