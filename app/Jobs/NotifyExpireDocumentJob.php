<?php

namespace App\Jobs;

use App\Mail\DocumentSystem\ExpireDocument;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class NotifyExpireDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $receiver;
    public $ids;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($receiver, $ids)
    {
        $this->receiver = $receiver;
        $this->ids = $ids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (
            count($this->ids) > 0 &&
            count($this->receiver) > 0
        ) {
            $data = [];
            for ($a = 0; $a < count($this->ids); $a++) {
                $document = Document::find($this->ids[$a]);
                $data[] = [
                    'title' => $document->title,
                    'document_number' => $document->fix_document_number,
                ];
            }

            foreach ($data as $key => $value) {
                Mail::to($this->receiver)->send(new ExpireDocument($value));
            }

            // $email = new EmailService();
            // $email->sendEmail([
            //     'receiver' => $this->receiver,
            //     'type' => 'expire_document',
            //     'documents' => $data,
            // ]);
        }
    }
}
