<?php

namespace App\Jobs;

use App\Mail\DocumentSystem\AlmostExpireDocument;
use Modules\DocumentSystem\Services\EmailService;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\InvitedPeople;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class NotifyAlmostExpireDocumentJob implements ShouldQueue
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
        $documents = Document::exceptDraft()
            ->get();

        $ids = [];
        foreach ($documents as $document) {
            $expire_date = Carbon::parse($document->doc_created)->addYear(2);
            $expire_lenght = Carbon::parse(date('Y-m-d'))->diffInDays($expire_date);

            if ($expire_lenght == 7) {
                $ids['week'][] = [
                    'id' => $document->id,
                    'title' => $document->title,
                    'document_number' => $document->fix_document_number,
                ];
            }

            if ($expire_lenght == 3) {
                $ids['three'][] = [
                    'id' => $document->id,
                    'title' => $document->title,
                    'document_number' => $document->fix_document_number,
                ];
            }

            if ($expire_lenght == 1) {
                $ids['one'][] = [
                    'id' => $document->id,
                    'title' => $document->title,
                    'document_number' => $document->fix_document_number,
                ];
            }
        }

        if (isset($ids['week'])) {
            $peoples = $this->getPeoples(collect($ids['week'])->pluck('id')->all());
            $send = $this->notify($peoples, $ids['week'], 7);
        }
        if (isset($ids['three'])) {
            $peoples = $this->getPeoples(collect($ids['three'])->pluck('id')->all());
            $send = $this->notify($peoples, $ids['three'], 3);
        }
        if (isset($ids['one'])) {
            $peoples = $this->getPeoples(collect($ids['one'])->pluck('id')->all());
            $send = $this->notify($peoples, $ids['one'], 1);
        }
    }

    /**
     * Function to get notify email if exist
     * @param array ids
     * @return array
     */
    private function getPeoples($ids)
    {
        $peoples = [];
        for ($a = 0; $a < count($ids); $a++) {
            $invited = InvitedPeople::select("email")
                ->where('document_id', $ids[$a])
                ->first();

            $peoples[] = $invited->email ?? '';
        }

        return $peoples;
    }

    /**
     * Function to send email
     */
    private function notify($emails, $documents, $day)
    {
        try {
            if (count($emails) > 0) {
                $payload = [
                    'type' => 'almost_expire_document',
                    'receiver' => $emails,
                    'documents' => $documents,
                    'day' => $day,
                    'has_attachments' => false,
                ];

                for ($a = 0; $a < count($emails); $a++) {
                    $data = [
                        'type' => 'almost_expire_document',
                        'receiver' => $emails[$a],
                        'documents' => $documents[$a],
                        'day' => $day,
                        'has_attachments' => false,
                    ];

                    Mail::to($emails[$a])->send(new AlmostExpireDocument($data));
                }

                // $email = new EmailService();
                // $email->sendEmail($payload);
            }
            return 'success';
        } catch (\Throwable $th) {
            return $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile();
        }
    }
}
