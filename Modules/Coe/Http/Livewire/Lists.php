<?php

namespace Modules\Coe\Http\Livewire;

use App\Exports\CoE\CoEExport;
use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Coe\Entities\Event as CalendarOfEvent;

class Lists extends Component
{
    protected $listeners = ['openDetail', 'confirmDelete'];

    use WithPagination;

    public $itemSelected = [];
    public $countSelected = 0;
    public $latestUpdate = 'Update on Sep 24, 2022 . 15.00 pm';
    public $countData = 0;
    public $limit = 0;

    public function mount()
    {
        $curent_year = Carbon::now()->year;
        // $this->limit = 50;

        if (Auth::user()->hasPermissionTo('COE - Superuser')) {
            $this->countData = CalendarOfEvent::whereYear('start_date', $curent_year)->count();
        } else {
            $this->countData = CalendarOfEvent::whereYear('start_date', $curent_year)
                ->where('invited_emails', 'like', '%' . auth()->user()->email . '%')
                ->orWhere('user_id', Auth::user()->id)
                ->orWhereHas('category', function ($query) {
                    $query->where('name', 'Umum');
                })->count();
        }
        $this->limit = $this->countData;
    }

    public function openDetail($id)
    {
        $this->detail = CalendarOfEvent::find($id);
        $this->viewDetail = true;
    }

    public function export()
    {
        return Excel::download(new CoEExport($this->itemSelected), 'Coe.xlsx');
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

    public function render()
    {
        if (Auth::user()->hasPermissionTo('COE - View List')) {

            // if ($this->date) {
            //     $curent_year = Carbon::parse($this->date)->year;
            // } else {
            $curent_year = Carbon::now()->year;
            // }

            if (Auth::user()->hasPermissionTo('COE - Superuser')) {
                $CalendarOfEvent = CalendarOfEvent::whereYear('start_date', $curent_year)->paginate($this->limit);
            } else {
                $CalendarOfEvent = CalendarOfEvent::whereYear('start_date', $curent_year)
                    ->where('invited_emails', 'like', '%' . auth()->user()->email . '%')
                    ->orWhere('user_id', Auth::user()->id)
                    ->orWhereHas('category', function ($query) {
                        $query->where('name', 'Umum');
                    })->paginate($this->limit);
            }

            return view('coe::livewire.lists', [
                'CalendarOfEvent' => $CalendarOfEvent,
            ])->layout('coe::layouts.app');
        } else {
            return abort(404);
        }
    }

    public function onSelectedItem($id)
    {

        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
            $this->countSelected++;
        }

    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }
}
