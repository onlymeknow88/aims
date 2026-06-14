<?php

namespace App\Jobs;

use App\Enums\COE\COEStatus;
use App\Mail\CoE\ReminderEvent;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Modules\Coe\Entities\Event;

class NotifyReminderEventJob implements ShouldQueue
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
        $deadline_date = Carbon::now()->addDays(3)->format('Y-m-d');
        $events = Event::whereDate('start_date', '=', $deadline_date)->where('status', COEStatus::Pending)->get();

        $data = [];
        foreach ($events as $event) {
            $data = [
                'id' => $event->id,
                'event_name' => $event->name,
                'item' => 'ss',
                'sub_item' => 'ss',
                'deadline_date' => Carbon::now()->addDays(3)->format('d/m/Y'),
            ];
            $send = $this->notify($event->invited_emails, $data);
        }

    }

    /**
     * Function to send email
     */
    private function notify($invited_emails, $data)
    {
        try {
            foreach ($invited_emails as $email) {
                Mail::to($email)->send(new ReminderEvent($data));
            }

            return 'success';
        } catch (\Throwable $th) {
            return $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile();
        }
    }
}
