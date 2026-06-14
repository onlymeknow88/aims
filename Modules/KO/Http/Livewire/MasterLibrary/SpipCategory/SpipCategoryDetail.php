<?php

namespace Modules\KO\Http\Livewire\MasterLibrary\SpipCategory;

use Livewire\Component;
use Modules\KO\Entities\KoBrand;
use Modules\KO\Entities\KoProposal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\KO\Entities\KoSpipCategory;
use Modules\KO\Entities\KoSpipUnit;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SpipCategoryDetail extends Component
{
    use LivewireAlert;
    
    public $category = [];
    public $brands = [];
    public $deleteId;

    public $name;

    public function mount($id): void
    {
        $this->category = KoSpipCategory::find($id);
        $this->brands = KoBrand::where('ko_spip_category_id', $id)->get();
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
        $this->dispatchBrowserEvent('openModal');
    }

    public function delete()
    {
        try {
            DB::beginTransaction();
            KoBrand::find($this->deleteId)->delete();
            DB::commit();

            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('ko::master-library.spip-category.show', $this->category->id);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function store()
    {
        try {
            DB::beginTransaction();

            KoBrand::create([
                'ko_spip_category_id' => $this->category->id,
                'name' => $this->name
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('ko::master-library.spip-category.show', $this->category->id);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function render()
    {
        return view('ko::livewire.master-library.spip-category.spip-category-detail')->extends('ko::layouts.no-header');
    }
}
