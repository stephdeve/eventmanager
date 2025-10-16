<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParticipantRegistrationCreated extends Notification implements ShouldQueue
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
        $isPaid = $registration->payment_status === 'paid';
        $isPending = $registration->payment_status === 'pending';
        $isUnpaid = $registration->payment_status === 'unpaid';

        $urlTicket = route('registrations.show', $registration->qr_code_data);
        $urlPayment = route('payments.pending', $registration);

        $message = (new MailMessage)
            ->subject('Votre inscription à "' . $event->title . '"')
            ->greeting('Bonjour ' . $registration->user->name)
            ->line('Vous êtes inscrit à l\'événement "' . $event->title . '".')
            ->line('Lieu: ' . $event->location)
            ->line('Date: ' . optional($event->start_date)->translatedFormat('d M Y à H\hi'));

        if ($isPaid || $isUnpaid) {
            $message->line('Votre billet est prêt.')->action('Voir mon billet', $urlTicket);
        } elseif ($isPending) {
            $message->line('Votre inscription est en attente de paiement.')->action('Finaliser mon paiement', $urlPayment);
        }

        return $message->line('Merci et à bientôt !');
    }
}
