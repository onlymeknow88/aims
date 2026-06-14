<?php

namespace Modules\KPP\Http\Livewire\Extraction\Checking;

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
        return view('kpp::livewire.extraction.checking.detail')->extends('kpp::layouts.no-header');
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

    public function close($status)
    {
        try {
            DB::beginTransaction();

            $this->extraction->update([
                'status' => ExtractionStatus::$status()->value
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

    public function returnWithComment()
    {
        try {
            DB::beginTransaction();
            $this->extraction->update([
                'status' => ExtractionStatus::UnderRevision()->value,
                'comment' => $this->comment
            ]);

            $transaction = KppExtractionTransaction::where('extraction_id', $this->extraction->id)->first();

            if (!$transaction) {
                KppExtractionTransaction::create([
                    'extraction_id' => $this->extraction->id
                ]);
            }

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

    public function tidakPatuh()
    {
        try {
            DB::beginTransaction();
            $this->extraction->update([
                'status' => ExtractionStatus::NotComply()->value,
                'extraction_issue_flag' => 1,
                'comment' => $this->comment
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
}
