<?php

namespace App\Console\Commands;

use App\Models\Registration;
use App\Notifications\ParticipantEventReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders {--dry-run : Simuler sans envoi}';

    protected $description = 'Envoie les rappels J-7, J-1 et H-3 aux participants inscrits';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');

        $now = Carbon::now();
        $windows = [
            // [label, start, end, flag]
            ['J-7', (clone $now)->addDays(7)->startOfHour(), (clone $now)->addDays(7)->endOfHour(), 'reminder_j7_sent_at'],
            ['J-1', (clone $now)->addDay()->startOfHour(), (clone $now)->addDay()->endOfHour(), 'reminder_j1_sent_at'],
            ['H-3', (clone $now)->addHours(3)->startOfHour(), (clone $now)->addHours(3)->endOfHour(), 'reminder_h3_sent_at'],
        ];

        $count = 0;

        foreach ($windows as [$label, $start, $end, $flag]) {
            $this->info("Fenêtre {$label}: {$start->toDateTimeString()} -> {$end->toDateTimeString()}");

            Registration::query()
                ->whereNull($flag)
                ->whereHas('event', function ($q) use ($start, $end) {
                    $q->whereBetween('start_date', [$start, $end]);
                })
                ->with(['user', 'event'])
                ->chunkById(200, function ($chunk) use (&$count, $label, $flag, $dry) {
                    foreach ($chunk as $registration) {
                        $count++;
                        $this->line(" - #{$registration->id} {$registration->user->email} / {$registration->event->title}");
                        if ($dry) {
                            continue;
                        }
                        try {
                            $registration->user->notify(new ParticipantEventReminder($registration, $label));
                            $registration->forceFill([$flag => now()])->save();
                        } catch (\Throwable $e) {
                            report($e);
                        }
                    }
                });
        }

        $this->info("Rappels envoyés: {$count}");
        if ($dry) {
            $this->comment('Dry run: aucun mail envoyé.');
        }

        return self::SUCCESS;
    }
}
