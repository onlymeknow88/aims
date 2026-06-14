<?php

namespace Modules\FieldLeadership\Http\Livewire\Listing\Document\Active;

use App\Enums\CompanyType;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Enums\PicaSource;
use App\Mail\FieldLeadership\NewDocument;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipActivity;
use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Modules\FieldLeadership\Entities\FieldLeadershipParameter;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Modules\FieldLeadership\Jobs\NewDocumentMailJob;
use Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateActiveFieldLeadershipPage extends Component
{
    use WithFileUploads, LivewireAlert;

    public $limit_param;
    public $limit_member;

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

    public function mount()
    {
        $this->limit_param = FieldLeadershipParameter::first();

        $last = FieldLeadership::latest()->first();
        $this->latestUpdate = 'Update on ' . Carbon::parse($last->created_at ?? null)->format('F d, Y . H:i A');
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
                });
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
        // dd($propertyName, $value);
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

            $fieldLeadership = FieldLeadership::create([
                'number' => $this->generateNumber(),
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
                'created_by' => Auth::user()->employee?->id,
            ]);

            if ($this->type == 'Planned Task Observation') {
                $fieldLeadership->questions()->create([
                    'question' => $this->question1,
                    'answer' => $this->answer1,
                    'description' => $this->description1,
                ]);

                $fieldLeadership->questions()->create([
                    'question' => $this->question2,
                    'answer' => $this->answer2,
                    'description' => $this->description2,
                ]);

                $fieldLeadership->questions()->create([
                    'question' => $this->question3,
                    'answer' => '-',
                    'description' => $this->description3,
                ]);

                $fieldLeadership->questions()->create([
                    'question' => $this->question4,
                    'answer' => $this->answer4,
                    'description' => $this->description4,
                ]);

                $fieldLeadership->questions()->create([
                    'question' => $this->question5,
                    'answer' => $this->answer5,
                    'description' => $this->description5,
                ]);

                $fieldLeadership->questions()->create([
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
            foreach ($this->member as $key => $value) {
                if ($value['employee_id'] != null && $value['type'] != null) {
                    $fieldLeadership->members()->create([
                        'type' => $value['type'],
                        'employee_id' => $value['employee_id'],
                    ]);
                }
            }

            if ($this->type != 'Hazard Report') {
                foreach ($this->positive_condition as $key => $value) {
                    if ($value['description'] != null) {
                        $fieldLeadership->positives()->create([
                            'description' => $value['description'],
                        ]);
                    }
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

                $riskCondition = $fieldLeadership->risks()->create([
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
                        'status' => $fieldLeadership->status,
                    ]);

                    $picaDocument->pica()->create([
                        'source' => PicaSource::FieldLeadership,
                        'source_id' => $riskCondition->id,
                        'picaable_id' => $picaDocument->id,
                        'picaable_type' => FieldLeadershipRisk::class,
                    ]);
                }

                foreach ($value['files'] as $key => $file) {
                    $path = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
                    $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);

                    // dd($path);
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
                        $path = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
                        $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);

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

            FieldLeadershipActivity::create([
                'fl_id' => $fieldLeadership->id,
                'description' => 'Create Field Leadership',
                'user_id' => Auth::user()->id,
            ]);

            DB::commit();

            // $data_mail = [
            //     'name' => $fieldLeadership->pja->user->name,
            //     'email' => $fieldLeadership->pja->user->email,
            // ];
            // NewDocumentMailJob::dispatch($data_mail);

            // Mail::to($fieldLeadership->pja->user->email)->send(new NewDocument($fieldLeadership));

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            // $this->flash('success', 'Data berhasil di simpan', [
            //     'position' => 'top-end',
            //     'timer' => 3000,
            //     'toast' => true,
            // ]);

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
        return view('fieldleadership::livewire.listing.document.active.create-active-field-leadership-page')->extends('fieldleadership::layouts.no-header');
    }
}
