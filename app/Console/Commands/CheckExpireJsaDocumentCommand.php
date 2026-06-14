<?php

namespace App\Console\Commands;

use App\Jobs\CheckExpireJsaDocumentJob;
use Illuminate\Console\Command;

class CheckExpireJsaDocumentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jsa:check-expire';

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
        CheckExpireJsaDocumentJob::dispatch();
        $this->info('running well');
    }
}
