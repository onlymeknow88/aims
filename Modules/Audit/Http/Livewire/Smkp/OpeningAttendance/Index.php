<?php

namespace Modules\Audit\Http\Livewire\Smkp\OpeningAttendance;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditOpeningAttendance;
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
        $this->audit = Audit::with('opening_attendances')->find($id);
        $this->documents = $this->audit->opening_attendances;
    }


    public function saveDoc()
    {
        $this->validate();
        if($this->doc){
            try {
                \DB::beginTransaction();
                $image = $this->doc->store('storage/public/smkp/' . $this->audit->id . "/opening-attendance");

                $this->audit->opening_attendances()->create(['original_name'=>$this->doc->getClientOriginalName(),'url' => $image, 'status' => SubBundleStatusEnum::SUBMITTED]);
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


    public function delete($audit_id,$id){

        try{
            $opening_attendance = AuditOpeningAttendance::find($id);
            
           
            if(Storage::exists($opening_attendance->url)){
                Storage::delete($opening_attendance->url);
                $opening_attendance->delete();
                
            }
            // session()->flash('success',"Dokumen telah dihapus");
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Dokumen telah dihapus'
            ]);
            $this->getAudit($this->audit->id);
            
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong!!");
        }

        // return redirect()->route('audit::smkp.detail.opening-attendance.index',['id'=>$audit_id]);
     
    }


    public function render()
    {
        if (\Auth::user()->hasPermissionTo('Audit - Detail SMKP Opening Attendance')) {
            return view('audit::livewire.upload-document.index',
                [
                    'category'=>'smkp',
                    'title'=>'daftar hadir pertemuan pembukaan audit',
                    'module'=>'opening-attendance'
                ]
                )->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }
        
    }
}
