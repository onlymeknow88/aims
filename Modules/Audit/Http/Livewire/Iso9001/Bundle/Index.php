<?php

namespace Modules\Audit\Http\Livewire\Iso9001\Bundle;

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
    public int $startNumber;
    public string $audit_category = AuditCategory::ISO9001;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $audits = [];

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
            $audits[$key]->percent = round((($total_point/$target_point)*100),2).' %';
            
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

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('confirmBulkDelete');
    }
    
    public function submitBulkDelete(){
        DB::beginTransaction();
        try {
            $ids = $this->itemSelected;
            $ids = array_values($ids);
            for ($a = 0; $a < count($ids); $a++) {
                $data = Audit::find($ids[$a]);
                $data->delete();
            }

            // reset selected rows
            DB::commit();
            $this->itemSelected = [];
            $this->countSelected = 0;
            $this->resetPage();

            return $this->notif('success', trans('global.success_delete_audit'));
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->notif('error', $th->getMessage());
        }
       
        
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
    
    
    public function render(): Factory |View|Application
    {
        return  view('audit::livewire.iso9001.bundle.index',[])->layout('audit::livewire.layouts.app');
    }
}
