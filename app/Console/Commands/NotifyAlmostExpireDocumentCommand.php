<?php

namespace App\Console\Commands;

use App\Jobs\NotifyAlmostExpireDocumentJob;
use App\Models\DocumentSystem\Document;
use App\Models\DocumentSystem\InvitedPeople;
use App\Services\EmailService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyAlmostExpireDocumentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:notify-expire';

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
        NotifyAlmostExpireDocumentJob::dispatch();
        $this->info('Job running in background');
    }
}
