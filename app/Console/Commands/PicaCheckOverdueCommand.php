<?php

namespace App\Console\Commands;

use App\Jobs\PicaCheckOverdue;
use Illuminate\Console\Command;

class PicaCheckOverdueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pica:check-overdue';

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
        PicaCheckOverdue::dispatch();
        $this->info('pica check overdue');
    }
}
