<?php

namespace App\Console;

use App\Console\Commands\CheckExpireDocumentCommand;
use App\Console\Commands\CheckExpireJsaDocumentCommand;
use App\Console\Commands\ClearTmpFolderCommand;
use App\Console\Commands\NotifyAlmostExpireDocumentCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(NotifyAlmostExpireDocumentCommand::class)
            ->cron('34 2 * * *')
            ->timezone('Asia/Jakarta');
        $schedule->command(CheckExpireDocumentCommand::class)
            ->cron('34 2 * * *')
            ->timezone('Asia/Jakarta');
        $schedule->command(CheckExpireJsaDocumentCommand::class)
            ->cron('59 2 * * *')
            ->timezone('Asia/Jakarta');
        // clear tmp folder every midnight
        $schedule->command(ClearTmpFolderCommand::class)
            ->cron('0 0 * * *')
            ->timezone('Asia/Jakarta');
        $schedule->command('notify:extraction-verification-deadline')
            ->daily();
        $schedule->command('NotifyDeadlineMcu:cron')
            ->daily();
        $schedule->command('NotifyReminderEvent:cron')
            ->daily();
        $schedule->command('pica:check-overdue')
            ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
