<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Iadl\FormIbpr;

use App\Models\IbprBowty\Iadl;
use App\Models\IbprBowty\IadlForm;
use App\Models\IbprBowty\IbprMasterHirarki;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class FormListIadl extends Component
{

    protected $listeners = [
        'event_formula_level_of_risk' => 'formula_level_of_risk',
        'event_formula_level_of_risk_residual' => 'formula_level_of_risk_residual',
        'event_unset_index_edit' => 'unset_index_edit',
        'event_ccow_on_change' => 'ccow_on_change',
    ];

    public $forms = [];
    public $route;
    public $iadl;
    public $iadl_id;
    public $title;
    public $dataTables = [];
    public $itemSelected = [];
    public $columns = [];
    public $availableCompany = [];
    public $availableDepartment = [];
    public $availablePics = [];
    public $availableModules = [];
    public $countSelected = 0;
    public $info = false;

    public $readonly = false;
    public $activity;
    public $sub_activity;
    public $kondition;
    public $safety;
    public $incident_risk;
    public $safety_opportunity;
    public $relevant_legislation;
    public $preliminary_consequence_lh;
    public $preliminary_frequence;
    public $preliminary_level_of_risk;
    public $preliminary_main_risk;
    public $modal_of_current;
    public $effective_control;
    public $residual_consequence_lh;
    public $residual_frequence;
    public $residual_level_of_risk;
    public $residual_main_risk;
    public $follow_risk;
    public $ibprHirarki;

    public $index_edit = null;
    public $id_edit = null;

    public $preliminary_level_of_risk_label;

    public function mount($id, Request $request) {
        $this->route = $request->session()->get('route');
        $this->iadl_id = $id;
        $this->iadl = Iadl::find($id);

        $this->ibprHirarki = IbprMasterHirarki::all();
        $this->columns = [
            trans('Proses') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Aktifitas') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'sub_activity_search',
                'sortable' => true,
            ],
            trans('Aspek Lingkungan Hidup') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Dampak Lingkungan Hidup') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Peluang LH ') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Kondisi Aspek ') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Peraturan Relevan') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Keparahan (LH)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Kemungkinan') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Tingkat Rasio') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Aspek Significan ') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Hirarki Kendali') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Detail Pengendalian') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
        ];
    }


    public function onSelectedItem($id)
    {
        if(in_array($id, $this->itemSelected)){
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            $this->countSelected--;
        }else{
            $this->itemSelected[] = $id;
             $this->countSelected++;
        }

    }

    public function confirmDelete()
    {
        $this->dispatchBrowserEvent('confirm-delete');
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function render()
    {
        $this->forms = IadlForm::select()->where('iadl_id', $this->iadl_id)->get();
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.iadl.iadl-form.list-form')->extends('ibprandbowtie::layouts.no-header');
    }

    public function submitDelete()
    {
        DB::beginTransaction();
        try {
            $ids = array_values($this->itemSelected);
            for ($a = 0; $a < count($ids); $a++) {
                $data = IadlForm::find($ids[$a]);
                $data->delete();
            }
            $this->itemSelected = [];
            $this->countSelected = 0;
            DB::commit();

            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Success',
                'icon' => 'success',
                'text' => trans('global.success_delete_document'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Failed',
                'icon' => 'error',
                'text' => env('APP_ENV') == 'local' ? $th->getMessage() . ' ' . $th->getLine() : 'Failed to delete document',
            ]);
        }
    }


    public function push_form() {
        $rules = [
            'activity' => 'required',
            'sub_activity' => 'required',
            'kondition' => 'required',
            'safety' => 'required',
            'incident_risk' => 'required',
            'relevant_legislation' => 'required',
            'preliminary_consequence_lh' => 'required',
            'preliminary_frequence' => 'required',
            'preliminary_level_of_risk' => 'required',
            'preliminary_main_risk' => 'required',
            'effective_control' => 'required',
        ];

        $messages = [
            'activity' => 'required',
            'sub_activity' => 'required',
            'kondition' => 'required',
            'safety' => 'required',
            'incident_risk' => 'required',
            'relevant_legislation' => 'required',
            'preliminary_consequence_lh' => 'required',
            'preliminary_frequence' => 'required',
            'preliminary_level_of_risk' => 'required',
            'preliminary_main_risk' => 'required',
            'effective_control' => 'required',
        ];

        $this->validate($rules, $messages);

        $object = [
            'iadl_id' => $this->iadl_id,
            'activity' => $this->activity,
            'sub_activity' => $this->sub_activity,
            'kondition' => $this->kondition,
            'safety' => $this->safety,
            'incident_risk' => $this->incident_risk,
            'safety_opportunity' => $this->safety_opportunity,
            'relevant_legislation' => $this->relevant_legislation,
            'preliminary_consequence_lh' => $this->preliminary_consequence_lh,
            'preliminary_frequence' => $this->preliminary_frequence,
            'preliminary_level_of_risk' => $this->preliminary_level_of_risk,
            'preliminary_main_risk' => $this->preliminary_main_risk,
            'modal_of_current' => $this->modal_of_current,
            'effective_control' => $this->effective_control,
            'residual_consequence_lh' => $this->residual_consequence_lh,
            //'residual_frequence' => $this->residual_frequence,
            'residual_level_of_risk' => $this->residual_level_of_risk,
            'residual_main_risk' => $this->residual_main_risk,
            'follow_risk' => $this->follow_risk,
        ];

        if(!is_null($this->id_edit)) {
            $ibpr = IadlForm::find($this->id_edit);
            $ibpr->update($object);
        }else {
            $iadlForm = IadlForm::create($object);

            if ($this->preliminary_level_of_risk === 'H') {
                $iadlForm->pica()->createMany([
                    [
                        'status' => 'OPEN'
                    ]
                ]);
            }
        }

        // Clear the temporary variable
        $this->activity = '';
        $this->sub_activity = '';
        $this->safety = '';
        $this->kondition = '';
        $this->incident_risk = '';
        $this->safety_opportunity = '';
        $this->relevant_legislation = '';
        $this->preliminary_consequence_lh = null;
        $this->preliminary_frequence = null;
        $this->preliminary_level_of_risk = null;
        $this->preliminary_main_risk = null;
        $this->modal_of_current = '';
        $this->effective_control = '';
        $this->residual_consequence_lh = null;
        $this->residual_frequence = null;
        $this->residual_level_of_risk = null;
        $this->residual_main_risk = null;
        $this->follow_risk = '';

        $this->forms = IadlForm::select()->where('iadl_id', $this->iadl_id)->get();
        $this->emit('closeModal');
    }

    public function unset_index_edit(){
        $this->index_edit = null;
        $this->id_edit = null;
    }

    public function open_modal_edit($index){
        $this->index_edit = $index;
        $form_ibpr = $this->forms[$index];

        $this->id_edit = $form_ibpr->id;

        $this->activity = $form_ibpr['activity'];
        $this->sub_activity = $form_ibpr['sub_activity'];
        $this->safety = $form_ibpr['safety'];
        $this->kondition = $form_ibpr['kondition'];
        $this->incident_risk = $form_ibpr['incident_risk'];
        $this->safety_opportunity = $form_ibpr['safety_opportunity'];
        $this->relevant_legislation = $form_ibpr['relevant_legislation'];
        $this->preliminary_consequence_lh = $form_ibpr['preliminary_consequence_lh'];
        $this->preliminary_frequence = $form_ibpr['preliminary_frequence'];
        $this->preliminary_level_of_risk = $form_ibpr['preliminary_level_of_risk'];
        $this->preliminary_main_risk = $form_ibpr['preliminary_main_risk'];
        $this->modal_of_current = $form_ibpr['modal_of_current'];
        $this->effective_control = $form_ibpr['effective_control'];
        $this->residual_consequence_lh = $form_ibpr['residual_consequence_lh'];
        $this->residual_frequence = $form_ibpr['residual_frequence'];
        $this->residual_level_of_risk = $form_ibpr['residual_level_of_risk'];
        $this->residual_main_risk = $form_ibpr['residual_main_risk'];
        $this->follow_risk = $form_ibpr['follow_risk'];

        $this->emit('openModal');
    }

    public function delete_form($index) {
        unset($this->form[$index]);
    }


    public function change_consequences($value, $type) {
        if ($type === 'preliminary_consequence_lh') $this->preliminary_consequence_lh = $value;
        if ($type === 'residual_consequence_lh') $this->residual_consequence_lh = $value;

        $arr_preliminary = [$this->preliminary_consequence_lh];
        $max_preliminary = max($arr_preliminary);

        $arr_residual = [$this->residual_consequence_lh];
        $max_residual = max($arr_residual);

        if ($this->preliminary_frequence !== '' && $max_preliminary) {
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'C';
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($this->preliminary_frequence === 'B' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'B' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'B' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'B' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'B' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($this->preliminary_frequence === 'C' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'C' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'C' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'C' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'C' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($this->preliminary_frequence === 'D' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'D' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'D' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'D' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'D' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'H';

            if ($this->preliminary_frequence === 'H' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'H' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'H' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'H' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'H' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'H';

            if ($this->preliminary_level_of_risk === 'C') $this->preliminary_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
            if ($this->preliminary_level_of_risk === 'H') $this->preliminary_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
            if ($this->preliminary_level_of_risk === 'M') $this->preliminary_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
            if ($this->preliminary_level_of_risk === 'L') $this->preliminary_level_of_risk_label = 'L (Tingkat Risiko Rendah)';
        }


        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk === 'C') {
            $this->preliminary_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk !== 'C') {
            $this->preliminary_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }

        if ($this->residual_level_of_risk !== '' && $max_residual >= 4) {
            $this->residual_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->residual_level_of_risk !== '' && $max_residual < 4) {
            $this->residual_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }

        $this->emit('closeAllToooltip');
        $this->emit('chooseModaelOfCurrent');
    }

    public function formula_level_of_risk($preliminary_frequence){
        $arr_preliminary = [$this->preliminary_consequence_lh];
        $max_preliminary = max($arr_preliminary);

        if ($this->preliminary_frequence !== '' && $max_preliminary) {
            if ($preliminary_frequence === 'A' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'A' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'A' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'A' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'C';
            if ($preliminary_frequence === 'A' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($preliminary_frequence === 'B' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'B' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'B' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'B' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'B' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($preliminary_frequence === 'C' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'C' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'C' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'C' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'C' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($preliminary_frequence === 'D' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'D' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'D' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'D' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'D' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'H';

            if ($preliminary_frequence === 'E' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'E' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'E' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'E' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'E' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'H';


            if ($this->preliminary_level_of_risk === 'C') $this->preliminary_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
            if ($this->preliminary_level_of_risk === 'H') $this->preliminary_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
            if ($this->preliminary_level_of_risk === 'M') $this->preliminary_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
            if ($this->preliminary_level_of_risk === 'L') $this->preliminary_level_of_risk_label = 'L (Tingkat Risiko Rendah)';
        }

        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk === 'C') {
            $this->preliminary_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk !== 'C') {
            $this->preliminary_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }
    }

    public function formula_level_of_risk_residual($residual_frequence){
        $arr_residual = [$this->residual_consequence_lh];
        $max_residual = max($arr_residual);

        if ($this->residual_frequence !== '' && $max_residual) {
            if ($residual_frequence === 'A' && $max_residual === 1) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'A' && $max_residual === 2) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'A' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'A' && $max_residual === 4) $this->residual_level_of_risk = 'C';
            if ($residual_frequence === 'A' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($residual_frequence === 'B' && $max_residual === 1) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'B' && $max_residual === 2) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'B' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'B' && $max_residual === 4) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'B' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($residual_frequence === 'C' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'C' && $max_residual === 2) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'C' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'C' && $max_residual === 4) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'C' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($residual_frequence === 'D' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'D' && $max_residual === 2) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'D' && $max_residual === 3) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'D' && $max_residual === 4) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'D' && $max_residual === 5) $this->residual_level_of_risk = 'H';

            if ($residual_frequence === 'E' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'E' && $max_residual === 2) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'E' && $max_residual === 3) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'E' && $max_residual === 4) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'E' && $max_residual === 5) $this->residual_level_of_risk = 'H';
        }

        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk === 'C') {
            $this->residual_main_risk = 'Ya';
        }
        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk !== 'C') {
            $this->residual_main_risk = 'Tidak';
        }
    }

}
