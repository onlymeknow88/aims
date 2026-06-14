<?php

namespace Modules\KPP\Jobs;

use App\Mail\KPP\CompanyObedienceCreated;
use App\Mail\KPP\UserObedienceCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class NewObedienceNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notify_emails;
    public $data;
    public $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $notify_emails, $data)
    {
        $this->type = $type;
        $this->notify_emails = $notify_emails;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 'user') {
            Mail::to($this->notify_emails)->send(new UserObedienceCreated($this->data));
        } elseif($this->type == 'company') {
            Mail::to($this->notify_emails)->send(new CompanyObedienceCreated($this->data));
        }
        //error_log('Some message here.');
    }
}
