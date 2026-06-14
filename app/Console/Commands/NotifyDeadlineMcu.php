<?php

namespace App\Console\Commands;

use App\Jobs\NotifyDeadlineMcuJob;
use Illuminate\Console\Command;

class NotifyDeadlineMcu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NotifyDeadlineMcu:cron';

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
        NotifyDeadlineMcuJob::dispatch();
        $this->info('Job running in background');
    }
}
