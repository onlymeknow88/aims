<?php

namespace App\Http\Livewire\FieldLeadership\MasterLibrary\Category;

use App\Models\FieldLeadershipCategory;
use Livewire\Component;

class CategoryPage extends Component
{
    public $idCategory;
    public $title;
    public $edit = false;

    protected $rules = [
        'title' => 'required'
    ];

    public function edited()
    {
        $this->edit = true;
    }

    public function saved()
    {
        $this->validate();
        if ($this->idCategory) {
            $category = FieldLeadershipCategory::find($this->idCategory);
            $category->update([
                'name' => $this->title
            ]);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text'  => 'Data berhasil di update'
            ]);

            $this->closeModal();

            $this->emitTo('field-leadership.master-library.category.partials.table-maker', 'refreshComponent');
        } else {

            FieldLeadershipCategory::create([
                'name' => $this->title
            ]);


            $this->closeModal();

            $this->emitTo('field-leadership.master-library.category.partials.table-maker', 'refreshComponent');

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text'  => 'Data berhasil di simpan'
            ]);
        }
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('livewire.field-leadership.master-library.category.category-page')->layout('livewire.field-leadership.layouts.app');
    }
}
