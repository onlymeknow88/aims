<?php

namespace App\Http\Livewire\Coe;

use App\Enums\COE\COEStatus;
use Livewire\Component;
use App\Models\COE\Event as CalendarOfEvent;
use App\Models\COE\Category as CalendarCategory;
use Carbon\Carbon;
use App\Models\Department;
use App\Models\User;
use App\Models\Section;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mail;

class AddCoe extends Component
{
    use LivewireAlert;

    public $inputInvited;
    public $bulkEmailByDepartment;
    // public $bulkEmailByDepartment;
    public $invitedPeople = [];
    public $notif_email = true;

    public $department;
    public CalendarOfEvent $event;
    public $start_date;
    public $end_date;

    protected $rules = [
        'department' => 'required|uuid|exists:departments,id',
        'event.title' => 'required|string|max:100',
        'event.category_id' => 'required|uuid|exists:coe_categories,id',
        'event.repeat' => 'required|boolean',
        'event.frequency' => 'required|string|in:weekly,monthly,yearly',
        'start_date' => 'nullable',
        'end_date' => 'nullable',
        'event.section_id' => 'required|uuid|exists:sections,id',
        'event.description' => 'required|string',
    ];

    public function mount()
    {
        $this->event = new CalendarOfEvent();

        $this->event->repeat = true;
        $this->event->frequency = 'weekly';
    }

    public function getDepartmentsProperty()
    {
        return Department::orderBy('name')->get();
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

    public function updatedEventRepeat()
    {
        $this->event->frequency = 'weekly';
        $this->emit('initDate');
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

    /*
    * CREATE NEW
    */
    public function save()
    {
        $this->validate();

        $start_date =  Carbon::parse($this->start_date);
        $end_date =  Carbon::parse($this->end_date);
        $end_of_year = Carbon::parse($this->start_date)->endOfYear();

        $this->event->invited_emails = $this->invitedPeople;
        $this->event->must_send_email = $this->notif_email;
        $this->event->status = COEStatus::Pending;
        $this->event->start_date = $start_date;
        $this->event->end_date = $end_date;
        $this->event->save();
        $ids = [];
        $ids[] = $this->event->id;

// dd($ids);
        if($this->event->repeat){
            if($this->event->frequency == 'weekly'){
                $last_start_date = $start_date->addWeek();
                $last_end_date = $end_date->addWeek();

                while($last_start_date < $end_of_year){
                    $new_event = $this->event->replicate();
                    $new_event->start_date = $last_start_date;
                    $new_event->end_date = $last_end_date;
                    $new_event->related_event_id = $this->event->id;
                    $new_event->save();

                    $ids[] = $new_event->id;
                    $last_start_date = $last_start_date->addWeek();
                    $last_end_date = $last_end_date->addWeek();
                }
            } elseif($this->event->frequency == 'monthly'){
                $last_start_date = $start_date->addMonth();
                $last_end_date = $end_date->addMonth();

                while($last_start_date < $end_of_year){
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

                    $send = Mail::send('mail.coe.invite', ['type' => $type, 'ids' => $ids, 'title' => $this->event->title,'body' => $this->event->description], function ($message) use ($email) {
                        $message->to($email)->subject($this->event->title);
                    });
                }
            }
        }

        // dd($send);

        $this->flash('success', 'Event berhasil disimpan', [], route('coe'));
    }

    public function render()
    {
        return view('livewire.coe.add-coe')->extends('layouts.no-header');
    }
}
