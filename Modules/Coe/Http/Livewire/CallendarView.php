<?php

namespace Modules\Coe\Http\Livewire;

use App\Enums\COE\COEStatus;
use Auth;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Coe\Entities\Event as CalendarOfEvent;
use Modules\Coe\Exports\CoEExport;
use Modules\Coe\Imports\CoEImport;

class CallendarView extends Component
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

        if (Auth::user()->hasPermissionTo('COE - Superuser')) {
            $events = CalendarOfEvent::whereYear('start_date', $curent_year)->get();
        } else {
            $events = CalendarOfEvent::whereYear('start_date', $curent_year)
                ->where('invited_emails', 'like', '%' . auth()->user()->email . '%')
                ->orWhere('user_id', Auth::user()->id)
                ->orWhereHas('category', function ($query) {
                    $query->where('name', 'Umum');
                })->get();
        }

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

        if ($event->start_date == $event->end_date || empty($event->end_date)) {
            $display = 'single';
        } else {
            $display = 'multi';
        }

        //Pending
        if ($event->status == COEStatus::Pending) {
            $color = [
                // 'color' => '#F58500',
                // 'textColor' => '#FFFFFF',
                'classNames' => 'pending ' . $display . '',
            ];
        }
        //Done
        elseif ($event->status == COEStatus::Done) {
            $color = [
                // 'color' => '#007D40',
                // 'textColor' => '#FFFFFF',
                'classNames' => 'done ' . $display . '',
            ];
        }
        //Cancel
        elseif ($event->status == COEStatus::Canceled) {
            $color = [
                // 'color' => '#FF003D',
                // 'textColor' => '#FFFFFF',
                'classNames' => 'cancel ' . $display . '',
            ];
        }

        // if ($event->start_date == $event->end_date) {
        //     $display = ['display' => 'list-item'];
        // } else {
        //     $display = ['display' => 'block'];
        // }

        // return array_merge($row, $display, $color);
        return array_merge($row, $color);
    }

    public function openDetail($id)
    {
        $this->detail = CalendarOfEvent::find($id);
        $this->viewDetail = true;
    }

    public function closeDetail()
    {
        $this->viewDetail = false;
        $this->dispatchBrowserEvent('size-updated');
    }

    public function attachment($id)
    {
        $coe = CalendarOfEvent::find($id);
        $path = "" . storage_path('app/coe_attachment/') . "" . $coe->attachment . "";
        // $file = Storage::disk('local')->get($path);

        return response()->file($path);
    }

    public function delete($id)
    {
        $event = CalendarOfEvent::find($id);

        $text = 'Anda yakin akan menghapus event ini ?';
        if (is_null($event->related_event_id)) {
            if (CalendarOfEvent::where('related_event_id', $event->id)->exists()) {
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
            'preConfirm' => "() => {return '{$id}'}",
        ]);
    }

    public function confirmDelete($data)
    {
        $event = CalendarOfEvent::find($data['value']);

        if ($event) {
            if (!is_null($event->related_event_id)) {
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

    public function import()
    {

        $this->validate();
        Excel::import(new CoEImport, $this->excelFile);

        session()->flash('msg', __('Data COE berhasil disimpan'));
        session()->flash('alert', 'success');
        redirect()->route('coe::callendar');
    }

    public function render()
    {
        // if (Auth::user()->hasPermissionTo('COE - View Callendar')) {
        return view('coe::livewire.callendar-view')->layout('coe::layouts.app');
        // } else {
        //     return abort(404);
        // }
    }
}
