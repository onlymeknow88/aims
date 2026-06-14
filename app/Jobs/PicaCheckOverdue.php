<?php

namespace App\Jobs;

use App\Enums\Pica\PicaStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Modules\Pica\Entities\PicaDocument;

class PicaCheckOverdue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();

        $pica = PicaDocument::all();

        foreach ($pica as $key => $value) {
            if ($value->target_settlement_date < $value->settlement_date) {
                $value->status = PicaStatus::Overdue;
                $value->save();
            }
        }

        DB::commit();
    }
}
