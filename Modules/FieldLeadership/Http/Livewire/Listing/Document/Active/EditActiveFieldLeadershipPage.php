<?php

namespace Modules\FieldLeadership\Http\Livewire\Listing\Document\Active;

use App\Enums\CompanyType;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Enums\PicaSource;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipActivity;
use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Modules\FieldLeadership\Entities\FieldLeadershipMember;
use Modules\FieldLeadership\Entities\FieldLeadershipParameter;
use Modules\FieldLeadership\Entities\FieldLeadershipPositive;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;
use Modules\FieldLeadership\Entities\FieldLeadershipQuestionPto;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditActiveFieldLeadershipPage extends Component
{
    use WithFileUploads, LivewireAlert;

    public $fieldLeadership;

    public $limit_param;
    public $limit_member;

    public $number;
    public $date;
    public $ccow_id;
    public $company_id;
    public $detail_company;
    public $department_id;
    public $section_id;
    public $area_location_id;
    public $detail_location;
    public $personil_on_review;
    public $personil_on_review_name;
    public $pja_id;
    public $pjo_id;
    public $type;
    public $job;
    public $visit_time;
    public $non_compliance_root;
    public $showQuestion = false;

    public $repaired = false;

    public $fieldQuestion;
    public $question1 = "Apakah risiko yang ada di area Anda yang dapat membahayakan nyawa Anda?";
    public $question2 = "Apakah tersedia pengendalian penting tersedia untuk melindungi Anda?";
    public $question3 = "Bagaimana Anda mengetahui pengendalian penting tersebut efektif?";
    public $question4 = "Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesesuaian dengan pekerjaan yang dilakukan?";
    public $question5 = "Pekerja memahami SOP/INK/JSA tersebut?";
    public $question6 = "Apakah ada opportunity untuk proses SOP/INK/JSA yang lebih efisien, produktif dan aman?";
    public $answer1, $answer2, $answer3, $answer4, $answer5, $answer6;
    public $description1, $description2, $description3, $description4, $description5, $description6;

    public $latestUpdate;

    public $temporaryFile, $temporaryFileCA;

    public $member = [
        // [
        //     'type' => null,
        //     'employee_id' => null,
        // ],
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
            'type_action' => null,
            'supervisor' => null,
            'repaired' => null,
            'files' => [],
            'files_ca' => [],
        ],
    ];

    public $hazard_report_label = false;

    public $company_type = null;

    protected $listeners = ['loading'];

    public function loading()
    {
        $this->dispatchBrowserEvent('loading-modal');
    }

    public function mount($id)
    {
        $last = FieldLeadership::latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at)->format('F d, Y . H:i A');

        $this->limit_param = FieldLeadershipParameter::first();

        $this->fieldLeadership = FieldLeadership::find($id);

        $this->number = $this->fieldLeadership->number;
        $this->date = Carbon::parse($this->fieldLeadership->date)->format('F d, Y');
        $this->ccow_id = $this->fieldLeadership->ccow_id;
        $this->company_id = $this->fieldLeadership->company_id;
        $this->detail_company = $this->fieldLeadership->detail_company;
        $this->department_id = $this->fieldLeadership->department_id;
        $this->section_id = $this->fieldLeadership->section_id;
        $this->area_location_id = $this->fieldLeadership->area_location_id;
        $this->detail_location = $this->fieldLeadership->detail_location;
        $this->personil_on_review = $this->fieldLeadership->personil_on_review;
        $this->personil_on_review_name = $this->fieldLeadership->personil_on_review_name;
        $this->pja_id = $this->fieldLeadership->pja_id;
        $this->pjo_id = $this->fieldLeadership->pjo_id;
        $this->company_type = Company::find($this->fieldLeadership->company_id);
        $this->type = $this->fieldLeadership->type;
        $this->job = $this->fieldLeadership->job;
        $this->visit_time = $this->fieldLeadership->visit_time;
        $this->non_compliance_root = $this->fieldLeadership->non_compliance_root;

        if (!empty($this->fieldLeadership->questions)) {
            $this->fieldQuestion = FieldLeadershipQuestionPto::where('fl_id', $id)->get()->toArray();

            $this->question1 = $this->fieldQuestion[0]['question'] ?? null;
            $this->question2 = $this->fieldQuestion[1]['question'] ?? null;
            $this->question3 = $this->fieldQuestion[2]['question'] ?? null;
            $this->question4 = $this->fieldQuestion[3]['question'] ?? null;
            $this->question5 = $this->fieldQuestion[4]['question'] ?? null;
            $this->question6 = $this->fieldQuestion[5]['question'] ?? null;

            $this->answer1 = $this->fieldQuestion[0]['answer'] ?? null;
            $this->answer2 = $this->fieldQuestion[1]['answer'] ?? null;
            $this->answer3 = $this->fieldQuestion[2]['answer'] ?? null;
            $this->answer4 = $this->fieldQuestion[3]['answer'] ?? null;
            $this->answer5 = $this->fieldQuestion[4]['answer'] ?? null;
            $this->answer6 = $this->fieldQuestion[5]['answer'] ?? null;

            $this->description1 = $this->fieldQuestion[0]['description'] ?? null;
            $this->description2 = $this->fieldQuestion[1]['description'] ?? null;
            $this->description3 = $this->fieldQuestion[2]['description'] ?? null;
            $this->description4 = $this->fieldQuestion[3]['description'] ?? null;
            $this->description5 = $this->fieldQuestion[4]['description'] ?? null;
            $this->description6 = $this->fieldQuestion[5]['description'] ?? null;
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

        if (count($this->fieldLeadership->risks->whereNotNull('type_action')->toArray()) > 0) {
            $this->repaired = true;
        }

        $this->risk_condition = $this->fieldLeadership->risks->map(function ($riskCondition) {
            return [
                'description' => $riskCondition->risk_condition,
                'category' => $riskCondition->category_id,
                'type' => $riskCondition->type_id,
                'level' => $riskCondition->potency_id,
                'action' => $riskCondition->repair_action,
                'due_date' => Carbon::parse($riskCondition->due_date)->format('F d, Y'),
                'type_action' => $riskCondition->type_action,
                'supervisor' => $riskCondition->supervisor,
                'repaired' => isset($riskCondition->type_action) ? true : false,
                'files' => $riskCondition->files->where('type', FieldLeadershipType::RiskFinding)->map(function ($file) {
                    return [
                        'file' => $file->file,
                        'name' => $file->file,
                        'size' => $file->size,
                        'extension' => $file->file,
                    ];
                })->toArray(),
                'files_ca' => $riskCondition->files->where('type', FieldLeadershipType::CorrectiveAction)->map(function ($file) {
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
        $this->emit('form-check-input');
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
        return Department::where('company_id', $this->ccow_id)->get();
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
        return User::whereHas('department', function ($query) {
            $query->where('company_id', $this->company_id)
                ->whereHas('company', function ($q) {
                    $q->where('type', $this->company_type->type ?? null);
                });;
        })->get();
    }

    public function getMemberInternalsProperty()
    {
        return Employee::whereHas('user', function ($sql) {
            $sql->whereHas('department', function ($query) {
                $query->whereHas('company', function ($q) {
                    $q->where('type', CompanyType::Internal);
                });
            });
        })
            ->get();
    }

    public function getMemberExternalsProperty()
    {
        return Employee::whereHas('user', function ($sql) {
            $sql->whereHas('department', function ($query) {
                $query->whereHas('company', function ($q) {
                    $q->whereIn('type', [CompanyType::Contractor, CompanyType::SubContractor]);
                });
            });
        })
            ->get();
    }

    public function getCategoriesProperty()
    {
        return FieldLeadershipCategory::whereIn('name', ['Kondisi Tidak Aman', 'Tindakan Tidak Aman', 'Not Applicable'])->get();
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
        if ($propertyName == 'company_id') {
            $this->company_type = Company::find($value);
            $this->detail_company = $this->company_type->type;
        }

        if (explode('.', $propertyName)[0] == 'temporaryFile') {
            if (is_object($value[0])) {
                $this->addFile(explode('.', $propertyName)[1]);
            }
        }

        if (explode('.', $propertyName)[0] == 'temporaryFileCA') {
            if (is_object($value[0])) {
                $this->addFileCA(explode('.', $propertyName)[1]);
            }
        }

        if ($propertyName == 'type') {
            if ($value == 'Hazard Report') {
                $this->hazard_report_label = true;
                $this->limit_member = 1;
                $this->member = [
                    [
                        'type' => null,
                        'employee_id' => null,
                    ],
                ];
            } else {
                $this->hazard_report_label = false;
                $this->limit_member = 3;
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

    // public function handleRepaired()
    // {
    //     if ($this->repaired == false) {
    //         $this->repaired = true;
    //     } else {
    //         $this->repaired = false;
    //     }
    // }

    public function addRiskCondition()
    {
        $this->risk_condition[] = [
            'description' => null,
            'category' => null,
            'type' => null,
            'level' => null,
            'action' => null,
            'due_date' => null,
            'type_action' => null,
            'supervisor' => null,
            'repaired' => null,
            'files' => [],
            'files_ca' => [],
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

    public function addFileCA($index)
    {
        $this->risk_condition[$index]['files_ca'][] = [
            'file' => $this->temporaryFileCA[$index][0],
            'name' => $this->temporaryFileCA[$index][0]->getClientOriginalName(),
            'size' => $this->changeByte($this->temporaryFileCA[$index][0]->getSize()),
            'extension' => $this->temporaryFileCA[$index][0]->getClientOriginalExtension(),
        ];
    }

    public function removeFileCA($index, $fileIndex)
    {
        unset($this->risk_condition[$index]['files_ca'][$fileIndex]);
        $this->risk_condition[$index]['files_ca'] = array_values($this->risk_condition[$index]['files_ca']);
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public function generateNumber()
    {
        $count = FieldLeadership::count();
        $company = Company::find($this->company_id);
        $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $date = Carbon::today()->format('dmY');

        $result = 'FL-' . $company->document_code . '-' . $date . '-' . $formattedNumber;

        while (FieldLeadership::where('number', $result)->exists()) {
            $count++;
            $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
            $result = 'FL-' . $company->document_code . '-' . $date . '-' . $formattedNumber;
        }

        return $result;
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
            'personil_on_review' => 'nullable',
            'personil_on_review_name' => 'nullable',
            'pja_id' => 'required',
            'pjo_id' => 'nullable',
            'type' => 'required',
            'job' => 'nullable',
            'visit_time' => 'nullable',
            'non_compliance_root' => 'nullable',
            'member.*.type' => 'nullable',
            'member.*.employee_id' => 'nullable',
            'positive_condition.*.description' => 'nullable',
            'risk_condition.*.description' => 'nullable',
            'risk_condition.*.category' => 'nullable',
            'risk_condition.*.type' => 'nullable',
            'risk_condition.*.level' => 'nullable',
            'risk_condition.*.action' => 'nullable',
            'risk_condition.*.due_date' => 'nullable',
            'risk_condition.*.type_action' => 'nullable',
            'risk_condition.*.supervisor' => 'nullable',
            'risk_condition.*.repaired' => 'nullable',
            'risk_condition.*.files.*.file' => 'nullable',
            'risk_condition.*.files_ca.*.file' => 'nullable',
        ];
    }

    public function saved($publish)
    {
        try {
            $this->validate();

            DB::beginTransaction();

            $this->fieldLeadership->update([
                'number' => $this->number,
                'date' => Carbon::parse($this->date)->format('Y-m-d'),
                'ccow_id' => $this->ccow_id,
                'company_id' => $this->company_id,
                'detail_company' => $this->detail_company,
                'department_id' => $this->department_id,
                'section_id' => $this->section_id,
                'area_location_id' => $this->area_location_id,
                'detail_location' => $this->detail_location,
                'personil_on_review' => $this->personil_on_review,
                'personil_on_review_name' => $this->personil_on_review_name,
                'pja_id' => $this->pja_id,
                'pjo_id' => $this->pjo_id,
                'type' => $this->type,
                'job' => $this->job,
                'visit_time' => $this->visit_time,
                'non_compliance_root' => $this->non_compliance_root,
                'published' => $publish == 'HR' ? 'Publish' : $publish,
                'status' => $publish != 'HR' ? FieldLeadershipType::Open : FieldLeadershipType::Close,
                'requested' => $publish != 'HR' ? FieldLeadershipType::RequestedPja : FieldLeadershipType::Rejected,
            ]);

            if ($this->type == 'Planned Task Observation') {
                $q1 = FieldLeadershipQuestionPto::find($this->fieldQuestion[0]['id']);
                $q1->update([
                    'question' => $this->question1,
                    'answer' => $this->answer1,
                    'description' => $this->description1,
                ]);

                $q2 = FieldLeadershipQuestionPto::find($this->fieldQuestion[1]['id']);
                $q2->update([
                    'question' => $this->question2,
                    'answer' => $this->answer2,
                    'description' => $this->description2,
                ]);

                $q3 = FieldLeadershipQuestionPto::find($this->fieldQuestion[2]['id']);
                $q3->update([
                    'question' => $this->question3,
                    'answer' => '-',
                    'description' => $this->description3,
                ]);

                $q4 = FieldLeadershipQuestionPto::find($this->fieldQuestion[3]['id']);
                $q4->update([
                    'question' => $this->question4,
                    'answer' => $this->answer4,
                    'description' => $this->description4,
                ]);

                $q5 = FieldLeadershipQuestionPto::find($this->fieldQuestion[4]['id']);
                $q5->update([
                    'question' => $this->question5,
                    'answer' => $this->answer5,
                    'description' => $this->description5,
                ]);

                $q6 = FieldLeadershipQuestionPto::find($this->fieldQuestion[5]['id']);
                $q6->update([
                    'question' => $this->question6,
                    'answer' => $this->answer6,
                    'description' => $this->description6,
                ]);
            }

            if (count($this->member) > 3) {
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Error',
                    'icon' => 'error',
                    'text' => "Anggota tim tidak boleh lebih dari 3 orang",
                ]);
                return false;
            }
            if (!empty($this->member)) {
                FieldLeadershipMember::where('fl_id', $this->fieldLeadership->id)->delete();
                foreach ($this->member as $key => $value) {
                    if ($value['employee_id'] != null && $value['type'] != null) {
                        $this->fieldLeadership->members()->create([
                            'type' => $value['type'],
                            'employee_id' => $value['employee_id'],
                        ]);
                    }
                }
            }

            if (!empty($this->positive_condition)) {
                FieldLeadershipPositive::where('fl_id', $this->fieldLeadership->id)->delete();
                foreach ($this->positive_condition as $key => $value) {
                    if ($value['description'] != null) {
                        $this->fieldLeadership->positives()->create([
                            'description' => $value['description'],
                        ]);
                    }
                }
            }

            if (!empty($this->risk_condition)) {
                $risk = FieldLeadershipRisk::where('fl_id', $this->fieldLeadership->id)->get();

                foreach ($risk as $key => $value) {
                    if (!empty($value->files)) {
                        Storage::disk('public')->deleteDirectory('field-leadership/' . $this->fieldLeadership->id . '/risk-condition/' . $value->id);
                        $value->files()->delete();
                    }

                    if (!empty($value)) {
                        $value->delete();
                    }
                }

                foreach ($this->risk_condition as $key => $value) {

                    if ($value['description'] == null) {
                        $this->dispatchBrowserEvent('swal', [
                            'title' => 'Error',
                            'icon' => 'error',
                            'text' => "Perilaku/Kondisi Beresiko yang Diamati tidak boleh kosong",
                        ]);
                        return false;
                    }

                    if ($value['repaired'] == true && $value['action'] == null) {
                        $this->dispatchBrowserEvent('swal', [
                            'title' => 'Error',
                            'icon' => 'error',
                            'text' => "Tindakan Perbaikan tidak boleh kosong",
                        ]);
                        return false;
                    }

                    if ($value['due_date'] == null) {
                        $this->dispatchBrowserEvent('swal', [
                            'title' => 'Error',
                            'icon' => 'error',
                            'text' => "Target Waktu Penyelesaian tidak boleh kosong",
                        ]);
                        return false;
                    }

                    $riskCondition = $this->fieldLeadership->risks()->create([
                        'risk_condition' => $value['description'],
                        'category_id' => $value['category'],
                        'type_id' => $value['type'],
                        'potency_id' => $value['level'],
                        'repair_action' => $value['repaired'] == true ? $value['action'] : null,
                        'due_date' => Carbon::parse($value['due_date'])->format('Y-m-d'),
                        'type_action' => $value['repaired'] == true ? $value['type_action'] : null,
                        'supervisor' => $value['repaired'] == true ? $value['supervisor'] : null,
                        'status' => $publish != 'HR' ? FieldLeadershipType::Open : FieldLeadershipType::Close,
                    ]);

                    if ($publish == 'HR') {
                        $picaDocument = $riskCondition->pica()->create([
                            'source' => PicaSource::FieldLeadership,
                            'type' => $this->type,
                            'date' => Carbon::parse($this->date)->format('Y-m-d'),
                            'ccow_id' => $this->ccow_id,
                            'company_id' => $this->company_id,
                            'section_id' => $this->section_id,
                            'location_id' => $this->area_location_id,
                            'location_detail' => $this->detail_location,
                            'company_detail' => $this->detail_company,
                            'pja_id' => $this->pja_id,
                            'pjo_id' => $this->pjo_id,
                            'auditor' => null,
                            'non_compliance' => null,
                            'non_compliance_root_cause' => $this->non_compliance_root,
                            'corrective_action' => $value['action'],
                            'target_settlement_date' => Carbon::parse($value['due_date'])->format('Y-m-d'),
                            'settlement_date' => Carbon::parse($value['due_date'])->format('Y-m-d'),
                            'remarks' => null,
                            'status' => $this->fieldLeadership->status,
                        ]);

                        $picaDocument->pica()->create([
                            'source' => PicaSource::FieldLeadership,
                            'source_id' => $riskCondition->id,
                            'picaable_id' => $picaDocument->id,
                            'picaable_type' => FieldLeadershipRisk::class,
                        ]);
                    }

                    foreach ($value['files'] as $key => $file) {
                        if (!is_object($file['file'])) {
                            $full_path = $file['file'];
                        } else {
                            $path = 'field-leadership/' . $this->fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
                            $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                        }

                        $riskCondition->files()->create([
                            'file' => $full_path,
                            'size' => $file['size'],
                            'type' => FieldLeadershipType::RiskFinding
                        ]);


                        if ($publish == 'HR') {
                            $picaDocument->picaFiles()->create([
                                'file' => $full_path,
                                'size' => $file['size'],
                                'type' => FieldLeadershipType::RiskFinding
                            ]);
                        }
                    }

                    if ($value['repaired'] == true) {
                        foreach ($value['files_ca'] as $key => $file) {
                            if (!is_object($file['file'])) {
                                $full_path = $file['file'];
                            } else {
                                $path = 'field-leadership/' . $this->fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
                                $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                            }

                            $riskCondition->files()->create([
                                'file' => $full_path,
                                'size' => $file['size'],
                                'type' => FieldLeadershipType::CorrectiveAction
                            ]);

                            if ($publish == 'HR') {
                                $picaDocument->picaFiles()->create([
                                    'file' => $full_path,
                                    'size' => $file['size'],
                                    'type' => FieldLeadershipType::CorrectiveAction
                                ]);
                            }
                        }
                    }
                }
            }

            FieldLeadershipActivity::create([
                'fl_id' => $this->fieldLeadership->id,
                'description' => 'Update Field Leadership',
                'user_id' => Auth::user()->id,
            ]);

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('field-leadership::listing.active.index');
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);
        }
    }

    public function render()
    {
        return view('fieldleadership::livewire.listing.document.active.edit-active-field-leadership-page')->extends('fieldleadership::layouts.no-header');
    }
}
