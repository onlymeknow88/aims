<?php

namespace Modules\KPP\Http\Livewire\Obedience;

use App\Enums\KPP\ExtractionStatus;
use App\Enums\KPP\ObedienceStatus;
use App\Mail\KPP\CompanyObedienceCreated;
use App\Mail\KPP\NotComplyExtraction;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Modules\KPP\Entities\KppExtraction;
use Modules\KPP\Entities\KppExtractionTransaction;
use Modules\KPP\Entities\KppObedience;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DetailObedience extends Component
{
    use LivewireAlert;

	public $obedience = [];
	public $deleteId;

	public function mount(Request $request)
    {
        $this->obedience = KppObedience::find($request->id);
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
        	KppExtraction::find($this->deleteId)->delete();
        	DB::commit();

        	$this->flash('success','Berhasil menghapus data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect(route('kpp::obediences.detail', ['id' => $this->obedience->id]));
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

    public function submit()
    {
        try {
            DB::beginTransaction();

            $draftExtractions = $this->obedience->extractions->where('status', ExtractionStatus::Draft()->value);
	    	foreach($draftExtractions as $extraction) {
	    		if (count($extraction->files) > 0) {
					$extraction->update(['status' => ExtractionStatus::Checking()->value]);
				} else {
					$extraction->update([
                        'status' => ExtractionStatus::NotComply()->value,
                        'comment' => 'Tidak ada attachment',
                        'extraction_issue_flag' => 1
                    ]);

                    Mail::to($extraction->responsibleUser->email)->send(new NotComplyExtraction($extraction));
				}
	    	}

	        $this->obedience->update([
	        	'status' => ObedienceStatus::Submitted()->value
	        ]);

	    	DB::commit();

            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect(route('kpp::obediences.detail', ['id' => $this->obedience->id]));
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

    public function render()
    {
        return view('kpp::livewire.obedience.detail-obedience')->extends('kpp::layouts.no-header');
    }
}
