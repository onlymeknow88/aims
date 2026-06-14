<?php

namespace App\Http\Livewire\FieldLeadership\Listing\Active;

use App\Enums\CompanyType;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\FieldLeadership;
use App\Models\FieldLeadershipCategory;
use App\Models\FieldLeadershipKtaAndTta;
use App\Models\FieldLeadershipMember;
use App\Models\FieldLeadershipParameter;
use App\Models\FieldLeadershipPositive;
use App\Models\FieldLeadershipPotencyAndConsequnce;
use App\Models\FieldLeadershipQuestionPto;
use App\Models\FieldLeadershipRisk;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditActiveFieldLeadershipPage extends Component
{
    use WithFileUploads;

    public $fieldLeadership;

    public $limit_param;

    public $date;
    public $ccow_id;
    public $company_id;
    public $detail_company;
    public $department_id;
    public $section_id;
    public $area_location_id;
    public $detail_location;
    public $pja_id;
    public $pjo_id;
    public $type;
    public $job;
    public $visit_time;
    public $showQuestion = false;

    public $fieldQuestion;
    public $question1, $question2, $question3;
    public $answer1, $answer2, $answer3;

    public $latestUpdate;

    public $temporaryFile;

    public $member = [
        [
            'type' => null,
            'employee_id' => null,
        ],
    ];

    public $positive_condition = [
        [
            'description' => null,
        ],
    ];

    public $risk_condition = [
        [
            'description' => null,
            'category' => null,
            'type' => null,
            'level' => null,
            'action' => null,
            'due_date' => null,
            'files' => [],
        ],
    ];

    public $hazard_report_label = false;

    public function mount($id)
    {
        $last = FieldLeadership::latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at)->format('F d, Y . H:i A');

        $this->limit_param = FieldLeadershipParameter::first();

        $this->fieldLeadership = FieldLeadership::find($id);

        $this->date = Carbon::parse($this->fieldLeadership->date)->format('F d, Y');
        $this->ccow_id = $this->fieldLeadership->ccow_id;
        $this->company_id = $this->fieldLeadership->company_id;
        $this->detail_company = $this->fieldLeadership->detail_company;
        $this->department_id = $this->fieldLeadership->department_id;
        $this->section_id = $this->fieldLeadership->section_id;
        $this->area_location_id = $this->fieldLeadership->area_location_id;
        $this->detail_location = $this->fieldLeadership->detail_location;
        $this->pja_id = $this->fieldLeadership->pja_id;
        $this->pjo_id = $this->fieldLeadership->pjo_id;
        $this->type = $this->fieldLeadership->type;
        $this->job = $this->fieldLeadership->job;
        $this->visit_time = $this->fieldLeadership->visit_time;

        if (!empty($this->fieldLeadership->questions)) {
            $this->fieldQuestion = FieldLeadershipQuestionPto::where('fl_id', $id)->get()->toArray();

            $this->question1 = $this->fieldQuestion[0]['question'] ?? null;
            $this->question2 = $this->fieldQuestion[1]['question'] ?? null;
            $this->question3 = $this->fieldQuestion[2]['question'] ?? null;

            $this->answer1 = $this->fieldQuestion[0]['answer'] ?? null;
            $this->answer2 = $this->fieldQuestion[1]['answer'] ?? null;
            $this->answer3 = $this->fieldQuestion[2]['answer'] ?? null;
        }

        if ($this->type == 'Planned Task Observation') {
            $this->showQuestion = true;
        }

        $this->member = $this->fieldLeadership->members->map(function ($member) {
            return [
                'type' => $member->type,
                'employee_id' => $member->employee_id,
            ];
        })->toArray();

        $this->positive_condition = $this->fieldLeadership->positives->map(function ($positiveCondition) {
            return [
                'description' => $positiveCondition->description,
            ];
        })->toArray();

        $this->risk_condition = $this->fieldLeadership->risks->map(function ($riskCondition) {
            return [
                'description' => $riskCondition->risk_condition,
                'category' => $riskCondition->category_id,
                'type' => $riskCondition->type_id,
                'level' => $riskCondition->potency_id,
                'action' => $riskCondition->repair_action,
                'due_date' => Carbon::parse($riskCondition->due_date)->format('F d, Y'),
                'files' => $riskCondition->files->map(function ($file) {
                    return [
                        'file' => $file->file,
                        'name' => $file->file,
                        'size' => $file->size,
                        'extension' => $file->file,
                    ];
                })->toArray(),
            ];
        })->toArray();
    }

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('datetimepicker-input');
    }

    public function getCcowsProperty()
    {
        return Company::where('type', CompanyType::Internal)->get();
    }

    public function getCompaniesProperty()
    {
        return Company::all();
    }

    public function getDepartmentsProperty()
    {
        return Department::where('company_id', $this->company_id)->get();
    }

    public function getSectionsProperty()
    {
        return Section::where('department_id', $this->department_id)->get();
    }

    public function getAreaLocationsProperty()
    {
        return AreaLocation::where('section_id', $this->section_id)->get();
    }

    public function getAreaManagersProperty()
    {
        return AreaManager::where('section_id', $this->section_id)->get();
    }

    public function getEmployeesProperty()
    {
        return Company::where('id', $this->company_id)->get();
    }

    public function getCategoriesProperty()
    {
        return FieldLeadershipCategory::all();
    }

    public function getTypeKtaTtaProperty()
    {
        return FieldLeadershipKtaAndTta::all();
    }

    public function getPotenciesProperty()
    {
        return FieldLeadershipPotencyAndConsequnce::all();
    }

    public function addMember()
    {
        $this->member[] = [
            'type' => null,
            'employee_id' => null,
        ];
    }

    public function removeMember($index)
    {
        unset($this->member[$index]);
        $this->member = array_values($this->member);
    }

    public function addPositiveCondition()
    {
        $this->positive_condition[] = [
            'description' => null,
        ];
    }

    public function removePositiveCondition($index)
    {
        unset($this->positive_condition[$index]);
        $this->positive_condition = array_values($this->positive_condition);
    }

    public function updated($propertyName, $value)
    {
        // dd($propertyName, $value);
        if (explode('.', $propertyName)[0] == 'temporaryFile') {
            if (is_object($value[0])) {
                $this->addFile(explode('.', $propertyName)[1]);
            }
        }

        if ($propertyName == 'type') {
            if ($value == 'Hazard Report') {
                $this->hazard_report_label = true;
            } else {
                $this->hazard_report_label = false;
            }
        }

        if ($propertyName == 'type') {
            if ($value == 'Planned Task Observation') {
                $this->showQuestion = true;
            } else {
                $this->showQuestion = false;
            }
        }
    }

    public function addRiskCondition()
    {
        $this->risk_condition[] = [
            'description' => null,
            'category' => null,
            'type' => null,
            'level' => null,
            'action' => null,
            'due_date' => null,
            'files' => [],
        ];
    }

    public function removeRiskCondition($index)
    {
        unset($this->risk_condition[$index]);
        $this->risk_condition = array_values($this->risk_condition);
    }

    public function addFile($index)
    {
        $this->risk_condition[$index]['files'][] = [
            'file' => $this->temporaryFile[$index][0],
            'name' => $this->temporaryFile[$index][0]->getClientOriginalName(),
            'size' => $this->changeByte($this->temporaryFile[$index][0]->getSize()),
            'extension' => $this->temporaryFile[$index][0]->getClientOriginalExtension(),
        ];
    }

    public function removeFile($index, $fileIndex)
    {
        unset($this->risk_condition[$index]['files'][$fileIndex]);
        $this->risk_condition[$index]['files'] = array_values($this->risk_condition[$index]['files']);
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    protected function rules(): array
    {
        return [
            'date' => 'required',
            'ccow_id' => 'required',
            'company_id' => 'required',
            'detail_company' => 'required',
            'department_id' => 'required',
            'section_id' => 'required',
            'area_location_id' => 'required',
            'detail_location' => 'nullable',
            'pja_id' => 'required',
            'pjo_id' => 'required',
            'type' => 'required',
            'job' => 'required',
            'visit_time' => 'nullable',
            'member.*.type' => 'nullable',
            'member.*.employee_id' => 'nullable',
            'positive_condition.*.description' => 'nullable',
            'risk_condition.*.description' => 'nullable',
            'risk_condition.*.category' => 'nullable',
            'risk_condition.*.type' => 'nullable',
            'risk_condition.*.level' => 'nullable',
            'risk_condition.*.action' => 'nullable',
            'risk_condition.*.due_date' => 'nullable',
            'risk_condition.*.files.*.file' => 'nullable',
        ];
    }

    public function saved($publish)
    {
        $this->validate();

        DB::beginTransaction();

        $this->fieldLeadership->update([
            'date' => Carbon::parse($this->date)->format('Y-m-d'),
            'ccow_id' => $this->ccow_id,
            'company_id' => $this->company_id,
            'detail_company' => $this->detail_company,
            'department_id' => $this->department_id,
            'section_id' => $this->section_id,
            'area_location_id' => $this->area_location_id,
            'detail_location' => $this->detail_location,
            'pja_id' => $this->pja_id,
            'pjo_id' => $this->pjo_id,
            'type' => $this->type,
            'job' => $this->job,
            'visit_time' => $this->visit_time,
            'published' => $publish == 'HR' ? 'Publish' : $publish,
            'status' => $publish != 'HR' ? FieldLeadershipType::Open : FieldLeadershipType::Close,
        ]);

        if ($this->type == 'Planned Task Observation') {
            $q1 = FieldLeadershipQuestionPto::find($this->fieldQuestion[0]['id']);
            $q1->update([
                'question' => $this->question1,
                'answer' => $this->answer1,
            ]);

            $q2 = FieldLeadershipQuestionPto::find($this->fieldQuestion[1]['id']);
            $q2->update([
                'question' => $this->question2,
                'answer' => $this->answer2,
            ]);

            $q3 = FieldLeadershipQuestionPto::find($this->fieldQuestion[2]['id']);
            $q3->update([
                'question' => $this->question3,
                'answer' => $this->answer3,
            ]);
        }

        if (!empty($this->member)) {
            FieldLeadershipMember::where('fl_id', $this->fieldLeadership->id)->delete();
            foreach ($this->member as $key => $value) {
                $this->fieldLeadership->members()->create([
                    'type' => $value['type'],
                    'employee_id' => $value['employee_id'],
                ]);
            }
        }

        if (!empty($this->positive_condition)) {
            FieldLeadershipPositive::where('fl_id', $this->fieldLeadership->id)->delete();
            foreach ($this->positive_condition as $key => $value) {
                $this->fieldLeadership->positives()->create([
                    'description' => $value['description'],
                ]);
            }
        }

        if (!empty($this->risk_condition)) {
            $risk = FieldLeadershipRisk::where('fl_id', $this->fieldLeadership->id)->first();
            if (!empty($risk->files)) {
                $risk->files()->delete();
            }
            if (!empty($risk)) {
                $risk->delete();
            }
            foreach ($this->risk_condition as $key => $value) {
                $riskCondition = $this->fieldLeadership->risks()->create([
                    'risk_condition' => $value['description'],
                    'category_id' => $value['category'],
                    'type_id' => $value['type'],
                    'potency_id' => $value['level'],
                    'repair_action' => $value['action'],
                    'due_date' => Carbon::parse($value['due_date'])->format('Y-m-d'),
                ]);

                foreach ($value['files'] as $key => $file) {
                    if (!is_object($file['file'])) {
                        $path = $file['file'];
                    } else {
                        $path = $file['file']->store('field-leadership/' . $this->fieldLeadership->id . '/risk-condition/' . $riskCondition->id);
                    }

                    $riskCondition->files()->create([
                        'file' => $path,
                        'size' => $file['size'],
                    ]);
                }
            }
        }

        DB::commit();

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text'  => 'Data berhasil di simpan'
        ]);

        return redirect()->route('field-leadership::listing.active.index');
    }

    public function render()
    {
        return view('livewire.field-leadership.listing.active.edit-active-field-leadership-page')->extends('livewire.field-leadership.layouts.no-header');
    }
}
