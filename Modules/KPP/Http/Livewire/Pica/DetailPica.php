<?php

namespace Modules\KPP\Http\Livewire\Pica;

use App\Enums\KPP\ExtractionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Modules\KPP\Entities\KppExtraction;
use Modules\KPP\Entities\KppExtractionTransaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DetailPica extends Component
{
    use LivewireAlert;
    
    public $activities = [];
    public $extraction = [];

    public $comment = '';

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount(Request $request)
    {
        $this->activities = KppExtractionTransaction::all();
        $this->extraction = KppExtraction::find($request->id);
    }

    public function render()
    {
        return view('kpp::livewire.pica.detail')->extends('kpp::layouts.no-header');
    }

    public function submitReviewer()
    {
        try {
            DB::beginTransaction();

            $this->extraction->update([
                'status' => ExtractionStatus::InReview()->value,
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect(route('kpp::pica.index'));
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

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }
}
