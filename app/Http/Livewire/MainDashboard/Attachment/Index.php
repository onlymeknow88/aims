<?php

namespace App\Http\Livewire\MainDashboard\Attachment;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

use App\Models\MainDashboard\Attachment;

class Index extends Component
{
    use WithPagination;

    public $itemSelected = [];
    public $itemSelectedAll = [];

    public $countSelected;
    public $dataAll = [];

    public function SelectAll()
    {
        $plucked = collect($this->dataAll)->pluck('id');
        $plucked->all();
        if (count($this->itemSelectedAll) > 0) {
            $this->itemSelected = $plucked;
        } else {
            $this->itemSelected = [];
        }
        $this->countSelected = count($this->itemSelected);
    }

    public function SelectRow($row)
    {
        $id = $row['id'];
        //array found
        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
        }
        //array not found
        else {
            $this->itemSelected[] = $id;
        }
        $this->countSelected = count($this->itemSelected);
    }

    public function confirmDelete()
    {
        $data = Attachment::whereIn('id', $this->itemSelected)->get();
        foreach ($data  as $list) {
            Storage::delete($list->attc);
            $list->delete();
        }
    }

    public function download($id)
    {
        $data = Attachment::where('id', $id)->first();
        return Storage::download($data->url);
    }

    public function validasi()
    {
        return $this->addError('attachments', 'Max. 10 Attachments');
    }

    public function render()
    {
        $data = Attachment::paginate(10);
        $this->dataAll = $data->items();

        return view('livewire.main-dashboard.attachment.index', [
            'data' => $data
        ])
            ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
