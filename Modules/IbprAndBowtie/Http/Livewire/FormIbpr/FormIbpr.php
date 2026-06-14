<?php

namespace Modules\IbprAndBowtie\Http\Livewire\FormIbpr;

use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtieEvent;
use App\Models\IbprBowty\Ibpr;
use App\Models\IbprBowty\IbprForm;
use App\Models\IbprBowty\IbprFormBowtie;
use App\Models\IbprBowty\IbprMasterBahaya;
use App\Models\IbprBowty\IbprMasterHirarki;
use App\Models\IbprBowty\Pica;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Modules\IbprAndBowtie\Http\Livewire\Exports\ExportIbpr;
use Illuminate\Support\Str;

class FormIbpr extends Component
{

    protected $listeners = [
        'event_formula_level_of_risk' => 'formula_level_of_risk',
        'event_formula_level_of_risk_residual' => 'formula_level_of_risk_residual',
        'event_unset_index_edit' => 'unset_index_edit',
        'event_ccow_on_change' => 'ccow_on_change',
    ];

    public $forms = [];
    public $route;
    public $ibpr;
    public $ibpr_id;
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
    public $preliminary_consequence_k3;
    public $preliminary_consequence_lh;
    public $preliminary_consequence_kp;
    public $preliminary_consequence_ksl;
    public $preliminary_consequence_kk;
    public $preliminary_frequence;
    public $preliminary_level_of_risk;
    public $preliminary_level_of_risk_label;
    public $preliminary_main_risk;
    public $modal_of_current;
    public $effective_control;
    public $residual_consequence_k3;
    public $residual_consequence_lh;
    public $residual_consequence_kp;
    public $residual_consequence_ksl;
    public $residual_consequence_kk;
    public $residual_frequence;
    public $residual_level_of_risk;
    public $residual_level_of_risk_label;
    public $residual_main_risk;
    public $follow_risk;
    public $notes = [];

    public $index_edit = null;
    public $id_edit = null;

    public $events = [];
    public $bowtie = [];

    public $ibprHirarki = [];
    public $ibprBahaya = [];

    public $risk_titles = [
        [
            'name' => ''
        ],
    ];

    public function mount($id, Request $request) {
        $this->route = $request->session()->get('route');
        $this->ibpr_id = $id;
        $this->ibpr = Ibpr::find($id);
        $this->bowtie = Bowtie::whereIn('status', ['Disetujui','Temporary'])->get();

        $this->ibprHirarki = IbprMasterHirarki::all();
        $this->ibprBahaya = IbprMasterBahaya::all();

        $this->events = BowtieEvent::whereHas('bowtie', function ($query) {
            $query->where('status', 'Disetujui');
        })->get();

        $this->columns = [
            trans('Activity') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Sub Activity') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'sub_activity_search',
                'sortable' => true,
            ],
            trans('Type Of Activity') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Mine Safety Hazard') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Incident Risk') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            // trans('Safety Opportunity') => [
            //     'filter' => true,
            //     'type' => 'text',
            //     'model' => 'no_document_search',
            //     'sortable' => true,
            // ],
            trans('Relevant Legislation') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Consequences (K3)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Consequences (LH)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Consequences (KP)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Consequences (KSL)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Consequences (KK)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Frequency') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Level Of Risk') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Main Risk') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Model of Current') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Effective Control') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Residual Max Consequences K3') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Residual Max Consequences LH') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Residual Max Consequences KP') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Residual Max Consequences KSL') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Residual Max Consequences KK') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Residual Frequency') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Residual Level Of Risk') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Residual Main Risk') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Follow-Up Risk Control') => [
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

    public function onSelect($index, $event) {
        if($event !== 'Select') {
            $this->risk_titles[$index]['name'] = $event;
            $this->risk_titles[] = [
                'name' => ''
            ];
        } else {
            if (count($this->risk_titles) > 1) {
                unset($this->risk_titles[$index]);
            }
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
        $this->forms = IbprForm::select()->where('ibpr_id', $this->ibpr_id)->get();
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.ibpr-form.list-form')->extends('ibprandbowtie::layouts.no-header');
    }

    public function submitDelete()
    {
        DB::beginTransaction();
        try {
            $ids = array_values($this->itemSelected);
            for ($a = 0; $a < count($ids); $a++) {
                $data = IbprForm::find($ids[$a]);
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
//            'preliminary_consequence_k3' => 'required',
//            'preliminary_consequence_kp' => 'required',
//            'preliminary_consequence_ksl' => 'required',
//            'preliminary_consequence_kk' => 'required',
            'preliminary_frequence' => 'required',
            'preliminary_level_of_risk' => 'required',
            'preliminary_main_risk' => 'required',
//            'effective_control' => 'required',
//            'residual_consequence_k3' => 'required',
//            'residual_consequence_kp' => 'required',
//            'residual_consequence_ksl' => 'required',
//            'residual_consequence_kk' => 'required',
//            'residual_frequence' => 'required',
//            'residual_level_of_risk' => 'required',
//            'residual_main_risk' => 'required'
        ];

        $messages = [
            'activity' => 'activity required',
            'sub_activity' => 'sub_activity required',
            'kondition' => 'kondition required',
            'safety' => 'safety required',
            'incident_risk' => 'incident_risk required',
            'relevant_legislation' => 'relevant_legislation required',
            'preliminary_consequence_k3' => 'preliminary_consequence_k3 required',
            'preliminary_consequence_kp' => 'preliminary_consequence_kp required',
            'preliminary_consequence_ksl' => 'preliminary_consequence_ksl required',
            'preliminary_consequence_kk' => 'preliminary_consequence_kk required',
            'preliminary_frequence' => 'preliminary_frequence required',
            'preliminary_level_of_risk' => 'preliminary_level_of_risk required',
            'preliminary_main_risk' => 'required',
            'effective_control' => 'required',
            'residual_consequence_k3' => 'residual_consequence_k3 required',
            'residual_consequence_kp' => 'residual_consequence_kp required',
            'residual_consequence_ksl' => 'residual_consequence_ksl required',
            'residual_consequence_kk' => 'residual_consequence_kk required',
            'residual_frequence' => 'residual_frequence required',
            'residual_level_of_risk' => 'residual_level_of_risk required',
            'residual_main_risk' => 'residual_main_risk required'
        ];

        $this->validate($rules, $messages);

        try {

            $object = [
                'ibpr_id' => $this->ibpr_id,
                'activity' => $this->activity,
                'sub_activity' => $this->sub_activity,
                'kondition' => $this->kondition,
                'safety' => $this->safety,
                'incident_risk' => $this->incident_risk,
                'safety_opportunity' => $this->safety_opportunity,
                'relevant_legislation' => $this->relevant_legislation,
                'preliminary_consequence_k3' => $this->preliminary_consequence_k3,
                'preliminary_consequence_kp' => $this->preliminary_consequence_kp,
                'preliminary_consequence_ksl' => $this->preliminary_consequence_ksl,
                'preliminary_consequence_kk' => $this->preliminary_consequence_kk,
                'preliminary_frequence' => $this->preliminary_frequence,
                'preliminary_level_of_risk' => $this->preliminary_level_of_risk,
                'preliminary_main_risk' => $this->preliminary_main_risk,
                'modal_of_current' => $this->modal_of_current,
                'effective_control' => $this->effective_control,
                'residual_consequence_k3' => $this->residual_consequence_k3,
                'residual_consequence_kp' => $this->residual_consequence_kp,
                'residual_consequence_ksl' => $this->residual_consequence_ksl,
                'residual_consequence_kk' => $this->residual_consequence_kk,
                'residual_frequence' => $this->residual_frequence,
                'residual_level_of_risk' => $this->residual_level_of_risk,
                'residual_main_risk' => $this->residual_main_risk,
                'follow_risk' => $this->follow_risk,
            ];

            if(!is_null($this->id_edit)) {
                $ibpr = IbprForm::find($this->id_edit);
                $ibpr->update($object);

                IbprFormBowtie::where('form_id', $this->id_edit)->delete();
                Pica::where('ibpr_form_id', $this->id_edit)->delete();
                $risk_titles = array_filter($this->risk_titles, function ($title) {
                    return $title['name'] !== '';
                });

                foreach ($risk_titles as $key => $risk_title) {
                    $risk = IbprFormBowtie::create([
                        'form_id' => $ibpr->id,
                        'name' => $risk_title['name'],
                        'note' => $this->notes[$key] ?? null
                    ]);

                    if ($this->preliminary_level_of_risk === 'C') {
                        $pica = Pica::create([
                            'ibpr_form_id' => $ibpr->id,
                            'ibpr_form_risk_id' => $risk->id,
                            'status' => 'Open'
                        ]);
                    }
                }

            }else {
                $createFormIbpr = IbprForm::create($object);
                $risk_titles = array_filter($this->risk_titles, function ($title) {
                    return $title['name'] !== '';
                });

                foreach ($risk_titles as $key => $risk_title) {
                    $bowtie = Bowtie::where('risk_title', $risk_title['name'])->first();

                    $risk = IbprFormBowtie::create([
                        'form_id' => $createFormIbpr->id,
                        'name' => $risk_title['name'],
                        'note' => $this->notes[$key] ?? null,
                        'bowtie_id' => $bowtie->id ?? null
                    ]);

                    if ($this->preliminary_level_of_risk === 'H') {
                        $pica = Pica::create([
                            'ibpr_form_id' => $createFormIbpr->id,
                            'ibpr_form_risk_id' => $risk->id,
                            'status' => 'Open'
                        ]);
                    }
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
            $this->preliminary_consequence_k3 = null;
            $this->preliminary_consequence_kp = null;
            $this->preliminary_consequence_ksl = null;
            $this->preliminary_consequence_kk = null;
            $this->preliminary_frequence = null;
            $this->preliminary_level_of_risk = null;
            $this->preliminary_main_risk = null;
            $this->modal_of_current = '';
            $this->effective_control = '';
            $this->residual_consequence_k3 = null;
            $this->residual_consequence_kp = null;
            $this->residual_consequence_ksl = null;
            $this->residual_consequence_kk = null;
            $this->residual_frequence = null;
            $this->residual_level_of_risk = null;
            $this->residual_main_risk = null;
            $this->follow_risk = '';
            $this->notes = [];

            $this->forms = IbprForm::select()->where('ibpr_id', $this->ibpr_id)->get();
            $this->emit('closeModal');
        } catch (\Exception $e) {
                dd($e);
            }
    }

    public function unset_index_edit(){
        $this->index_edit = null;
        $this->id_edit = null;
    }

    public function open_modal_edit($index){
        $this->index_edit = $index;
        $form_ibpr = $this->forms[$index];

        $this->id_edit = $form_ibpr->id;

        $this->risk_titles = IbprFormBowtie::select('name')->where('form_id', $form_ibpr->id)->get()->toArray();
        $this->risk_titles[]['name'] = '';

        $this->notes = IbprFormBowtie::select('note')->where('form_id', $form_ibpr->id)->pluck('note')->toArray();
//        $this->notes[]['note'] = '';

//        dd($this->notes);

        $this->activity = $form_ibpr['activity'];
        $this->sub_activity = $form_ibpr['sub_activity'];
        $this->safety = $form_ibpr['safety'];
        $this->kondition = $form_ibpr['kondition'];
        $this->incident_risk = $form_ibpr['incident_risk'];
        $this->safety_opportunity = $form_ibpr['safety_opportunity'];
        $this->relevant_legislation = $form_ibpr['relevant_legislation'];
        $this->preliminary_consequence_k3 = $form_ibpr['preliminary_consequence_k3'];
        $this->preliminary_consequence_kp = $form_ibpr['preliminary_consequence_kp'];
        $this->preliminary_consequence_ksl = $form_ibpr['preliminary_consequence_ksl'];
        $this->preliminary_consequence_kk = $form_ibpr['preliminary_consequence_kk'];
        $this->preliminary_frequence = $form_ibpr['preliminary_frequence'];
        $this->preliminary_level_of_risk = $form_ibpr['preliminary_level_of_risk'];
        $this->preliminary_main_risk = $form_ibpr['preliminary_main_risk'];
        $this->modal_of_current = $form_ibpr['modal_of_current'];
        $this->effective_control = $form_ibpr['effective_control'];
        $this->residual_consequence_k3 = $form_ibpr['residual_consequence_k3'];
        $this->residual_consequence_kp = $form_ibpr['residual_consequence_kp'];
        $this->residual_consequence_ksl = $form_ibpr['residual_consequence_ksl'];
        $this->residual_consequence_kk = $form_ibpr['residual_consequence_kk'];
        $this->residual_frequence = $form_ibpr['residual_frequence'];
        $this->residual_level_of_risk = $form_ibpr['residual_level_of_risk'];
        $this->residual_main_risk = $form_ibpr['residual_main_risk'];
        $this->follow_risk = $form_ibpr['follow_risk'];

        if ($this->preliminary_level_of_risk === 'C') $this->preliminary_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
        if ($this->preliminary_level_of_risk === 'H') $this->preliminary_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
        if ($this->preliminary_level_of_risk === 'M') $this->preliminary_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
        if ($this->preliminary_level_of_risk === 'L') $this->preliminary_level_of_risk_label = 'L (Tingkat Risiko Rendah)';

        if ($this->residual_level_of_risk === 'C') $this->residual_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
        if ($this->residual_level_of_risk === 'H') $this->residual_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
        if ($this->residual_level_of_risk === 'M') $this->residual_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
        if ($this->residual_level_of_risk === 'L') $this->residual_level_of_risk_label = 'L (Tingkat Risiko Rendah)';

        $this->emit('openModal');
    }

    public function delete_form($index) {
        unset($this->form[$index]);
    }

    public function change_consequences($value, $type) {
        if ($type === 'preliminary_consequence_k3') $this->preliminary_consequence_k3 = $value;
        if ($type === 'preliminary_consequence_lh') $this->preliminary_consequence_lh = $value;
        if ($type === 'preliminary_consequence_kp') $this->preliminary_consequence_kp = $value;
        if ($type === 'preliminary_consequence_ksl') $this->preliminary_consequence_ksl = $value;
        if ($type === 'preliminary_consequence_kk') $this->preliminary_consequence_kk = $value;
        if ($type === 'residual_consequence_k3') $this->residual_consequence_k3 = $value;
        if ($type === 'residual_consequence_lh') $this->residual_consequence_lh = $value;
        if ($type === 'residual_consequence_kp') $this->residual_consequence_kp = $value;
        if ($type === 'residual_consequence_ksl') $this->residual_consequence_ksl = $value;
        if ($type === 'residual_consequence_kk') $this->residual_consequence_kk = $value;

        $arr_preliminary = [$this->preliminary_consequence_k3, $this->preliminary_consequence_lh, $this->preliminary_consequence_kp, $this->preliminary_consequence_ksl, $this->preliminary_consequence_kk];
        $max_preliminary = max($arr_preliminary);

        $arr_residual = [$this->residual_consequence_k3, $this->residual_consequence_lh, $this->residual_consequence_kp, $this->residual_consequence_ksl, $this->residual_consequence_kk];
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

        if ($this->residual_frequence !== '' && $max_residual) {
            if ($this->residual_frequence === 'A' && $max_residual === 1) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'A' && $max_residual === 2) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'A' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'A' && $max_residual === 4) $this->residual_level_of_risk = 'C';
            if ($this->residual_frequence === 'A' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($this->residual_frequence === 'B' && $max_residual === 1) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'B' && $max_residual === 2) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'B' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'B' && $max_residual === 4) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'B' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($this->residual_frequence === 'C' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'C' && $max_residual === 2) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'C' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'C' && $max_residual === 4) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'C' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($this->residual_frequence === 'D' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'D' && $max_residual === 2) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'D' && $max_residual === 3) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'D' && $max_residual === 4) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'D' && $max_residual === 5) $this->residual_level_of_risk = 'H';

            if ($this->residual_frequence === 'H' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'H' && $max_residual === 2) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'H' && $max_residual === 3) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'H' && $max_residual === 4) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'H' && $max_residual === 5) $this->residual_level_of_risk = 'H';

            if ($this->residual_level_of_risk === 'C') $this->residual_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
            if ($this->residual_level_of_risk === 'H') $this->residual_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
            if ($this->residual_level_of_risk === 'M') $this->residual_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
            if ($this->residual_level_of_risk === 'L') $this->residual_level_of_risk_label = 'L (Tingkat Risiko Rendah)';
        }

        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk === 'C') {
            $this->preliminary_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk !== 'C') {
            $this->preliminary_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }

        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk === 'C') {
            $this->residual_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk !== 'C') {
            $this->residual_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }

        $this->emit('closeAllToooltip');
        $this->emit('chooseModaelOfCurrent');
    }

    public function formula_level_of_risk($preliminary_frequence){
        $arr_preliminary = [$this->preliminary_consequence_k3, $this->preliminary_consequence_lh, $this->preliminary_consequence_kp, $this->preliminary_consequence_ksl, $this->preliminary_consequence_kk];
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
        $arr_residual = [$this->residual_consequence_k3, $this->residual_consequence_lh, $this->residual_consequence_kp, $this->residual_consequence_ksl, $this->residual_consequence_kk];
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

            if ($this->residual_level_of_risk === 'C') $this->residual_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
            if ($this->residual_level_of_risk === 'H') $this->residual_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
            if ($this->residual_level_of_risk === 'M') $this->residual_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
            if ($this->residual_level_of_risk === 'L') $this->residual_level_of_risk_label = 'L (Tingkat Risiko Rendah)';
        }

        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk === 'C') {
            $this->residual_main_risk = 'Ya';
        }
        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk !== 'C') {
            $this->residual_main_risk = 'Tidak';
        }
    }

    public function exportIbpr(Request $request, $id)
    {
        return (new ExportIbpr($id))->download('export_ibpr'.'-'.now().'.xlsx');
    }
}
