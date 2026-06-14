<?php

namespace Modules\Audit\Http\Livewire\Iso9001\ClosingAttendance;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditClosingAttendance;
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
        $this->audit = Audit::with('closing_attendances')->find($id);
        $this->documents = $this->audit->closing_attendances;

    }


    public function saveDoc()
    {
        $this->validate();
        if($this->doc) {
            try {
                \DB::beginTransaction();
                $image = $this->doc->store('storage/public/iso9001/' . $this->audit->id . "/closing-attendance");

                $this->audit->closing_attendances()->create(['original_name'=>$this->doc->getClientOriginalName(),'url' => $image, 'status' => SubBundleStatusEnum::SUBMITTED]);
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
            $closing_attendance = AuditClosingAttendance::find($notice_id);
            
            
            if(Storage::exists($closing_attendance->url)){
                Storage::delete($closing_attendance->url);
                $closing_attendance->delete();
                
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
        if (\Auth::user()->hasPermissionTo('Audit - Detail SMKP Closing Attendance')) {
            return view('audit::livewire.upload-document.index',
                [
                    'category'=>'iso9001',
                    'title'=>'daftar hadir pertemuan penutupan audit',
                    'module'=>'closing-attendance'
                ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }
        
        
    }
}
