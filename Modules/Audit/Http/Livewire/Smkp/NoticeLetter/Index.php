<?php

namespace Modules\Audit\Http\Livewire\Smkp\NoticeLetter;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditNoticeLetter;
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
        $this->audit = Audit::with('notice_letters')->find($id);
        $this->documents = $this->audit->notice_letters;

    }


    public function saveDoc()
    {
        $this->validate();
        if($this->doc){
            try {
                \DB::beginTransaction();
                $image = $this->doc->store('storage/public/smkp/' . $this->audit->id . "/notice-letter");
                $tempPath = $this->doc->getRealPath();
                $blobResult = uploadToBlobStorage($this->doc->getClientOriginalName(), $tempPath, 'audit/' . $this->audit->id . '/attachment');
                $this->audit->notice_letters()->create([
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
            $notice_letter = AuditNoticeLetter::find($notice_id);
            
            
            if(Storage::exists($notice_letter->url)){
                Storage::delete($notice_letter->url);
                $notice_letter->delete();
                
            }
            // session()->flash('success',"Notice Letter Deleted Successfully!!");
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Dokumen telah dihapus'
            ]);
            $this->getAudit($this->audit->id);
            
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong!!");
        }

        // return redirect()->route('audit::smkp.detail.notice-letter.index',['id'=>$audit_id]);
     
    }

    public function render()
    {
        if (\Auth::user()->hasPermissionTo('Audit - Detail SMKP Notice Letter')) {
            return view('audit::livewire.upload-document.index',
                [
                    "category"=>"smkp",
                    "title"=>"surat pemberitahuan audit",
                    "module"=>'notice-letter'
                ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }
        
    }

}
