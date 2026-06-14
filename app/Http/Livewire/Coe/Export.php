<?php

namespace App\Http\Livewire\Coe;

use Livewire\Component;
use App\Enums\COE\COEStatus;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\COE\Event as CalendarOfEvent;
use App\Models\COE\Category as CalenderCategory;

use App\Exports\CoE\CoEExport;
use Carbon\Carbon;
use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Export extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $rules = ['excelFile' => 'required|file|mimes:xlsx, xls'];
    public $excelFile;

    public $tes = '';
    public $calendarDate = '';
    public $count_event = 0;
    public $viewDetail = false;
    public CalendarOfEvent $detail;
    public $date;


    protected $listeners = ['openDetail', 'confirmDelete'];

    public function getEventsProperty()
    {
        if ($this->date) {
            $curent_year = Carbon::parse($this->date)->year;
        } else {
            $curent_year = Carbon::now()->year;
        }

        $events = CalendarOfEvent::whereYear('start_date', $curent_year)->get();
        $this->count_event = count($events);

        $all_events = [];
        foreach ($events as $event) {
            $all_events[] = $this->event($event);
        }
        return json_encode($all_events);
    }

    private function event(CalendarOfEvent $event)
    {
        $row = [
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start_date->toDateString(),
            'end' => $event->end_date->toDateString(),
        ];

        //Pending
        if ($event->status == COEStatus::Pending) {
            $color =  [
                'color' => '#FFF8E6',
                'textColor' => '#F5B100'
            ];
        }
        //Done
        elseif ($event->status == COEStatus::Done) {
            $color = [
                'color' => '#D2FFE9',
                'textColor' => '#009D50'
            ];
        }
        //Cancel
        elseif ($event->status == COEStatus::Canceled) {
            $color = [
                'color' => '#FFDDE5',
                'textColor' => '#FF003D'
            ];
        }

        return  array_merge($row, $color);
    }

    public function openDetail($id)
    {
        $this->detail = CalendarOfEvent::find($id);
        $this->viewDetail = true;
    }

    public function delete($id)
    {
        $event = CalendarOfEvent::find($id);

        $text = 'Anda yakin akan menghapus event ini ?';
        if(is_null($event->related_event_id)){
            if(CalendarOfEvent::where('related_event_id', $event->id)->exists()){
                $text = 'Event ini adalah event induk dari pengulangan/repeat event, jika Anda menghapusnya maka event turunan/repeat akan terhapus, Anda yakin akan menghapus event ini ?';
            }
        } else {
            $text = 'Anda yakin akan menghapus event ini ?';
        }

        $this->alert('question', '', [
            'title' => 'Hapus Event',
            'text' => $text,
            'showConfirmButton' => true,
            'confirmButtonText' => 'Ya, Hapus',
            'showCancelButton' => true,
            'onConfirmed' => 'confirmDelete',
            'onDismissed' => 'cancelDelete',
            'cancelButtonText' => 'Tidak, Batalkan',
            'position' => 'center',
            'toast' => false,
            'timer' => null,
            'preConfirm' => "() => {return '{$id}'}"
        ]);
    }

    public function confirmDelete($data)
    {
        $event = CalendarOfEvent::find($data['value']);

        if ($event) {
            if(!is_null($event->related_event_id)){
                $event->delete();
            } else {
                CalendarOfEvent::where('related_event_id', $event->id)->delete();
                $event->delete();
            }

            $this->flash('success', 'Event berhasil dihapus.', [], route('coe::callendar'));
        }
    }

    public function cancelDelete()
    {
        $this->reset(['delete_id']);
    }

    public function changeStatus($id, $status)
    {
        $update = CalendarOfEvent::updateOrCreate(['id' => $id], ['status' => $status]);
        if ($update) {
            $this->flash('success', 'Status event berhasil diperbarui.', [], route('coe::callendar'));
        }
    }

    /**
     * export function
     */
    public function export()
    {
        $data = [];
        return Excel::download(new CoEExport($data), 'Coe.xlsx');
    }

    public function render()
    {
        return view('livewire.coe.export');
    }
}
