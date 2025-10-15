<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire {--downgrade=1 : Downgrade role to student when expired} {--dry-run : Do not persist changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark expired organizer subscriptions as expired and optionally downgrade their role.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = Carbon::now();
        $dryRun = (bool) $this->option('dry-run');
        $downgrade = (bool) (int) $this->option('downgrade');

        $query = User::query()
            ->where('role', 'organizer')
            ->where('subscription_status', 'active')
            ->whereNotNull('subscription_expires_at')
            ->where('subscription_expires_at', '<=', $now);

        $count = 0;
        $this->info('Scanning for expired subscriptions at ' . $now->toDateTimeString());

        $query->chunkById(500, function ($users) use (&$count, $dryRun, $downgrade) {
            foreach ($users as $user) {
                $count++;
                $this->line(sprintf(' - #%d %s (%s) expired at %s', $user->id, $user->email, $user->subscription_plan, optional($user->subscription_expires_at)->toDateTimeString()));

                if ($dryRun) {
                    continue;
                }

                DB::transaction(function () use ($user, $downgrade) {
                    $payload = [
                        'subscription_status' => 'expired',
                    ];
                    if ($downgrade) {
                        $payload['role'] = 'student';
                    }

                    $user->forceFill($payload)->save();
                });
            }
        });

        $this->info("Processed {$count} expired subscription(s).");
        if ($dryRun) {
            $this->comment('Dry run: no changes were persisted.');
        }

        return self::SUCCESS;
    }
}
