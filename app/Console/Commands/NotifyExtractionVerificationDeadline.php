<?php

namespace App\Console\Commands;

use App\Jobs\NotifyExtractionVerificationDeadlineJob;
use Illuminate\Console\Command;

class NotifyExtractionVerificationDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:extraction-verification-deadline';

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
        NotifyExtractionVerificationDeadlineJob::dispatch();
        $this->info('email sent');
    }
}
