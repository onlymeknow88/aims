<?php

namespace Modules\Audit\Http\Livewire\MasterData\Manday;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Audit\Entities\AuditManDays;
use Modules\Audit\Entities\AuditManDaysRiskSeverity;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public string $search = "";
    public  int $startNumber;
    // public $page = 1;
 
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function getListsProperty(): LengthAwarePaginator 
    //  |\|\LaravelIdea\Helper\Modules\Audit\Entities\_IH_AuditSmkp_C
    {
        $perPage = 10;

        $this->startNumber = ($this->page-1) * $perPage;
        // dd($this->startNumber);
        $auditMandays = AuditManDays::with('severities')->paginate($perPage);
       
        return $auditMandays;
    }

    public function render()
    {
       
        if (\Auth::user()->hasPermissionTo('Audit - Master Mandays')) {
            return  view('audit::livewire.master-data.manday.index',[
                ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }

        
    }

    public function delete($id){

        $auditMandays = AuditMandays::find($id);
        
        if (!$auditMandays) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'danger',
                'text' => 'data tidak ditemukan'
            ]);
            $this->dispatchBrowserEvent('closeModal');
            return;
        }


        AuditManDaysRiskSeverity::where("audit_man_days_id",$id)->delete();
        $auditMandays->delete();

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Berhasil menghapus data'
        ]);
        $this->dispatchBrowserEvent('closeModal');

       
    }
}
