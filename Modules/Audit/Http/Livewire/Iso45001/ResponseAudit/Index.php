<?php

namespace Modules\Audit\Http\Livewire\Iso45001\ResponseAudit;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditResponseAudit;
use Modules\Audit\Enums\SubBundleStatusEnum;
use Storage;

class Index extends Component
{
    use WithFileUploads;

    public Audit $audit;
    public $documents = [];
    public $doc;
    protected $rules = [
        'doc.*' => 'file|max:4096'
    ];

    public function mount($id): void
    {
        $this->getAudit($id);
    }

    protected function getAudit($id)
    {
        $this->audit = Audit::with('response_audits')->find($id);
        $this->documents = $this->audit->response_audits;

    }


    public function saveDoc()
    {
        $this->validate();
        if($this->doc){
            try {
                \DB::beginTransaction();
                $image = $this->doc->store('storage/public/Iso45001/' . $this->audit->id . "/response_audit");
                $tempPath = $this->doc->getRealPath();
                $blobResult = uploadToBlobStorage($this->doc->getClientOriginalName(), $tempPath, 'audit/' . $this->audit->id . '/attachment');
                $this->audit->response_audits()->create([
                    'original_name'=>$this->doc->getClientOriginalName(),'url' => $image, 'status' => SubBundleStatusEnum::SUBMITTED,
                    'blob_url' => $blobResult['fileBlobUrl'] ?? null,
                    'blob_response' => isset($blobResult['blobResponse']) ? json_encode($blobResult['blobResponse']) : null,
                ]);
                \DB::commit();

                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Berhasil',
                    'icon' => 'success',
                    'text' => 'Dokumen telah disimpan'
                ]);
                $this->getAudit($this->audit->id);
            } catch (\Exception $exception) {
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Whoops',
                    'icon' => 'error',
                    'text' => $exception->getMessage()
                ]);
            }
        }
        $this->reset('doc');
    }

    public function delete($audit_id,$notice_id){

        try{
            $response_audit = AuditResponseAudit::find($notice_id);
            
            
            if(Storage::exists($response_audit->url)){
                Storage::delete($response_audit->url);
                $response_audit->delete();
                
            }
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Dokumen telah dihapus'
            ]);
            $this->getAudit($this->audit->id);
            
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong!!");
        }
    }

    public function render()
    {
        if (\Auth::user()->hasPermissionTo('Audit - Detail SMKP Audit Response')) {
            return view('audit::livewire.upload-document.index',
                [
                    'category'=>'iso45001',
                    'title'=>'response pelaksanaan audit',
                    'module'=>'response-audit'
                ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }
        
    }
}
