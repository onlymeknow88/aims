<?php

namespace Modules\Audit\Http\Livewire\MasterData\Manday;

use Livewire\Component;
use Livewire\Redirector;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Modules\Audit\Entities\AuditManDays;
use Modules\Audit\Entities\AuditManDaysRiskSeverity;


class Edit extends Component{

    public string $mandaysId = "";
    public string $minimum_people = "";
    public string $maximum_people = "";
    public string $high_risk = "";
    public string $medium_risk = "";
    public string $low_risk = "";


    protected $rules = [
        'minimum_people' => 'required',
        'maximum_people' => 'required',
        'high_risk' => 'required',
        'medium_risk'=>'required',
        'low_risk'=>'required',
    ];


    public function store(): bool |\Illuminate\Http\RedirectResponse|Redirector
    {
        $this->validate();

        try{
            \DB::beginTransaction();

            $auditMandays = AuditMandays::find($this->mandaysId);
            $auditMandays->update([
                "minimum_people" => $this->minimum_people,
                "maximum_people" => $this->maximum_people
            ]);

            AuditManDaysRiskSeverity::where("audit_man_days_id",$this->mandaysId)->delete();

            AuditManDaysRiskSeverity::create([
                "audit_man_days_id"=>$auditMandays->id,
                "audit_risk_severity_id"=>1,
                "value"=>$this->high_risk,
            ]);

            AuditManDaysRiskSeverity::create([
                "audit_man_days_id"=>$auditMandays->id,
                "audit_risk_severity_id"=>2,
                "value"=>$this->medium_risk,
            ]);

            AuditManDaysRiskSeverity::create([
                "audit_man_days_id"=>$auditMandays->id,
                "audit_risk_severity_id"=>3,
                "value"=>$this->low_risk,
            ]);


            \DB::commit();
            \Session::flash('success', 'Berhasil mengupdate data');
            return redirect()->route('audit::smkp.mandays.index', ['id' => $auditMandays->id]);
        }catch(\Exception $exception){
             
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

    public function mount($id)
    {

        $auditMandays = AuditManDays::with('severities')->where('id','=',$id)->first();
        $this->mandaysId = $id;
        $this->minimum_people = $auditMandays->minimum_people;
        $this->maximum_people = $auditMandays->maximum_people;
        $this->high_risk = $auditMandays->severities[0]->pivot->value;
        $this->medium_risk = $auditMandays->severities[1]->pivot->value;
        $this->low_risk = $auditMandays->severities[2]->pivot->value;
        
    }

    
    public function render(): Factory |View|Application
    {
        return view('audit::livewire.master-data.manday.edit')->layout('audit::livewire.layouts.app');
    }
}