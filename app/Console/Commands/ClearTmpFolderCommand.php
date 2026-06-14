<?php

namespace App\Console\Commands;

use App\Jobs\ClearTmpFolderJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearTmpFolderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:tmp-folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all folder inside storage\tmp folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ClearTmpFolderJob::dispatch();
        $this->info('Running in background');

        return 1;
    }
}
