<?php

namespace Modules\FieldLeadership\Imports;

use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Models\AreaLocation;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;
use Modules\Mcu\Entities\FormulaBloodPressure;
use Modules\Mcu\Entities\FormulaDislipidemia;
use Modules\Mcu\Entities\MedicalHistory;
use Modules\Mcu\Entities\Provider;

class FieldLeadershipImport implements ToCollection, WithHeadingRow
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $question1 = "Apakah risiko yang ada di area Anda yang dapat membahayakan nyawa Anda?";
        $question2 = "Apakah tersedia pengendalian penting tersedia untuk melindungi Anda?";
        $question3 = "Bagaimana Anda mengetahui pengendalian penting tersebut efektif?";
        $question4 = "Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesesuaian dengan pekerjaan yang dilakukan?";
        $question5 = "Pekerja memahami SOP/INK/JSA tersebut?";
        $question6 = "Apakah ada opportunity untuk proses SOP/INK/JSA yang lebih efisien, produktif dan aman?";

        $group = $rows->groupBy('no');

        foreach ($group as $key => $item) {
            $data = collect($item)->first();

            // dd($data, $group);

            DB::beginTransaction();

            $ccow_id = Company::where('company_name', $data['ccow'])->first()->id;
            $company_id = Company::where('company_name', $data['company'])->first()->id;
            $detail_company = Company::where('company_name', $data['company'])->first()->type;
            $department_id = Department::where('name', $data['department'])->first()->id;
            $section_id = Section::where('name', $data['section'])->first()->id;
            $area_location_id = AreaLocation::where('name', $data['location'])->first()->id;
            $pja_id = User::where('name', $data['penanggung_jawab_area'])->first()->areaManager->id;
            $pjo_id = Company::where('company_name', $data['company'])->first()->user_id;


            $fieldLeadership = FieldLeadership::create([
                'number' => $this->generateNumber($company_id),
                'date' => Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['date']))->format('Y-m-d'),
                'ccow_id' => $ccow_id,
                'company_id' => $company_id,
                'detail_company' => $detail_company,
                'department_id' => $department_id,
                'section_id' => $section_id,
                'area_location_id' => $area_location_id,
                'detail_location' => $data['detail_location'],
                'personil_on_review' => $data['personil_yang_diamati'],
                'personil_on_review_name' => $data['nama_personil_yang_diamati'],
                'pja_id' => $pja_id,
                'pjo_id' => $pjo_id,
                'type' => $data['type'],
                'job' => $data['tugas_sop_wi_yang_diamati'],
                'visit_time' => $data['jumlah_waktu_kunjungan'],
                'non_compliance_root' => $data['non_compliance_root_cause'],
                'published' => 'Publish',
                'status' => FieldLeadershipType::Open,
                'requested' => FieldLeadershipType::RequestedPja,
                'created_by' => Auth::user()->employee?->id,
            ]);

            if ($this->type == 'Planned Task Observation') {
                $fieldLeadership->questions()->create([
                    'question' => $question1,
                    'answer' => $data['pertanyaan_ke_1'],
                    'description' => $data['pertanyaan_ke_1_keterangan'],
                ]);

                $fieldLeadership->questions()->create([
                    'question' => $question2,
                    'answer' => $data['pertanyaan_ke_2'],
                    'description' => $data['pertanyaan_ke_2_keterangan'],
                ]);

                $fieldLeadership->questions()->create([
                    'question' => $question3,
                    'answer' => '-',
                    'description' => $data['pertanyaan_ke_3_keterangan'],
                ]);

                $fieldLeadership->questions()->create([
                    'question' => $question4,
                    'answer' => $data['pertanyaan_ke_4'],
                    'description' => $data['pertanyaan_ke_4_keterangan'],
                ]);

                $fieldLeadership->questions()->create([
                    'question' => $question5,
                    'answer' => $data['pertanyaan_ke_5'],
                    'description' => $data['pertanyaan_ke_5_keterangan'],
                ]);

                $fieldLeadership->questions()->create([
                    'question' => $question6,
                    'answer' => $data['pertanyaan_ke_6'],
                    'description' => $data['pertanyaan_ke_6_keterangan'],
                ]);
            }

            foreach ($item->groupBy('members') as $key2 => $member) {
                $dataMember = collect($member)->first();

                $employee_id = Employee::where('name', 'LIKE', '%' . $dataMember['members'] . '%')
                    ->whereHas('user', function ($sql) use ($dataMember) {
                        $sql->whereHas('department', function ($query) use ($dataMember) {
                            $query->whereHas('company', function ($q) use ($dataMember) {
                                $q->where('type', $dataMember['type_member']);
                            });
                        });
                    })
                    ->first();

                if ($employee_id != null) {
                    $fieldLeadership->members()->create([
                        'employee_id' => $employee_id->id,
                        'type' => $dataMember['type_member'],
                    ]);
                }
            }

            if ($this->type != 'Hazard Report') {
                foreach ($item->groupBy('positive_condition') as $key2 => $positive) {
                    $datapositive = collect($positive)->first();

                    if ($datapositive['positive_condition'] != null) {
                        $fieldLeadership->positives()->create([
                            'description' => $datapositive['positive_condition'],
                        ]);
                    }
                }
            }

            foreach ($item->groupBy('risk_condition') as $key2 => $risk) {

                $datarisk = collect($risk)->first();
                // dd($datarisk);

                $category = FieldLeadershipCategory::where('name', $datarisk['category'])->first()->id;
                $type = FieldLeadershipKtaAndTta::where('name', $datarisk['type_kta_tta'])->first()->id;
                $potency = FieldLeadershipPotencyAndConsequnce::where('name', $datarisk['potency'])->first()->id;


                $fieldLeadership->risks()->create([
                    'risk_condition' => $datarisk['risk_condition'],
                    'category_id' => $category,
                    'type_id' => $type,
                    'potency_id' => $potency,
                    'repair_action' => $this->type != 'Hazard Report' ? ($datarisk['direct_repair_action'] == 'YA' ? $datarisk['repair_action'] : null) : null,
                    'due_date' => Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['due_date']))->format('Y-m-d'),
                    'type_action' => $this->type != 'Hazard Report' ? ($datarisk['direct_repair_action'] == 'YA' ? $datarisk['repair_action_type'] : null) : null,
                    'supervisor' => $this->type != 'Hazard Report' ? ($datarisk['direct_repair_action'] == 'YA' ? $datarisk['supervisor_name'] : null) : null,
                ]);
            }

            DB::commit();
        }
    }

    public function generateNumber($company_id)
    {
        $count = FieldLeadership::count();
        $company = Company::find($company_id);
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
}
