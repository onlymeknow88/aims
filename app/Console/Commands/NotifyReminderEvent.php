<?php

namespace App\Console\Commands;

use App\Jobs\NotifyReminderEventJob;
use Illuminate\Console\Command;

class NotifyReminderEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NotifyReminderEvent:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        NotifyReminderEventJob::dispatch();
        $this->info('Job running in background');
    }
}
