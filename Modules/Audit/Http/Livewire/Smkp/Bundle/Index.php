<?php

namespace Modules\Audit\Http\Livewire\Smkp\Bundle;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Enums\AuditCategory;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public string $search = "";
    public  int $startNumber;
    public string $audit_category = AuditCategory::SMKP;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $audits = [];

    protected $listeners = [];
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function getListsProperty() //: LengthAwarePaginator 
    // | array |\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\Modules\Audit\Entities\_IH_AuditSmkp_C
    {
        $perPage = 12;
        
        $this->startNumber = ($this->page-1) * $perPage;

        $audits =  Audit::with(['company','auditors.role','criteria_module.criteria.sub_criteria.non_confirmance','criteria_module.criteria.sub_criteria.children.non_confirmance'])
            ->where("audit_category",$this->audit_category)
            ->get();
        
    
       
        foreach ($audits as $key => $audit) {
            $critical = 0;
            $mayor = 0;
            $minor = 0;
            $target_point = 0;
            $total_point = 0;
            $criteria = $audit->criteria_module->criteria;
            
            foreach ($criteria as $criterionKey => $criterion) {
                $subCriteria = $criterion->sub_criteria;
                foreach ($subCriteria as $subKey => $subCriterion) {
                    if($subCriterion->has_point == 1){
                        $target_point += $subCriterion->target_point;
                        $total_point += $subCriterion->point;
                    }

                    if($subCriterion->non_confirmance){
                        $nonConfirmance = $subCriterion->non_confirmance;
                        if($nonConfirmance->category == 'critical'){
                            $critical++;
                        }elseif($nonConfirmance->category == 'mayor'){
                            $mayor++;
                        }elseif($nonConfirmance->category == 'minor'){
                            $minor++;
                        }
                    }

                    if($subCriterion->children){
                        $childs = $subCriterion->children;
                        foreach ($childs as $childKey => $child) {
                            if($child->has_point == 1){
                                $target_point += $child->target_point;
                                $total_point += $child->point;
                            }
                            if($child->non_confirmance){
                                $nonConfirmance = $child->non_confirmance;
                                if($nonConfirmance->category == 'critical'){
                                    $critical++;
                                }elseif($nonConfirmance->category == 'mayor'){
                                    $mayor++;
                                }elseif($nonConfirmance->category == 'minor'){
                                    $minor++;
                                }
                            }
                        }
                    }
                }
            }
            $audits[$key]->critical = $critical;
            $audits[$key]->mayor = $mayor;
            $audits[$key]->minor = $minor;
            $audits[$key]->percent = $target_point > 0 ? round((($total_point/$target_point)*100),2)." %" : "0 %";
            
        }
        
        return $audits;
    }

    public function onSelectedItem($id)
    {

        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
            
            $this->countSelected = 1;
        }
    }

    public function activedInfo()
    {
        $this->info = !$this->info;
    }

    
    public function bulkDelete()
    {
        DB::beginTransaction();
        try {
            $ids = $this->itemSelected;
            $ids = array_values($ids);
            foreach ($ids as $id) {
                $data = Audit::find($id);
                if ($data) {
                    $data->delete();
                }
            }
            DB::commit();
            $this->itemSelected = [];
            $this->countSelected = 0;
            $this->resetPage();
            $this->emit('bulkDeleteSuccess', trans('global.success_delete_audit'));
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('bulkDeleteError', $th->getMessage());
        }
    }
    
    public function render(): Factory |View|Application
    {
        return  view('audit::livewire.smkp.bundle.index',[
        ])->layout('audit::livewire.layouts.app');
    }

     /**
     * Function to send all type notification in this controller
     */
    private function notif($type, $message)
    {
        $icon = 'success';
        $title = trans('global.success');
        if ($type == 'error') {
            $icon = 'error';
            $title = trans('global.error');
        }

        return $this->dispatchBrowserEvent('swal', [
            'title' => $title,
            'icon' => $icon,
            'text' => $message,
        ]);
    }
}
