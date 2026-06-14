<?php

namespace Modules\Coe\Http\Livewire;

use App\Enums\COE\COEStatus;
use App\Mail\CoE\ReminderCreatedEvent;
use App\Models\Department;
use App\Models\Section;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;
use Modules\Coe\Entities\Category as CalendarCategory;
use Modules\Coe\Entities\Event as CalendarOfEvent;

class Add extends Component
{
    use WithFileUploads, LivewireAlert;

    public $inputInvited;
    // public $bulkEmail = [];
    public $invitedPeople = [];
    public $notif_email = true;
    public $department;
    public CalendarOfEvent $event;
    public $repeat;
    public $repeat_day;
    public $start_date;
    public $end_date;

    public $file, $file_status;
    public $jenis_upload = '';
    public $jenis_doc = '';
    public $docs = [];

    protected $rules = [
        'event.title' => 'required|string|max:100',
        'event.category_id' => 'required',
        'event.repeat' => 'required|boolean',
        'event.frequency' => 'required|string|in:once,weekly,monthly,yearly',
        'start_date' => 'nullable',
        'end_date' => 'nullable',
        'event.description' => 'required|string',
        // 'department' => 'required|uuid|exists:departments,id',
        // 'event.section_id' => 'required|uuid|exists:sections,id',
    ];

    public function mount()
    {
        $this->event = new CalendarOfEvent();
        $this->repeat_day = 'once';
        $this->event->repeat = false;
        $this->event->frequency = 'once';
        $this->event->category_id = $this->event->category_id ? $this->event->category_id : CalendarCategory::where('name', 'Umum')->first()->id;

    }

    public function getDepartmentsProperty()
    {
        return Department::with('company')->orderBy('name')->get();
    }

    public function getSectionsProperty()
    {
        return Section::where('department_id', $this->department)->orderBy('name')->get();
    }

    public function getCategoriesProperty()
    {
        return CalendarCategory::orderBy('name')->get();
    }

    public function updatingStartDate()
    {
        $this->reset(['end_date']);
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function updatedEventFrequency()
    {
        if ($this->event->frequency != 'once') {
            $this->event->repeat = true;
        }
    }

    public function GetEmailListsProperty(){
        return User::
        // whereHas('department', function ($query) {
        //     $query->whereHas('company', function ($q) {
        //         $q->where('id', $this->company_id);
        //     });
        // })->
        get();
    }

    public function updatedbulkEmail()
    {
        $this->reset(['invitedPeople']);

        if ($this->bulkEmail) {
            $emp = DB::table('employees')
                ->select('users.email')
                ->join('users', 'users.id', '=', 'employees.user_id')
                ->whereIn('employees.department_id', $this->bulkEmail)
                ->get();

            foreach ($emp as $e) {
                if (!in_array($e->email, $this->invitedPeople)) {
                    $this->invitedPeople[] = $e->email;
                }
            }
        } else {
            $this->reset(['bulkEmail']);

        }
    }

    public function addInvitedPeople($email)
    {
        if (in_array($email, $this->invitedPeople)) {
            $this->alert('warning', 'Email sudah terdaftar.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
            $this->emit('clearEmailInput');
        } else {
            $this->invitedPeople[] = $email;
            $this->emit('clearEmailInput');
        }
    }

    public function removeInvited($email)
    {
        $key = array_search($email, $this->invitedPeople);
        unset($this->invitedPeople[$key]);
    }

    // public function updatedFIle()
    // {
    //     $filesize = File::size($this->file->path());
    //     if ($filesize > 250000) {
    //         $this->addError('file', 'File Size tidak boleh lebih dari 250 Kb');
    //         $this->file = null;
    //     }
    // }

    /*
     * CREATE NEW
     */
    public function save()
    {
        try {
            $this->validate();

            $start_date = Carbon::parse($this->start_date);
            $end_date = ($this->repeat_day == 'once') ? Carbon::parse($this->start_date) : Carbon::parse($this->end_date);
            $end_of_year = Carbon::parse($this->start_date)->endOfYear();

            if ($this->file) {
                $filetype = pathinfo($this->file->path(), PATHINFO_EXTENSION);
                $file_name = "" . slugify($this->event->title) . "-" . slugify(Carbon::now()->toDateTimeString()) . ".$filetype";

                $this->file->storeAs('coe_attachment', $file_name, ['disk' => 'local']);
            } else {
                $file_name = null;
            }

            $this->event->user_id = Auth::user()->id;
            $this->event->attachment = $file_name;
            $this->event->category_id = $this->event->category_id ? $this->event->category_id : CalendarCategory::where('name', 'Umum')->first()->id;
            $this->event->invited_emails = $this->invitedPeople;
            $this->event->must_send_email = $this->notif_email;
            $this->event->status = COEStatus::Pending;
            $this->event->start_date = $start_date;
            $this->event->end_date = $end_date;
            $this->event->repeat = ($this->event->frequency == 'once') ? false : true;
            // dd($this->event);
            $this->event->save();
            $ids = [];
            $ids[] = $this->event->id;

            if ($this->event->repeat) {
                if ($this->event->frequency == 'weekly') {
                    $last_start_date = $start_date->addWeek();
                    $last_end_date = $end_date->addWeek();

                    while ($last_start_date < $end_of_year) {
                        $new_event = $this->event->replicate();
                        $new_event->start_date = $last_start_date;
                        $new_event->end_date = $last_end_date;
                        $new_event->related_event_id = $this->event->id;
                        $new_event->save();

                        $ids[] = $new_event->id;
                        $last_start_date = $last_start_date->addWeek();
                        $last_end_date = $last_end_date->addWeek();
                    }
                } elseif ($this->event->frequency == 'monthly') {
                    $last_start_date = $start_date->addMonth();
                    $last_end_date = $end_date->addMonth();

                    while ($last_start_date < $end_of_year) {
                        $new_event = $this->event->replicate();
                        $new_event->start_date = $last_start_date;
                        $new_event->end_date = $last_end_date;
                        $new_event->related_event_id = $this->event->id;
                        $new_event->save();

                        $ids[] = $new_event->id;
                        $last_start_date = $last_start_date->addMonth();
                        $last_end_date = $last_end_date->addMonth();
                    }
                }
            }

            if ($this->notif_email) {
                if ($this->invitedPeople) {
                    $emails = $this->invitedPeople;

                    foreach ($emails as $email) {

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

                    }
                }
            }

            // dd($send);

            $this->flash('success', 'Event berhasil disimpan', [], route('coe::callendar'));

        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('coe::livewire.add')->extends('layouts.no-header');
    }
}
