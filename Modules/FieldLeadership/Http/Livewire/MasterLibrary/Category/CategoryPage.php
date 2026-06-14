<?php

namespace Modules\FieldLeadership\Http\Livewire\MasterLibrary\Category;

use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CategoryPage extends Component
{
    use LivewireAlert;

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

            $this->alert('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            $this->closeModal();

            $this->emitTo('field-leadership.master-library.category.partials.table-maker', 'refreshComponent');
        } else {

            FieldLeadershipCategory::create([
                'name' => $this->title
            ]);


            $this->closeModal();

            $this->emitTo('field-leadership.master-library.category.partials.table-maker', 'refreshComponent');

            $this->alert('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('fieldleadership::livewire.master-library.category.category-page')->layout('fieldleadership::layouts.app');
    }
}
