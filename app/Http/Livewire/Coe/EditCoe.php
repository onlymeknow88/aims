<?php

namespace App\Http\Livewire\Coe;

use Livewire\Component;
use App\Enums\COE\COEStatus;
use App\Models\COE\Event as CalendarOfEvent;
use App\Models\COE\Category as CalendarCategory;
use App\Models\Department;
use App\Models\Section;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditCoe extends Component
{
    use LivewireAlert;

    public $inputInvited;
    public $invitedPeople = [];
    public $notif_email = true;

    public $department;
    public CalendarOfEvent $event;
    public $start_date;
    public $end_date;
    public $saved_start_date;
    public $saved_end_date;

    protected $listeners = ['saveRepeat'];

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

    public function mount(CalendarOfEvent $event)
    {
        $this->event = $event;
        $this->invitedPeople = $event->invited_emails;
        $this->department = $event->section->department_id;

        $this->start_date = $event->start_date->format('M d, Y');
        $this->saved_start_date = $event->start_date->format('M d, Y');

        $this->end_date = $event->end_date->format('M d, Y');
        $this->saved_end_date = $event->end_date->format('M d, Y');
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

    public function save()
    {
        $this->validate();

        if(!$this->event->repeat){
            $this->saveSingleEvent();
        } else {
            $text = '<strong>Hanya Event Ini</strong><br> Perubahan hanya akan diterpkan untuk event ini saja.';
            $text .= '<br><br>';
            $text .= '<strong>Event ini dan selanjutnya</strong><br> Perubahan akan diterapkan untuk event ini dan event selanjutnya yang berstatus <i>PENDING</i>.';

            $this->alert('question', '', [
                'toast' => false,
                'timer' => null,
                'position' => 'center',
                'html' => $text,
                'input' => 'select',
                'inputOptions' => [
                    'single' => 'Hanya event ini',
                    'single_next' => 'Event ini dan selanjutnya'
                ],
                'allowOutsideClick' => false,
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'confirmButtonText' => 'Submit',
                'cancelButtonText' => 'Cancel',
                'onConfirmed' => 'saveRepeat'
            ]);
        }
    }

    public function saveSingleEvent($redirect = true)
    {
        $start_date =  Carbon::parse($this->start_date);
        $end_date =  Carbon::parse($this->end_date);

        $this->event->invited_emails = $this->invitedPeople;
        $this->event->must_send_email = $this->notif_email;
        $this->event->status = COEStatus::Pending;
        $this->event->start_date = $start_date;
        $this->event->end_date = $end_date;
        $this->event->save();

        if($redirect){
            $this->flash('success', 'Perubahan berhasil disimpan', [], route('coe'));
        }
    }

    public function saveRepeat($data)
    {
        if($data['value'] == 'single'){
            $this->saveSingleEvent();
        } else {
            $this->saveSingleEvent(false);

            $start_date =  Carbon::parse($this->start_date);
            $end_date =  Carbon::parse($this->end_date);

            if($this->event->is_parent){
                if($this->event->frequency == 'weekly'){
                    $children = CalendarOfEvent::where('related_event_id', $this->event->id)
                        ->orderBy('start_date')->get();

                    $last_start_date = $start_date->addWeek();
                    $last_end_date = $end_date->addWeek();

                    foreach ($children as $child) {
                        $child->invited_emails = $this->invitedPeople;
                        $child->must_send_email = $this->notif_email;
                        $child->status = COEStatus::Pending;
                        $child->section_id = $this->event->section_id;
                        $child->description = $this->event->description;
                        $child->title = $this->event->title;
                        $child->category_id = $this->event->category_id;
                        $child->start_date = $last_start_date;
                        $child->end_date = $last_end_date;
                        $child->save();

                        $last_start_date = $last_start_date->addWeek();
                        $last_end_date = $last_end_date->addWeek();
                    }
                } elseif($this->event->frequency == 'monthly'){
                    $children = CalendarOfEvent::where('related_event_id', $this->event->id)
                        ->orderBy('start_date')->get();

                    $last_start_date = $start_date->addMonth();
                    $last_end_date = $end_date->addMonth();

                    foreach ($children as $child) {
                        $child->invited_emails = $this->invitedPeople;
                        $child->must_send_email = $this->notif_email;
                        $child->status = COEStatus::Pending;
                        $child->section_id = $this->event->section_id;
                        $child->description = $this->event->description;
                        $child->title = $this->event->title;
                        $child->category_id = $this->event->category_id;
                        $child->start_date = $last_start_date;
                        $child->end_date = $last_end_date;
                        $child->save();

                        $last_start_date = $last_start_date->addMonth();
                        $last_end_date = $last_end_date->addMonth();
                    }
                }
            } else {
                if($this->saved_start_date == $this->start_date && $this->saved_end_date == $this->end_date){
                    $children = CalendarOfEvent::where('related_event_id', $this->event->related_event_id)
                        ->where('start_date', '>', Carbon::parse($this->saved_start_date))
                        ->whereStatus(COEStatus::Pending)
                        ->orderBy('start_date')->get();

                    foreach ($children as $child) {
                        $child->invited_emails = $this->invitedPeople;
                        $child->must_send_email = $this->notif_email;
                        $child->status = COEStatus::Pending;
                        $child->section_id = $this->event->section_id;
                        $child->description = $this->event->description;
                        $child->title = $this->event->title;
                        $child->category_id = $this->event->category_id;
                        $child->save();
                    }
                } else {
                    if($this->event->frequency == 'weekly'){
                        $children = CalendarOfEvent::where('related_event_id', $this->event->related_event_id)
                            ->where('start_date', '>', Carbon::parse($this->saved_start_date))
                            ->orderBy('start_date')->get();

                        $last_start_date = $start_date->addWeek();
                        $last_end_date = $end_date->addWeek();

                        foreach ($children as $child) {
                            if($child->status == COEStatus::Pending){
                                $child->invited_emails = $this->invitedPeople;
                                $child->must_send_email = $this->notif_email;
                                $child->status = COEStatus::Pending;
                                $child->section_id = $this->event->section_id;
                                $child->description = $this->event->description;
                                $child->title = $this->event->title;
                                $child->category_id = $this->event->category_id;
                                $child->start_date = $last_start_date;
                                $child->end_date = $last_end_date;
                                $child->related_event_id = $this->event->id;
                                $child->save();
                            }

                            $last_start_date = $last_start_date->addWeek();
                            $last_end_date = $last_end_date->addWeek();
                        }
                    } elseif($this->event->frequency == 'monthly'){
                        $children = CalendarOfEvent::where('related_event_id', $this->event->related_event_id)
                            ->where('start_date', '>', Carbon::parse($this->saved_start_date))
                            ->orderBy('start_date')->get();

                        $last_start_date = $start_date->addWeek();
                        $last_end_date = $end_date->addWeek();

                        foreach ($children as $child) {
                            dd($child);
                            if($child->status == COEStatus::Pending){
                                $child->invited_emails = $this->invitedPeople;
                                $child->must_send_email = $this->notif_email;
                                $child->status = COEStatus::Pending;
                                $child->section_id = $this->event->section_id;
                                $child->description = $this->event->description;
                                $child->title = $this->event->title;
                                $child->category_id = $this->event->category_id;
                                $child->start_date = $last_start_date;
                                $child->end_date = $last_end_date;
                                $child->related_event_id = $this->event->id;
                                $child->save();
                            }

                            $last_start_date = $last_start_date->addMonth();
                            $last_end_date = $last_end_date->addMonth();
                        }
                    }

                    $this->event->related_event_id = null;
                    $this->event->save();
                }
            }

            $this->flash('success', 'Perubahan berhasil disimpan', [], route('coe'));
        }
    }

    public function render()
    {
        return view('livewire.coe.edit-coe')->extends('layouts.no-header');
    }

}
