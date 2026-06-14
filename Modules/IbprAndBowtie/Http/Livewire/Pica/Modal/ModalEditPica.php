<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Pica\Modal;

use App\Enums\Pica\PicaStatus;
use App\Enums\PicaSource;
use App\Models\IbprBowty\Pica;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

use Livewire\WithFileUploads;
use Modules\Pica\Entities\PicaDocument;

class ModalEditPica extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'click_edit_pica' => 'handle_click_edit_pica',
        'clear_state_pica' => 'clear_state_pica',
    ];

    public $id_detail;
    public $pica;

    public $plan;
    public $review_date;
    public $target_date;
    public $status;

    public $tmp = [];
    public $attachment;
    public $attachment_name;

    public function mount() {
        // $this->id_detail = $id_detail;
        // $this->pica = Pica::find($id_detail);
    }

    public function clear_state_pica() {
        $this->id_detail = null;
        $this->pica = null;
    }


    public function handle_click_edit_pica($id_detail) {
        $this->id_detail = $id_detail;
        $this->pica = Pica::find($id_detail);

        $this->plan = $this->pica->plan;
        $this->review_date = $this->pica->review_date;
        $this->target_date = $this->pica->target_date;
        $this->attachment = $this->pica->attachment;
        $this->attachment_name = $this->pica->attachment_name;
        $this->status = $this->pica->status;

        $this->emit('openModalPica');
    }

    public function submit_edit(){
        DB::beginTransaction();
        try {

            $directory = 'public/document_systems';
            $review_date = null;
            $target_date = null;

            if (!File::exists(storage_path('app/' . $directory))) {
                Storage::makeDirectory($directory);
            }

            $pica = Pica::with([
                'form',
                'form.ibpr',
                'form.risks',
                'formIadl',
                'formIadl.iadl',
                'formIadl.risks'
            ])->find($this->id_detail);

            if ($this->attachment && !is_string($this->attachment)) {
                $attachment = $this->attachment->storeAs($directory, $this->attachment->getClientOriginalName());
                $attachment_name =  $this->attachment->getClientOriginalName();
            } else {
                $attachment = $this->attachment;
                $attachment_name = $this->attachment_name;
            }

            if ($this->review_date) {
                $review_date = Carbon::parse($this->review_date)->format('Y-m-d');
            }

            if ($this->target_date) {
                $target_date = Carbon::parse($this->target_date)->format('Y-m-d');
            }

            $pica->update([
                'review_date' => $review_date,
                'target_date' => $target_date,
                'plan' => $this->plan,
                'attachment' => $attachment,
                'attachment_name' => $attachment_name,
                'status' => $this->status,
            ]);


            if($this->status === 'Open') {
                $picaDocument = PicaDocument::create([
                    'source' => 'IBPR',
                    'type' => $pica->form ? 'IBPR' : 'IADL',
                    'date' => Carbon::parse($review_date)->format('Y-m-d'),
                    'ccow_id' => $pica->form?->ibpr->ccow->id ?? $pica->formIadl?->iadl->ccow->id,
                    'company_id' => $pica->form?->ibpr->ccow->id ?? $pica->formIadl?->iadl->ccow->id,
                    'section_id' => $pica->form?->ibpr->section_id ?? $pica->formIadl?->iadl->section_id,
                    'location_id' => null,
                    'location_detail' => null,
                    'company_detail' => null,
                    'pja_id' => $pica->form?->ibpr->pja->id ?? $pica->formIadl?->iadl->pja->id,
                    'pjo_id' => $pica->form?->ibpr->pjo->id ?? $pica->formIadl?->iadl->pjo->id,
                    'auditor' => null,
                    'non_compliance' => null,
                    'non_compliance_root_cause' => null,
                    'corrective_action' => $this->plan,
                    'target_settlement_date' => Carbon::parse($target_date)->format('Y-m-d'),
                    'settlement_date' => Carbon::parse($target_date)->format('Y-m-d'),
                    'remarks' => null,
                    'status' => PicaStatus::Open
                ]);

                \Modules\Pica\Entities\Pica::create([
                    'source' => 'IBPR',
                    'source_id' => $this->id_detail,
                    'picaable_id' => $picaDocument->id,
                    'picaable_type' => FieldLeadershipRisk::class,
                ]);
            }

            DB::commit();

            $this->emit('closeModalPica');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
        }
    }

    public function render()
    {

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.pica.modal.modal-edit-pica')->layout('ibprandbowtie::layouts.ibpr-and-bowtie');
    }
}
