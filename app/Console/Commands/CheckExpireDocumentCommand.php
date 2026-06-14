<?php

namespace App\Console\Commands;

use App\Jobs\CheckExpireDocumentJob;
use App\Models\DocumentSystem\Document;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpireDocumentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:check-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'function to check the validity period of the document';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CheckExpireDocumentJob::dispatch();
        $this->info('Running well');
    }
}
