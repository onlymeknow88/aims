<?php

namespace Modules\Coe\Http\Livewire;

use Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Coe\Entities\Category as CalenderCategory;

class Category extends Component
{
    use LivewireAlert;
    protected $listeners = ['openDetail', 'confirmDelete'];

    use WithPagination;

    public $category_name;
    public $itemSelected = [];
    public $countSelected = 0;
    public $latestUpdate = 'Update on Sep 24, 2022 . 15.00 pm';
    public $countData = 0;
    public $limit = 100;

    public function mount()
    {
        $this->limit = 50;
    }

    public function saveCoECategory()
    {

        $this->validate([
            'category_name' => 'required',
        ]);
        $this->category = new CalenderCategory();
        $this->category->name = $this->category_name;
        $this->category->save();

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Success',
            'icon' => 'success',
            'text' => 'Category saved succesfully',
        ]);

        redirect()->route('coe::category');
    }

    public function delete()
    {
        foreach ($this->itemSelected as $val) {
            $id = $val;
        }
        // dd($id);

        $category = CalenderCategory::find($id);

        $text = 'Anda yakin akan menghapus category ini ?';

        $this->alert('question', '', [
            'title' => 'Hapus Category',
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
        $category = CalenderCategory::find($data['value']);
        if ($category) {
            $category->delete();
            $this->flash('success', 'Category berhasil dihapus.', [], route('coe::category'));
        }
    }

    public function cancelDelete()
    {
        $this->reset(['delete_id']);
    }

    public function render()
    {
        if (Auth::user()->hasPermissionTo('COE - Manage Category')) {
            return view('coe::livewire.category', [
                'CalenderCategory' => CalenderCategory::paginate($this->limit),
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
