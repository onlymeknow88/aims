<?php

namespace App\Jobs;

use App\Mail\mcu\DeadlineMcu;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Modules\Mcu\Entities\MedicalHistory;

class NotifyDeadlineMcuJob implements ShouldQueue
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
        $mcus = MedicalHistory::where('doctor_status_review', 'In Review')->get();

        $data = [];
        foreach ($mcus as $mcu) {
            $deadline = Carbon::parse(date('Y-m-d'))->diffInDays($mcu->created_at);
            $deadline_date = Carbon::parse($mcu->created_at)->addDays(3);

            if ($deadline == 3) {
                $data = [
                    'id' => $mcu->id,
                    'doctor_name' => $mcu->doctor->name,
                    'employee_name' => $mcu->employee->name,
                    'create_date' => Carbon::parse($mcu->created_at)->format('d/m/Y'),
                    'deadline_date' => Carbon::parse($deadline_date)->format('d/m/Y'),
                ];
                $doctor = Employee::find($mcu->doctor_id);
                $send = $this->notify($doctor->user->email, $data);

            }

        }

    }

    /**
     * Function to send email
     */
    private function notify($email, $data)
    {
        try {

            Mail::to($email)->send(new DeadlineMcu($data));

            return 'success';
        } catch (\Throwable $th) {
            return $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile();
        }
    }
}
