<?php

namespace Modules\KO\Http\Livewire\MasterLibrary\Unit;

use Livewire\Component;
use Modules\KO\Entities\KoProposal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\KO\Entities\KoSpipCategory;
use Modules\KO\Entities\KoSpipUnit;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UnitDetail extends Component
{
    use LivewireAlert;
    
    public $unit = [];
    public $attachment_fields = [];

    public $number;
    public $question;

    public function mount($id): void
    {
        $this->unit = KoSpipUnit::find($id);
        $this->attachment_fields = $this->unit->attachment_field;
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function saveAttachmentField()
    {
        try {
            DB::beginTransaction();

            $this->unit->update([
                'attachment_field' => $this->attachment_fields
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('ko::master-library.spip-unit.show', $this->unit->id);
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

    public function storeCommisioningField()
    {
        try {
            DB::beginTransaction();

            $this->unit->commisioningFields()->create([
                'number' => $this->number,
                'question' => $this->question
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('ko::master-library.spip-unit.show', $this->unit->id);
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
        return view('ko::livewire.master-library.spip-unit.spip-unit-detail')->extends('ko::layouts.no-header');
    }
}
