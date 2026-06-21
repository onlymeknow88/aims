<?php

namespace Modules\Audit\Http\Livewire\Smkp\Glossary;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditNoticeLetter;
use Modules\Audit\Enums\SubBundleStatusEnum;
use Modules\Audit\Entities\AuditGlossary;
use Storage;

class Index extends Component
{
    use WithFileUploads;

    public  Audit $audit;
    public  $documents = [];
    public  $doc;
    public  $document_name;
    private $audit_category = \Modules\Audit\Enums\AuditCategory::SMKP;

    protected $rules = [
        'doc.*' => 'file|max:4096',
        'document_name' => 'required',
    ];

    public function mount(): void
    {
        $this->getDocuments();
    }

    protected function getDocuments()
    {
        $this->documents = AuditGlossary::where(['audit_category'=>$this->audit_category])->get();
        // $this->documents = $this->audit->notice_letters;
        // dd($this->documents);

    }


    public function saveDoc()
    {
        $this->validate();
        if($this->doc){
            try {
                \DB::beginTransaction();
                    $url = $this->doc->store('storage/public/'.strtolower($this->audit_category)."/glossary");
                    AuditGlossary::create([
                        'audit_category'=>$this->audit_category,
                        'document_name'=>$this->document_name,
                        'url'=>$url,
                        'blob_url' => $blobResult['fileBlobUrl'] ?? null,
                        'blob_response' => isset($blobResult['blobResponse']) ? json_encode($blobResult['blobResponse']) : null,
                    ]);
                \DB::commit();
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Berhasil',
                    'icon' => 'success',
                    'text' => 'Dokumen telah disimpan'
                ]);
                // $this->getAudit($this->audit->id);
            } catch (\Exception $exception) {
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Whoops',
                    'icon' => 'error',
                    'text' => $exception->getMessage()
                ]);
            }
        }
        $this->reset(['doc','document_name']);
    }

    public function delete($id){

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
        
        // if (\Auth::user()->hasPermissionTo('Audit - Detail SMKP Notice Letter')) {
            return view('audit::livewire.glossary.index',
                [
                    "category"=>"smkp",
                    "title"=>"surat pemberitahuan audit",
                    "module"=>'notice-letter'
                ])->layout('audit::livewire.layouts.app');
        // } else {
        //     return abort(404);
        // }
        
    }

}
