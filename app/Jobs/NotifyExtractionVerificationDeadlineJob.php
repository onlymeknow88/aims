<?php

namespace App\Jobs;

use App\Enums\KPP\ExtractionStatus;
use App\Mail\KPP\ExtractionVerificationDeadline;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Modules\KPP\Entities\KppExtraction;

class NotifyExtractionVerificationDeadlineJob implements ShouldQueue
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
        \Log::info("Cron is working fine!");
        //90, 60, 30, 10, h-1
        $extractions = KppExtraction::query()
            ->where(function ($query) {
                $query->where('date', '=', now()->addDays(90))
                    ->orWhere('date', '=', now()->addDays(60))
                    ->orWhere('date', '=', now()->addDays(30))
                    ->orWhere('date', '=', now()->addDays(10))
                    ->orWhere('date', '=', now()->addDays(1));
            })
            ->whereIn('status', [ExtractionStatus::Checking()->value, ExtractionStatus::NotComply()->value])
            ->get();

        foreach ($extractions as $extraction) {
            Mail::to($extraction->responsibleUser->email)->send(new ExtractionVerificationDeadline($extraction));
        }
    }
}
