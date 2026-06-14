<?php

namespace Modules\Coe\Imports;

use App\Enums\COE\COEStatus;
use App\Mail\CoE\ReminderCreatedEvent;
use Modules\Coe\Entities\Category as CalendarCategory;
use Modules\Coe\Entities\Event as CalendarOfEvent;
use App\Models\Department;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;
use Mail;

class CoEImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts, WithChunkReading
{

    use Importable, LivewireAlert;

    public function rules(): array
    {
        return [
            '*.category' => function ($attribute, $value, $onFailure) {
                if ($value) {
                    $count = CalendarCategory::where('name', $value)->count();
                    if ($count < 1) {
                        $onFailure('Kategori belum terdaftar di sistem !');
                    }
                } else {
                    $onFailure('Kategori tidak boleh kosong !');
                }
            },
            // '*.department' => function ($attribute, $value, $onFailure) {
            //     if ($value) {
            //         $count = Department::where('code', $value)->count();
            //         if ($count < 1) {
            //             $onFailure('Departemen belum terdaftar di sistem !');
            //         }
            //     } else {
            //         $onFailure('Departemen tidak boleh kosong !');
            //     }
            // },
            // '*.section' => function ($attribute, $value, $onFailure) {
            //     if ($value) {
            //         $count = Section::where('name', $value)->count();
            //         if ($count < 1) {
            //             $onFailure('Section belum terdaftar di sistem !');
            //         }
            //     } else {
            //         $onFailure('Section tidak boleh kosong !');
            //     }
            // },
            'event_name' => 'required|string|max:100',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.event_name' => 'Nama event tidak boleh kosong atau lebih dari 100 karakter!',
            '*.start_date' => 'Tanggal mulai event tidak boleh kosong!',
            '*.end_date' => 'Tanggal akhir event tidak boleh kosong!',
        ];
    }

    public function model(array $row)
    {
        // dd(explode(',',$row['invited_email']));
        try {
            $start_date = Carbon::createFromFormat('d m Y', $row['start_date']);
            $end_date = Carbon::createFromFormat('d m Y', $row['end_date']);
            $end_of_year = Carbon::createFromFormat('d m Y', $row['start_date'])->endOfYear();

            $category_id = CalendarCategory::where('name', $row['category'])->firstOrFail()->id;
            // $dpt_id = Department::where('code', $row['department'])->firstOrFail()->id;
            // $section_id = Section::where('name', $row['section'])->firstOrFail()->id;
            // dd($section_id);

            $invited_emails = ($row['invited_email']) ? explode(',', $row['invited_email']) : null;
            $mse = ($row['must_send_email']) ? $row['must_send_email'] : no;
            $must_send_email = ($mse == 'yes') ? 1 : 0;

            $this->event = new CalendarOfEvent();
            $this->event->title = $row['event_name'];
            $this->event->category_id = $category_id;
            $this->event->description = $row['description'];
            // $this->event->section_id = $section_id;
            $this->event->repeat = 0; // No Repeat
            $this->event->invited_emails = $invited_emails;
            $this->event->must_send_email = 0;
            $this->event->status = COEStatus::Pending;
            $this->event->start_date = $start_date;
            $this->event->end_date = $end_date;
            // dd($this->event);
            $this->event->save();
            $ids = [];
            $ids[] = $this->event->id;

            // Blast email
            if ($must_send_email == 1) {
                if ($invited_emails) {

                    foreach ($invited_emails as $email) {
                        $user = User::where('email', $email)->first();
                        if ($user) {
                            $type = 'login';
                        } else {
                            $type = 'non-login';
                        }

                        $data = [
                            'event' => $this->event,
                            'type' => $type,
                            'link' => 'coe/inv?ids=' . implode(",", $ids) . '',
                        ];

                        Mail::to($email)->send(new ReminderCreatedEvent($data));

                        // $send = Mail::send('coe::mail.invite', ['type' => $type, 'title' => $this->event->title, 'body' => $this->event->description, 'ids' => $ids], function ($message) use ($email) {
                        //     $message->to($email)->subject($this->event->title);
                        // });
                    }
                }
            }

            $this->flash('success', 'Event berhasil disimpan', [], route('coe::callendar'));

        } catch (ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        }

    }

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
