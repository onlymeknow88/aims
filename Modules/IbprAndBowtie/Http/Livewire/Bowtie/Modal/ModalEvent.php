<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Modal;

use App\Models\IbprBowty\BowtieEventCmfRepair;
use App\Models\IbprBowty\BowtieEventImm;
use App\Models\IbprBowty\BowtieEventImmRepair;
use App\Models\IbprBowty\BowtieEventReason;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\IbprBowty\BowtieEventCmf;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\IbprBowty\BowtieEvent;
use Livewire\Component;

class ModalEvent extends Component
{
    protected $listeners = [
        'click_edit_event' => 'handle_click_edit_event',
        'close_modal_edit' => 'handle_add_new',
        'change_reason' => 'handle_change_reason',
    ];

    public $is_edit = false;
    public $event_id;
    public $users = [];
    public $bowtie_id;
    public $description;
    public $reason;

    // string;
    public $impact_k3;
    public $impact_lh;
    public $impact_ksl;
    public $impact_kp;
    public $impact_kk;

    public $k3_severity;
    public $k3_max_loss;
    public $lh_severity;
    public $lh_max_loss;
    public $ksl_severity;
    public $ksl_max_loss;
    public $kp_severity;
    public $kp_max_loss;
    public $kk_severity;
    public $kk_max_loss;
    public $severity_factor;
    public $severity_explain;
    public $likelihood_factor;
    public $likelihood_explain;
    public $trr_factor;
    public $trr_explanation;
    public $reasons = [
        [
            'name' => ''
        ]
    ];

    // MODAL
    public $control_measure_form = [];
    public $control_measures;
    public $associated_with_cause;
    public $critical_control;
    public $person_in_control;
    public $repair_tasks = [];
    public $mitigation_repair_tasks = [];
    public $repair_task;
    public $due_date;
    public $person_responsible;
    public $completion_date;

    public $impact_mitigation_memasure = [];
    public $mitigation_measures;
    public $mitigation_associated_with_cause;
    public $mitigation_critical;
    public $mitigation_person_in_control;

    public $cmf_id = null;
    public $imm_id = null;
    public $repair_task_id = null;
    public $mitigation_repair_task_id = null;

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function handle_change_reason($name, $index)
    {
        $this->reasons[$index]['name'] = $name;
    }

    public function addReasons()
    {
        $this->reasons[] = [
            'name' => ''
        ];
        $this->add_cms_auto();
        $this->add_repairTask_auto();
        // $this->add_mitigation_repairTask_auto();
        // $this->add_imm_auto();
    }

    public function mount($bowtie_id)
    {
        $this->bowtie_id = $bowtie_id;
        $this->users = User::get();
        $this->add_cms_auto();
        $this->add_repairTask_auto();
        // $this->add_mitigation_repairTask_auto();
        // $this->add_imm_auto();
    }

    public function handle_click_edit_event($id)
    {
        $this->is_edit = true;
        $this->event_id = $id;

        $event = BowtieEvent::find($id);
        $this->description = $event->description;
        $this->reason = $event->reason;

        // string;
        $this->impact_k3 = $event->impact_k3;
        $this->impact_lh = $event->impact_lh;
        $this->impact_ksl = $event->impact_ksl;
        $this->impact_kp = $event->impact_kp;
        $this->impact_kk = $event->impact_kk;

        $this->k3_severity = $event->k3_severity;
        $this->k3_max_loss = $event->k3_max_loss;
        $this->lh_severity = $event->lh_severity;
        $this->lh_max_loss = $event->lh_max_loss;
        $this->ksl_severity = $event->ksl_severity;
        $this->ksl_max_loss = $event->ksl_max_loss;
        $this->kp_severity = $event->kp_severity;
        $this->kp_max_loss = $event->kp_max_loss;
        $this->kk_severity = $event->kk_severity;
        $this->kk_max_loss = $event->kk_max_loss;
        $this->severity_factor = $event->severity_factor;
        $this->severity_explain = $event->severity_explain;
        $this->likelihood_factor = $event->likelihood_factor;
        $this->likelihood_explain = $event->likelihood_explain;
        $this->trr_factor = $event->trr_factor;
        $this->trr_explanation = $event->trr_explanation;

        $this->control_measure_form = $event->cmf->toArray();
        $this->repair_tasks = $event->cmf_repair->toArray();
        $this->impact_mitigation_memasure = $event->imm->toArray();
        $this->mitigation_repair_tasks = $event->imm_repair->toArray();
        $this->reasons = $event->reasons->toArray();

        $this->emit('openModal');
    }

    public function handle_add_new()
    {
        if ($this->is_edit === true) {
            $this->description = null;
            $this->reason = null;

            // string;
            $this->impact_k3 = null;
            $this->impact_lh = null;
            $this->impact_ksl = null;
            $this->impact_kp = null;
            $this->impact_kk = null;

            $this->k3_severity = null;
            $this->k3_max_loss = null;
            $this->lh_severity = null;
            $this->lh_max_loss = null;
            $this->ksl_severity = null;
            $this->ksl_max_loss = null;
            $this->kp_severity = null;
            $this->kp_max_loss = null;
            $this->kk_severity = null;
            $this->kk_max_loss = null;
            $this->severity_factor = null;
            $this->severity_explain = null;
            $this->likelihood_factor = null;
            $this->likelihood_explain = null;
            $this->trr_factor = null;
            $this->trr_explanation = null;

            $this->control_measure_form = [];
            $this->repair_tasks = [];
            $this->impact_mitigation_memasure = [];
            $this->mitigation_repair_tasks = [];
            $this->reasons = [['name' => '']];

            $this->is_edit = false;
            $this->event_id = null;
        }
    }

    public function add_cms_auto()
    {
        $cms = [
            'associated_with_cause' => '',
            'critical_control' => '',
            'person_in_control' => '',
            'control_measures' => ''
        ];

        if ($this->cmf_id === null) {
            $this->control_measure_form[] = $cms;
        } else {
            if (isset($this->control_measure_form[$this->cmf_id])) {
                $this->control_measure_form[$this->cmf_id] = array_merge($this->control_measure_form[$this->cmf_id], $cms);
            }
        }

        $this->associated_with_cause = null;
        $this->critical_control = null;
        $this->person_in_control = null;
        $this->control_measures = null;

        // $this->emit('closeModalCms');
    }

    public function add_repairTask_auto()
    {
        $repair_task = [
            'repair_task' => '',
            'due_date' => '',
            'person_responsible' => '',
            'completion_date' => '',

        ];

        if ($this->repair_task_id === null) {
            $this->repair_tasks[] = $repair_task;
        } else {
            if (isset($this->repair_tasks[$this->repair_task_id])) {
                $this->repair_tasks[$this->repair_task_id] = array_merge($this->repair_tasks[$this->repair_task_id], $repair_task);
            }
        }

        $this->repair_task = null;
        $this->due_date = null;
        $this->person_responsible = null;
        $this->completion_date = null;
    }

    public function add_mitigation_repairTask_auto()
    {

        $repair_task = [
            'repair_task' => '',
            'due_date' => '',
            'person_responsible' => '',
            'completion_date' => '',

        ];

        if ($this->mitigation_repair_task_id === null) {
            $this->mitigation_repair_tasks[] = $repair_task;
        } else {
            if (isset($this->mitigation_repair_tasks[$this->mitigation_repair_task_id])) {
                $this->mitigation_repair_tasks[$this->mitigation_repair_task_id] = array_merge($this->mitigation_repair_tasks[$this->mitigation_repair_task_id], $repair_task);
            }
        }

        $this->repair_task = null;
        $this->due_date = null;
        $this->person_responsible = null;
        $this->completion_date = null;


        $this->emit('closeModalMitigationRepairTask');
    }

    public function add_imm_auto()
    {
        $imm = [
            'mitigation_associated_with_cause' => '',
            'mitigation_critical' => '',
            'mitigation_person_in_control' => '',
            'mitigation_measures' => ''
        ];

        if ($this->imm_id === null) {
            $this->impact_mitigation_memasure[] = $imm;
        } else {
            if (isset($this->impact_mitigation_memasure[$this->imm_id])) {
                $this->impact_mitigation_memasure[$this->imm_id] = array_merge($this->impact_mitigation_memasure[$this->imm_id], $imm);
            }
        }

        $this->mitigation_associated_with_cause = null;
        $this->mitigation_critical = null;
        $this->mitigation_person_in_control = null;
        $this->mitigation_measures = null;
    }

    public function add_cms()
    {
        $this->validate(
            [
                'associated_with_cause' => 'required',
                'critical_control' => 'required',
                'person_in_control' => 'required',
                'control_measures' => 'required'
            ],
            [
                'associated_with_cause' => 'required',
                'critical_control' => 'required',
                'person_in_control' => 'required',
                'control_measures' => 'required'
            ]
        );

        $cms = [
            'associated_with_cause' => $this->associated_with_cause,
            'critical_control' => $this->critical_control,
            'person_in_control' => $this->person_in_control,
            'control_measures' => $this->control_measures
        ];

        if ($this->cmf_id === null) {
            $this->control_measure_form[] = $cms;
        } else {
            if (isset($this->control_measure_form[$this->cmf_id])) {
                $this->control_measure_form[$this->cmf_id] = array_merge($this->control_measure_form[$this->cmf_id], $cms);
            }
        }

        $this->associated_with_cause = null;
        $this->critical_control = null;
        $this->person_in_control = null;
        $this->control_measures = null;

        $this->emit('closeModalCms');
    }

    public function edit_cms($key): void
    {
        $data = $this->control_measure_form[$key];
        $this->associated_with_cause = $data['associated_with_cause'];
        $this->critical_control = $data['critical_control'];
        $this->person_in_control = $data['person_in_control'];
        $this->control_measures = $data['control_measures'];

        $this->cmf_id = $key;
        $this->emit('openCmfModal');
    }


    public function add_repairTask()
    {
        //        $this->validate([
        //            'repair_task' => 'required',
        //            'due_date' => 'required',
        //            'person_responsible' => 'required',
        //            'completion_date' => 'required'
        //
        //        ],
        //        [
        //            'repair_task' => 'required',
        //            'due_date' => 'required',
        //            'person_responsible' => 'required',
        //            'completion_date' => 'required'
        //        ]
        //    );

        $repair_task = [
            'repair_task' => $this->repair_task,
            'due_date' => $this->due_date,
            'person_responsible' => $this->person_responsible,
            'completion_date' => $this->completion_date,

        ];

        if ($this->repair_task_id === null) {
            $this->repair_tasks[] = $repair_task;
        } else {
            if (isset($this->repair_tasks[$this->repair_task_id])) {
                $this->repair_tasks[$this->repair_task_id] = array_merge($this->repair_tasks[$this->repair_task_id], $repair_task);
            }
        }

        $this->repair_task = null;
        $this->due_date = null;
        $this->person_responsible = null;
        $this->completion_date = null;


        $this->emit('closeModalRepairTask');
    }

    public function edit_repair_task($key): void
    {
        $data = $this->repair_tasks[$key];
        $this->repair_task = $data['repair_task'];
        $this->due_date = $data['due_date'];
        $this->person_responsible = $data['person_responsible'];
        $this->completion_date = $data['completion_date'];

        $this->repair_task_id = $key;
        $this->emit('openRepairTaskModal');
    }

    public function add_mitigation_repairTask()
    {
        //        $this->validate([
        //            'repair_task' => 'required',
        //            'due_date' => 'required',
        //            'person_responsible' => 'required',
        //            'completion_date' => 'required'
        //
        //        ],
        //        [
        //            'repair_task' => 'required',
        //            'due_date' => 'required',
        //            'person_responsible' => 'required',
        //            'completion_date' => 'required'
        //        ]
        //    );

        $repair_task = [
            'repair_task' => $this->repair_task,
            'due_date' => $this->due_date,
            'person_responsible' => $this->person_responsible,
            'completion_date' => $this->completion_date,

        ];

        if ($this->mitigation_repair_task_id === null) {
            $this->mitigation_repair_tasks[] = $repair_task;
        } else {
            if (isset($this->mitigation_repair_tasks[$this->mitigation_repair_task_id])) {
                $this->mitigation_repair_tasks[$this->mitigation_repair_task_id] = array_merge($this->mitigation_repair_tasks[$this->mitigation_repair_task_id], $repair_task);
            }
        }

        $this->repair_task = null;
        $this->due_date = null;
        $this->person_responsible = null;
        $this->completion_date = null;


        $this->emit('closeModalMitigationRepairTask');
    }

    public function edit_mitigation_repair_task($key): void
    {
        $data = $this->mitigation_repair_tasks[$key];
        $this->repair_task = $data['repair_task'];
        $this->due_date = $data['due_date'];
        $this->person_responsible = $data['person_responsible'];
        $this->completion_date = $data['completion_date'];

        $this->mitigation_repair_task_id = $key;
        $this->emit('openMitigationRepairTaskModal');
    }

    public function add_imm()
    {
        $this->validate(
            [
                'mitigation_associated_with_cause' => 'required',
                'mitigation_critical' => 'required',
                'mitigation_person_in_control' => 'required',
                'mitigation_measures' => 'required'
            ],
            [
                'mitigation_associated_with_cause' => 'required',
                'mitigation_critical' => 'required',
                'mitigation_person_in_control' => 'required',
                'mitigation_measures' => 'required'
            ]
        );

        $imm = [
            'mitigation_associated_with_cause' => $this->mitigation_associated_with_cause,
            'mitigation_critical' => $this->mitigation_critical,
            'mitigation_person_in_control' => $this->mitigation_person_in_control,
            'mitigation_measures' => $this->mitigation_measures
        ];

        if ($this->imm_id === null) {
            $this->impact_mitigation_memasure[] = $imm;
        } else {
            if (isset($this->impact_mitigation_memasure[$this->imm_id])) {
                $this->impact_mitigation_memasure[$this->imm_id] = array_merge($this->impact_mitigation_memasure[$this->imm_id], $imm);
            }
        }

        $this->mitigation_associated_with_cause = null;
        $this->mitigation_critical = null;
        $this->mitigation_person_in_control = null;
        $this->mitigation_measures = null;

        $this->emit('closeModalImm');
    }

    public function edit_imm($key): void
    {
        $data = $this->impact_mitigation_memasure[$key];
        $this->mitigation_associated_with_cause = $data['mitigation_associated_with_cause'];
        $this->mitigation_critical = $data['mitigation_critical'];
        $this->mitigation_person_in_control = $data['mitigation_person_in_control'];
        $this->mitigation_measures = $data['mitigation_measures'];

        $this->imm_id = $key;
        $this->emit('openImmModal');
    }


    public function remove_reason($index)
    {
        // dd($this->reasons[$index]);
        unset($this->reasons[$index]);
        $this->remove_cms($index);
        $this->remove_repair_task($index);
        $this->remove_imm($index);
        $this->remove_mitigation_repair_task($index);
    }

    public function remove_cms($index)
    {
        unset($this->control_measure_form[$index]);
    }

    public function remove_repair_task($index)
    {
        unset($this->repair_tasks[$index]);
    }

    public function remove_imm($index)
    {
        unset($this->impact_mitigation_memasure[$index]);
    }

    public function remove_mitigation_repair_task($index)
    {
        unset($this->mitigation_repair_tasks[$index]);
    }

    public function submit()
    {
        DB::beginTransaction();
        try {
            $rules = [
                'k3_severity' => 'required|integer',
                'lh_severity' => 'required|integer',
                'ksl_severity' => 'required|integer',
                'kp_severity' => 'required|integer',
                'kk_severity' => 'required|integer',
                'severity_factor' => 'required|integer',
                'likelihood_factor' => 'required',
                'trr_factor' => 'required',
            ];

            $messages = [
                'k3_severity' => [
                    'required' => 'k3_severity Field Harus Ada',
                    'integer' => 'k3_severity Field Harus Angka',
                ],
                'lh_severity' => [
                    'required' => 'lh_severity Field Harus Ada',
                    'integer' => 'lh_severity Field Harus Angka',
                ],
                'ksl_severity' => [
                    'required' => 'ksl_severity Field Harus Ada',
                    'integer' => 'ksl_severity Field Harus Angka',
                ],
                'kp_severity' => [
                    'required' => 'kp_severity Field Harus Ada',
                    'integer' => 'kp_severity Field Harus Angka',
                ],
                'kk_severity' => [
                    'required' => 'kk_severity Field Harus Ada',
                    'integer' => 'kk_severity Field Harus Angka',
                ],
                'severity_factor' => [
                    'required' => 'severity_factor Field Harus Ada',
                    'integer' => 'Field Harus Angka',
                ],
                'likelihood_factor' => [
                    'required' => 'likelihood_factor Field Harus Ada',
                    'integer' => 'Field Harus Ada',
                ],
                'trr_factor' => [
                    'required' => 'trr_factor Field Harus Ada',
                    'integer' => 'Field Harus Ada',
                ],
            ];

            $this->validate($rules, $messages);

            $countEvent = BowtieEvent::where('bowtie_id', $this->bowtie_id)->count();
            $event = BowtieEvent::create([
                'bowtie_id' => $this->bowtie_id,
                'name' => 'EVENT ' . $countEvent + 1,
                'description' => $this->description,
                'reason' => $this->reason,
                'impact_k3' => $this->impact_k3,
                'impact_lh' => $this->impact_lh,
                'impact_ksl' => $this->impact_ksl,
                'impact_kp' => $this->impact_kp,
                'impact_kk' => $this->impact_kk,
                'k3_severity' => $this->k3_severity,
                'k3_max_loss' => $this->k3_max_loss,
                'lh_severity' => $this->lh_severity,
                'lh_max_loss' => $this->lh_max_loss,
                'ksl_severity' => $this->ksl_severity,
                'ksl_max_loss' => $this->ksl_max_loss,
                'kp_severity' => $this->kp_severity,
                'kp_max_loss' => $this->kp_max_loss,
                'kk_severity' => $this->kk_severity,
                'kk_max_loss' => $this->kk_max_loss,
                'severity_factor' => $this->severity_factor,
                'severity_explain' => $this->severity_explain,
                'likelihood_factor' => $this->likelihood_factor,
                'likelihood_explain' => $this->likelihood_explain,
                'trr_factor' => $this->trr_factor,
                'trr_explanation' => $this->trr_explanation,
            ]);

            $event->cmf()->createMany($this->control_measure_form);
            $event->cmf_repair()->createMany($this->repair_tasks);
            $event->imm()->createMany($this->impact_mitigation_memasure);
            $event->imm_repair()->createMany($this->mitigation_repair_tasks);
            $event->reasons()->createMany($this->reasons);

            DB::commit();
            $this->emit('closeModal');
            $this->dispatchBrowserEvent('refresh-page');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function submit_edit()
    {
        DB::beginTransaction();
        try {
            $event = BowtieEvent::find($this->event_id);
            $event->update([
                'bowtie_id' => $this->bowtie_id,
                'description' => $this->description,
                'reason' => $this->reason,
                'impact_k3' => $this->impact_k3,
                'impact_lh' => $this->impact_lh,
                'impact_ksl' => $this->impact_ksl,
                'impact_kp' => $this->impact_kp,
                'impact_kk' => $this->impact_kk,
                'k3_severity' => $this->k3_severity,
                'k3_max_loss' => $this->k3_max_loss,
                'lh_severity' => $this->lh_severity,
                'lh_max_loss' => $this->lh_max_loss,
                'ksl_severity' => $this->ksl_severity,
                'ksl_max_loss' => $this->ksl_max_loss,
                'kp_severity' => $this->kp_severity,
                'kp_max_loss' => $this->kp_max_loss,
                'kk_severity' => $this->kk_severity,
                'kk_max_loss' => $this->kk_max_loss,
                'severity_factor' => $this->severity_factor,
                'severity_explain' => $this->severity_explain,
                'likelihood_factor' => $this->likelihood_factor,
                'likelihood_explain' => $this->likelihood_explain,
                'trr_factor' => $this->trr_factor,
                'trr_explanation' => $this->trr_explanation,
            ]);

            $control_measure_form = [];
            BowtieEventCmf::where('event_id', $this->event_id)->delete();
            foreach ($this->control_measure_form as $value) {
                if ($value !== '') {

                    $control_measure_form = [
                        'id' => Str::uuid()->toString(),
                        'event_id' => $this->event_id,
                        'associated_with_cause' => $value['associated_with_cause'],
                        'critical_control' => $value['critical_control'],
                        'person_in_control' => $value['person_in_control'],
                        'control_measures' => $value['control_measures']
                    ];
                    BowtieEventCmf::insert($control_measure_form);
                }
            }

            $repair_tasks = [];
            BowtieEventCmfRepair::where('event_id', $this->event_id)->delete();
            foreach ($this->repair_tasks as $value) {
                if ($value !== '') {

                    $repair_tasks = [
                        'id' => Str::uuid()->toString(),
                        'event_id' => $this->event_id,
                        'repair_task' => $value['repair_task'],
                        'due_date' => $value['due_date'],
                        'person_responsible' => $value['person_responsible'],
                        'completion_date' => $value['completion_date'],
                    ];
                    BowtieEventCmfRepair::insert($repair_tasks);
                }
            }

            $impact_mitigation_memasure = [];
            BowtieEventImm::where('event_id', $this->event_id)->delete();
            foreach ($this->impact_mitigation_memasure as $value) {
                if ($value !== '') {

                    $impact_mitigation_memasure = [
                        'id' => Str::uuid()->toString(),
                        'event_id' => $this->event_id,
                        'mitigation_associated_with_cause' => $value['mitigation_associated_with_cause'],
                        'mitigation_critical' => $value['mitigation_critical'],
                        'mitigation_person_in_control' => $value['mitigation_person_in_control'],
                        'mitigation_measures' => $value['mitigation_measures']
                    ];
                    BowtieEventImm::insert($impact_mitigation_memasure);
                }
            }


            $mitigation_repair_tasks = [];
            BowtieEventImmRepair::where('event_id', $this->event_id)->delete();
            foreach ($this->mitigation_repair_tasks as $value) {
                if ($value !== '') {

                    $mitigation_repair_tasks = [
                        'id' => Str::uuid()->toString(),
                        'event_id' => $this->event_id,
                        'repair_task' => $value['repair_task'],
                        'due_date' => $value['due_date'],
                        'person_responsible' => $value['person_responsible'],
                        'completion_date' => $value['completion_date'],
                    ];
                    BowtieEventImmRepair::insert($mitigation_repair_tasks);
                }
            }

            $reasons = [];
            BowtieEventReason::where('event_id', $this->event_id)->delete();
            foreach ($this->reasons as $value) {
                if ($value !== '') {

                    $reasons = [
                        'id' => Str::uuid()->toString(),
                        'event_id' => $this->event_id,
                        'name' => $value['name'],
                    ];
                    BowtieEventReason::insert($reasons);
                }
            }

            DB::commit();
            $this->emit('closeModal');
            $this->dispatchBrowserEvent('refresh-page');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function render()
    {

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.modal.modal-event');
    }
}
