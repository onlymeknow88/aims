<?php

namespace Modules\KPP\Http\Livewire\Extraction\InReview;

use App\Enums\KPP\ExtractionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Modules\KPP\Entities\KppExtraction;
use Modules\KPP\Entities\KppExtractionTransaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DetailExtraction extends Component
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
        return view('kpp::livewire.extraction.in-review.detail')->extends('kpp::layouts.no-header');
    }

    public function submitReviewer()
    {
        try {
            DB::beginTransaction();

            switch ($this->extraction->status) {
                case ExtractionStatus::Checking():
                    $redirect = 'kpp::extractions.checking';
                    break;
                case ExtractionStatus::UnderRevision():
                    $redirect = 'kpp::pica.index';
                    break;
                default:
                    $redirect = 'kpp::extractions.index';
            }

            $this->extraction->update([
                'status' => ExtractionStatus::InReview()->value,
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect(route($redirect));
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

    public function comply()
    {
        try {
            DB::beginTransaction();

            $this->extraction->update([
                'status' => ExtractionStatus::Complied()->value
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect(route('kpp::extractions.in-review'));
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

    public function notApplicable()
    {
        try {
            DB::beginTransaction();

            $this->extraction->update([
                'status' => ExtractionStatus::NotApplicable()->value
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect(route('kpp::extractions.in-review'));
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

    public function notComply()
    {
        try {
            DB::beginTransaction();
            $this->extraction->update([
                'status' => ExtractionStatus::NotComply()->value,
                'comment' => $this->comment,
                'extraction_issue_flag' => 1
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect(route('kpp::extractions.in-review'));
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
