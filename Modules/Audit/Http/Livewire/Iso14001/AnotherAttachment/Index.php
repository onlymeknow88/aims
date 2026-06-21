<?php

namespace Modules\Audit\Http\Livewire\Iso14001\AnotherAttachment;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditAnotherAttachment;
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
        $this->audit = Audit::with('another_attachments')->find($id);
        $this->documents = $this->audit->another_attachments;

    }


    public function saveDoc()
    {
        $this->validate();
        try {
            \DB::beginTransaction();
            $image = $this->doc->store('storage/public/iso14001/' . $this->audit->id . "/another-attachment");
                $tempPath = $this->doc->getRealPath();
                $blobResult = uploadToBlobStorage($this->doc->getClientOriginalName(), $tempPath, 'audit/' . $this->audit->id . '/attachment');
            $this->audit->another_attachments()->create([
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
        $this->reset('doc');
    }

    public function delete($audit_id,$notice_id){

        try{
            $attachment = AuditAnotherAttachment::find($notice_id);
            
            
            if(Storage::exists($attachment->url)){
                Storage::delete($attachment->url);
                $attachment->delete();
                
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
        if (\Auth::user()->hasPermissionTo('Audit - Detail SMKP Another Attachment')) {
            return view('audit::livewire.upload-document.index',
                [
                    'category'=>'iso14001',
                    'title'=>'lampiran lainnya',
                    'module'=>'another-attachment'
                ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }
        
    }
}
