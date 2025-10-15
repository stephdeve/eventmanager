<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\OrganizerSubscriptionReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendSubscriptionReminders extends Command
{
    protected $signature = 'subscriptions:send-reminders {--dry-run : Simuler sans envoi}';

    protected $description = 'Envoie les rappels d\'expiration d\'abonnement aux organisateurs (J-7/J-3/J-1)';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $now = Carbon::now();

        $windows = [
            // [label, date window start, date window end, flag]
            ['J-7', (clone $now)->addDays(7)->startOfDay(), (clone $now)->addDays(7)->endOfDay(), 'reminder_sub_j7_sent_at'],
            ['J-3', (clone $now)->addDays(3)->startOfDay(), (clone $now)->addDays(3)->endOfDay(), 'reminder_sub_j3_sent_at'],
            ['J-1', (clone $now)->addDay()->startOfDay(), (clone $now)->addDay()->endOfDay(), 'reminder_sub_j1_sent_at'],
        ];

        $count = 0;

        foreach ($windows as [$label, $start, $end, $flag]) {
            $this->info("Fenêtre {$label}: {$start->toDateString()} -> {$end->toDateString()}");

            User::query()
                ->where('role', 'organizer')
                ->where('subscription_status', 'active')
                ->whereNotNull('subscription_expires_at')
                ->whereBetween('subscription_expires_at', [$start, $end])
                ->whereNull($flag)
                ->chunkById(200, function ($chunk) use (&$count, $label, $flag, $dry) {
                    foreach ($chunk as $user) {
                        $count++;
                        $this->line(" - #{$user->id} {$user->email} expire le " . optional($user->subscription_expires_at)->toDateString());
                        if ($dry) {
                            continue;
                        }
                        try {
                            $user->notify(new OrganizerSubscriptionReminder($label));
                            $user->forceFill([$flag => now()])->save();
                        } catch (\Throwable $e) {
                            report($e);
                        }
                    }
                });
        }

        $this->info("Rappels d'abonnement envoyés: {$count}");
        if ($dry) {
            $this->comment('Dry run: aucun mail envoyé.');
        }

        return self::SUCCESS;
    }
}
