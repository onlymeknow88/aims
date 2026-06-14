<?php

namespace Modules\Kplh\Http\Controllers;

use App\Enums\CompanyType;
use App\Mail\kplh\RequestApprovalPJA;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Mail;
use Modules\FieldLeadership\Transformers\General\AreaLocationResource;
use Modules\FieldLeadership\Transformers\General\CompanyResource;
use Modules\FieldLeadership\Transformers\General\DepartmentResource;
use Modules\FieldLeadership\Transformers\General\SectionResource;
use Modules\Kplh\Entities\InspectionData;
use Modules\Kplh\Entities\KplhLabel;
use Modules\Kplh\Entities\KplhLabelIO;

// use Modules\Kplh\Transformers\Listing\KplhListResource;

class KplhController extends Controller
{
    public function getAllIn(Request $r)
    {
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $month = ($r->months) ? $r->months : null;
        $arrayMonth = $month ? explode(",", $month) : [];

        $selectedYear = ($r->years) ? $r->years : $thisYear;
        $arrayYear = explode(",", $selectedYear);

        $company_id = ($r->companies) ? $r->companies : null;
        $arrayCompanyId = $company_id ? explode(",", $company_id) : [];

        //tahun sekarang
        $dataThisYear = KplhLabel::whereRaw('YEAR(date) in (' . $thisYear . ')');
        $dataThisYear = $dataThisYear->count();

        $dataThisMonth = KplhLabel::whereRaw('YEAR(date) in (' . $thisYear . ')');
        $dataThisMonth = $dataThisMonth->whereRaw('MONTH(date) in (' . $thisMonth . ')');
        $dataThisMonth = $dataThisMonth->count();
        $q = $dataThisMonth;

        $ytd = $dataThisYear;
        $ytd_target = $dataThisYear;
        $this_month = $dataThisMonth;
        $this_year = $dataThisYear;

        //tahun lalu dibulan yang sama
        $dataPastYear = KplhLabel::whereRaw('YEAR(date) in (' . $thisYear - 1 . ')');
        $dataPastYear = $dataPastYear->count();

        $dataPastMonth = KplhLabel::whereRaw('YEAR(date) in (' . $thisYear - 1 . ')');
        $dataPastMonth = $dataPastMonth->whereRaw('MONTH(date) in (' . $thisMonth . ')');
        $dataPastMonth = $dataPastMonth->count();

        $past_month_percentage = $dataPastYear;
        $past_year_percentage = $dataPastYear;
        $percentage_yearly_target = $dataPastYear;
        $percentage_yearly_actual = $dataPastYear;

        $annual = $q;

        //progress
        //draf
        $dataNotDrafThisYear = KplhLabel::whereRaw('YEAR(date) in (' . $thisYear . ')')
            ->where('status', '!=', 'draft');
        $dataNotDrafThisYear = $dataNotDrafThisYear->count();

        $actual  =  $dataNotDrafThisYear & $dataThisYear ? round(($dataNotDrafThisYear / $dataThisYear * 100), 0) : 0;
        $target = $actual ? 100 - $actual : 0;

        // By Month
        $dataMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $m = $thisYear . '-' . $i . '-1';
            $monthName = date('M', strtotime($m));
            $data = KplhLabel::whereRaw('YEAR(date) in (' . $thisYear . ')');
            $data = $data->whereMonth('date', $i);
            //$data = $data->where('status', '!=', 'draft');
            //$q_target = 'AND lb.status = "draft"';
            //$q_actual = 'AND lb.status != "draft"';
            $dataMonth[$monthName] = [
                'month' => $i,
                'target' => 0,
                'actual' => $data->count()
            ];
        }

        //filter by month
        if (count($arrayMonth) > 0) {
            $dataMonth = collect($dataMonth)->whereIn('month', $arrayMonth);
            $dataMonth->all();
        }

        $category = KplhLabel::groupBy('inspect_criteria')->get([DB::raw('inspect_criteria as name')]);
        $categoryAll = [];
        foreach ($category as $list) {
            $type =  $list['name'];
            $count = KplhLabel::where('inspect_criteria', $type)
                ->whereRaw('YEAR(date) in (' . $selectedYear . ')');

            if (count($arrayCompanyId) > 0) {
                $count = $count->whereIn('company_id', $arrayCompanyId);
            }

            $count = $count->count();
            $categoryAll[] = [
                'name' => ucwords(str_replace("-", " ", $list['name'])),
                'value' => $count && $dataThisYear ?  round($count / $dataThisYear * 100, 0) : 0,
                'count' => $count,
            ];
        }

        return response()->json([
            'count_ytd' => [
                'ytd' => $ytd,
                'ytd_target' => $ytd_target,
            ],
            'progress' => [
                'target' => [
                    'complete' => $target,
                    'ongoing' => $actual
                ],
                'actual' => [
                    'complete' => $actual,
                    'ongoing' => $target
                ]
            ],
            'completion_by_month' => $dataMonth,
            'count_annual' => $annual,
            'count_monthly' => [
                'this_month' => $this_month,
                'past_month_percentage' => $past_month_percentage,
            ],
            'count_yearly' => [
                'this_year' => $this_year,
                'past_year_percentage' => $past_year_percentage,
            ],
            'percentage_yearly' => [
                'target' => $percentage_yearly_target,
                'actual' => $percentage_yearly_actual,
            ],
            'count_by_category' => $categoryAll,
            'percentage_by_category' => $categoryAll,

        ], 200);
    }

    public function getUserStats(Request $r)
    {
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $month = ($r->month) ? $r->month : $thisMonth;
        $selectedYear = ($r->year) ? $r->year : $thisYear;
        $company_id = ($r->company) ? $r->company : null;
        $annual = KplhLabel::count();

        $makerStats = DB::select("SELECT u.id AS `user_id`,e.id_number AS employee_number,e.name AS employee_name, u.name AS `user_name`,e.position,d.name AS department,
                                    (SELECT COUNT(*) FROM kplh_label WHERE kplh_label.status = 'draft' AND kplh_label.maker_id = u.id) AS `target`,
                                    (SELECT COUNT(*) FROM kplh_label WHERE kplh_label.status = 'active' AND kplh_label.maker_id = u.id) AS `actual`,
                                    ('maker') AS grade,
                                    kl.created_at AS document_created
                                FROM kplh_label kl
                                JOIN users u ON kl.maker_id = u.id
                                JOIN employees e ON u.id = e.user_id
                                JOIN departments d ON d.id = e.department_id
                                GROUP BY u.name");
        // grade = pja/pjo/maker
        // document_created

        $pjaStats = DB::select("SELECT u.id AS `user_id`, e.id_number AS employee_number,e.name AS employee_name,  u.name AS `user_name`,e.position,d.name AS department,
                                    (SELECT COUNT(*) FROM kplh_label WHERE kplh_label.status = 'active' AND kplh_label.pja_id = am.id) AS `target`,
                                    (SELECT COUNT(*) FROM kplh_label WHERE kplh_label.status = 'approved' AND kplh_label.pja_id = am.id) AS `actual`,
                                    ('pja') AS grade,
                                    kl.created_at AS document_created
                                FROM kplh_label kl
                                LEFT JOIN area_managers am ON kl.pja_id = am.id
                                LEFT JOIN users u ON am.user_id = u.id
                                LEFT JOIN employees e ON u.id = e.user_id
                                LEFT JOIN departments d ON d.id = e.department_id
                                GROUP BY u.name");

        return response()->json(array_merge($makerStats, $pjaStats), 200);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('kplh::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function submit(Request $request)
    {
        try {
            $mode = $request->mode;
            $type = $request->type ? $request->type : ($request->inspect_criteria ? $request->inspect_criteria : null);
            // $type = $request->type;
            $date = Carbon::parse($request->date)->format('d-m-Y');
            $ccow_id = $request->ccow_id;
            $company_id = $request->company_id;
            $department_id = $request->department_id;
            $section_id = $request->section_id;
            $area_location_id = $request->area_location_id;
            $location_detail = $request->location_detail;
            $pja_id = $request->pja_id;
            $ktt_id = $request->ktt_id;
            $inspection_officers = $request->inspection_officers;
            $summary = $request->summary;

            $request->validate([
                'mode' => 'required',
                // 'type' => 'required',
                'date' => 'required',
                'ccow_id' => 'required',
                'company_id' => 'required',
                'department_id' => 'required',
                'section_id' => 'required',
                'area_location_id' => 'required',
                'location_detail' => 'nullable',
                'pja_id' => 'required',
                'ktt_id' => 'nullable',
                'inspection_officers.*.employee_id' => 'required',
            ]);

            if ($mode == 'draft') {
                $status = 'draft';
            } elseif ($mode == 'save') {

                foreach ($request->inspection_data as $data) {

                    if ($type == 'food-hygiene' || $type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {

                        if (!isset($data['value'])) {
                            return response()->json([
                                'status' => 'error',
                                'msg' => 'value ' . $data['criteria'] . ' belum diisi',
                            ], 200);
                        }
                    } else {

                        if (!isset($data['k3_value'])) {
                            return response()->json([
                                'status' => 'error',
                                'msg' => 'value ' . $data['criteria'] . ' belum diisi',
                            ], 200);
                        }
                    }
                }

                $status = 'active';
            }

            if ($request->id) { // Update
                DB::beginTransaction();

                $label = KplhLabel::find($request->id);

                $date = Carbon::parse($date);

                $labeldata = [
                    'company_id' => $company_id,
                    'department_id' => $department_id,
                    'section_id' => $section_id,
                    'ccow_id' => $ccow_id,
                    'date' => $date,
                    'area_location_id' => $area_location_id,
                    'location_detail' => $location_detail,
                    'ktt_id' => $ktt_id,
                    'pja_id' => $pja_id,
                    'status' => $status,
                    'summary' => $summary,
                ];

                $label->update($labeldata);

                if (!empty($inspection_officers)) {
                    $label_io = $label->inspection_officers;

                    foreach ($label_io as $lio) {
                        $x = KplhLabelIO::find($lio->id)->delete();
                    }

                    foreach ($inspection_officers as $io) {
                        $labeliodata = [
                            'label_id' => $label->id,
                            'employee_id' => $io['employee_id'],
                        ];

                        $label_io_store = KplhLabelIO::create($labeliodata);
                    }
                }

                if ($request->inspection_data) {
                    foreach ($request->inspection_data as $InspectionData) {
                        if ($type == 'food-hygiene' || $type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {
                            $InspectionDataValue = $InspectionData['value'];

                            if ($type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {
                                $InspectionData['k3_value'] = $InspectionData['value'];
                            }
                        } else {
                            if (in_array('k3_value_3', $InspectionData)) {
                                $InspectionDataValue = $InspectionData['k3_value_2'];
                            } else {
                                $InspectionDataValue = $InspectionData['k3_value'];
                            }
                        }

                        if (isset($InspectionDataValue)) {

                            // K3 Only
                            if ($InspectionData['criteria'] == 'tool_id') {
                                $label->update([
                                    'tool_id' => $InspectionDataValue,
                                ]);
                            } elseif ($InspectionData['criteria'] == 'tool_date') {
                                $label->update([
                                    'tool_date' => $InspectionDataValue ? Carbon::parse($InspectionDataValue) : null,
                                ]);
                            } elseif ($InspectionData['criteria'] == 'tool_type') {
                                $label->update([
                                    'tool_type' => $InspectionDataValue,
                                ]);
                            }
                            // K3 Only

                            $InspectionData['label_id'] = $label->id;

                            // Create Kplh Data & PICA
                            $kplh_data = InspectionData::where('label_id', $label->id)->where('criteria', $InspectionData['criteria'])->first();

                            if ($kplh_data) {
                                $kplh_data->update($InspectionData);
                            } else {
                                $kplh_data = InspectionData::create($InspectionData);
                            }

                            if ($status != 'draft') {
                                if ($type == 'food-hygiene') {
                                    if ($InspectionDataValue < 10) {
                                        $pica = $this->toPica($label, $InspectionData, $kplh_data, $InspectionDataValue);
                                    }
                                }

                                if ($type == 'workplace' || $type == 'area-maintank' || $type == 'area-jetty') {
                                    if ($InspectionDataValue == 'Tidak') {
                                        $pica = $this->toPica($label, $InspectionData, $kplh_data, $InspectionDataValue);
                                    }
                                }

                                if ($type == 'k3-apar' || $type == 'k3-apab' || $type == 'k3-hydrant' || $type == 'k3-hose-rail' || $type == 'k3-eye-wash') {
                                    if ($InspectionDataValue == 'Tidak Standard' || $InspectionDataValue == 'Tidak Ada' || $InspectionDataValue == 'Warna Demarkasi Pudar' || $InspectionDataValue == 'Perlu Penggantian' || $InspectionDataValue == 'Terdapat Penghalang') {
                                        $pica = $this->toPica($label, $InspectionData, $kplh_data, $InspectionDataValue);
                                    }
                                }
                            }
                            // END PICA
                        }
                    }
                }
                $label_store = $label;
                DB::commit();
            } else { // Add
                DB::beginTransaction();

                $count_label = KplhLabel::withTrashed()->count();
                $date = Carbon::parse($date);

                if ($type == 'k3-apar' || $type == 'k3-apab' || $type == 'k3-hydrant' || $type == 'k3-hose-rail' || $type == 'k3-eye-wash') {
                    $inspect_id = 'INSP-ALK3-' . $date->format('dmY') . '-' . (sprintf("%06d", ($count_label + 1))) . '';
                } else {
                    $inspect_id = 'INSP-' . $date->format('dmY') . '-' . (sprintf("%06d", ($count_label + 1))) . '';
                }

                $labeldata = [
                    'company_id' => $company_id,
                    'department_id' => $department_id,
                    'section_id' => $section_id,
                    'maker_id' => Auth::user()->id,
                    'inspect_id' => $inspect_id,
                    'inspect_criteria' => $type,
                    'ccow_id' => $ccow_id,
                    'date' => $date,
                    'area_location_id' => $area_location_id,
                    'location_detail' => $location_detail,
                    'ktt_id' => $ktt_id,
                    'pja_id' => $pja_id,
                    'status' => $status,
                    'summary' => $summary,
                ];

                $label_store = KplhLabel::create($labeldata);

                if ($inspection_officers) {
                    foreach ($inspection_officers as $io) {
                        $labeliodata = [
                            'label_id' => $label_store->id,
                            'employee_id' => $io['employee_id'],
                        ];
                        $label_io_store = KplhLabelIO::create($labeliodata);
                    }
                } else {
                    $label_io_store = null;
                }

                if ($request->inspection_data) {
                    foreach ($request->inspection_data as $InspectionData) {
                        if ($type == 'food-hygiene' || $type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {
                            $InspectionDataValue = $InspectionData['value'];

                            if ($type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {
                                $InspectionData['k3_value'] = $InspectionData['value'];
                            }
                        } else {
                            if (in_array('k3_value_3', $InspectionData)) {
                                $InspectionDataValue = $InspectionData['k3_value_2'];
                            } else {
                                $InspectionDataValue = $InspectionData['k3_value'];
                            }
                        }

                        if (isset($InspectionDataValue)) {

                            // K3 Only
                            if ($InspectionData['criteria'] == 'tool_id') {
                                $label_store->update([
                                    'tool_id' => $InspectionDataValue,
                                ]);
                            } elseif ($InspectionData['criteria'] == 'tool_date') {
                                $label_store->update([
                                    'tool_date' => $InspectionDataValue ? Carbon::parse($InspectionDataValue) : null,
                                ]);
                            } elseif ($InspectionData['criteria'] == 'tool_type') {
                                $label_store->update([
                                    'tool_type' => $InspectionDataValue,
                                ]);
                            }
                            // K3 Only

                            $InspectionData['label_id'] = $label_store->id;

                            // Create Kplh Data & PICA
                            $kplh_data = InspectionData::create($InspectionData);

                            if ($status != 'draft') {
                                if ($type == 'food-hygiene') {
                                    if ($InspectionDataValue < 10) {
                                        $pica = $this->toPica($label_store, $InspectionData, $kplh_data, $InspectionDataValue);
                                    }
                                }

                                if ($type == 'workplace' || $type == 'area-maintank' || $type == 'area-jetty') {
                                    if ($InspectionDataValue == 'Tidak') {
                                        $pica = $this->toPica($label_store, $InspectionData, $kplh_data, $InspectionDataValue);
                                    }
                                }

                                if ($type == 'k3-apar' || $type == 'k3-apab' || $type == 'k3-hydrant' || $type == 'k3-hose-rail' || $type == 'k3-eye-wash') {
                                    if ($InspectionDataValue == 'Tidak Standard' || $InspectionDataValue == 'Tidak Ada' || $InspectionDataValue == 'Warna Demarkasi Pudar' || $InspectionDataValue == 'Perlu Penggantian' || $InspectionDataValue == 'Terdapat Penghalang') {
                                        $pica = $this->toPica($label_store, $InspectionData, $kplh_data, $InspectionDataValue);
                                    }
                                }
                            }
                            // END PICA
                        }
                    }
                }

                DB::commit();
            }

            if ($mode == 'save') {
                $sendmail = Mail::to($label_store->pja->user->email)->send(new RequestApprovalPJA($label_store));
            }

            return response()->json($label_store, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Internal Server Error',
                'detail' => $th->getMessage(),
            ], 500);
        }
    }
    public function submit_bundle(Request $request)
    {
        try {
            $datas = json_decode($request->getContent());

            // $label_stores = [];
            $i_ = -1;
            foreach ($datas as $request) {
                $i_++;

                $mode = $request->mode;
                $type = (property_exists($request, "type")) ? $request->type : (property_exists($request, "inspect_criteria") ? $request->inspect_criteria : null);
                $date = Carbon::parse($request->date)->format('d-m-Y');
                $ccow_id = $request->ccow_id;
                $company_id = $request->company_id;
                $department_id = $request->department_id;
                $section_id = $request->section_id;
                $area_location_id = $request->area_location_id;
                $location_detail = $request->location_detail;
                $pja_id = $request->pja_id;
                $ktt_id = $request->ktt_id;
                $inspection_officers = $request->inspection_officers;
                $summary = $request->summary;

                $rules = [
                    'mode' => 'required',
                    // 'type' => 'required',
                    'date' => 'required',
                    'ccow_id' => 'required',
                    'company_id' => 'required',
                    'department_id' => 'required',
                    'section_id' => 'required',
                    'area_location_id' => 'required',
                    'location_detail' => 'nullable',
                    'pja_id' => 'required',
                    'ktt_id' => 'nullable',
                    'inspection_officers.*.employee_id' => 'required',
                ];

                $validator = Validator::make(json_decode(json_encode($request), true), $rules);
                if (!$validator->passes()) {
                    // dd($validator->errors()->all());
                    return response()->json([
                        'status' => 'error',
                        'msg' => $validator->errors()->all(),
                    ], 200);
                }

                if ($mode == 'draft') {
                    $status = 'draft';
                } elseif ($mode == 'save') {

                    foreach ($request->inspection_data as $data) {
                        $data = json_decode(json_encode($data), true);
                        if ($type == 'food-hygiene' || $type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {

                            if (!isset($data['value'])) {
                                return response()->json([
                                    'status' => 'error',
                                    'msg' => 'value ' . $data['criteria'] . ' belum diisi',
                                ], 200);
                            }
                        } else {

                            if (!isset($data['k3_value'])) {
                                return response()->json([
                                    'status' => 'error',
                                    'msg' => 'value ' . $data['criteria'] . ' belum diisi',
                                ], 200);
                            }
                        }
                    }

                    $status = 'active';
                }

                if (property_exists($request, "id")) { // Update
                    DB::beginTransaction();

                    $label = KplhLabel::find($request->id);

                    $date = Carbon::parse($date);

                    $labeldata = [
                        'company_id' => $company_id,
                        'department_id' => $department_id,
                        'section_id' => $section_id,
                        'ccow_id' => $ccow_id,
                        'date' => $date,
                        'area_location_id' => $area_location_id,
                        'location_detail' => $location_detail,
                        'ktt_id' => $ktt_id,
                        'pja_id' => $pja_id,
                        'status' => $status,
                        'summary' => $summary,
                    ];

                    $label->update($labeldata);

                    if (!empty($inspection_officers)) {
                        $label_io = $label->inspection_officers;

                        foreach ($label_io as $lio) {
                            $x = KplhLabelIO::find($lio->id)->delete();
                        }

                        foreach ($inspection_officers as $io) {
                            $labeliodata = [
                                'label_id' => $label->id,
                                'employee_id' => $io->employee_id,
                            ];

                            $label_io_store = KplhLabelIO::create($labeliodata);
                        }
                    }

                    if ($request->inspection_data) {
                        foreach ($request->inspection_data as $InspectionDataX) {
                            $InspectionData = json_decode(json_encode($InspectionDataX), true);
                            if ($type == 'food-hygiene' || $type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {
                                $InspectionDataValue = $InspectionData['value'];

                                if ($type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {
                                    $InspectionData['k3_value'] = $InspectionData['value'];
                                }
                            } else {
                                if (in_array('k3_value_3', $InspectionData)) {
                                    $InspectionDataValue = $InspectionData['k3_value_2'];
                                } else {
                                    $InspectionDataValue = $InspectionData['k3_value'];
                                }
                            }

                            if (isset($InspectionDataValue)) {

                                $InspectionData['label_id'] = $label->id;

                                // Create Kplh Data & PICA
                                $kplh_data = InspectionData::where('label_id', $label->id)->where('criteria', $InspectionData['criteria'])->first();

                                if ($kplh_data) {
                                    $kplh_data->update($InspectionData);
                                } else {
                                    $kplh_data = InspectionData::create($InspectionData);
                                }

                                if ($status != 'draft') {
                                    if ($type == 'food-hygiene') {
                                        if ($InspectionDataValue < 10) {
                                            $pica = $this->toPica($label, $InspectionData, $kplh_data, $InspectionDataValue);
                                        }
                                    }

                                    if ($type == 'workplace' || $type == 'area-maintank' || $type == 'area-jetty') {
                                        if ($InspectionDataValue == 'Tidak') {
                                            $pica = $this->toPica($label, $InspectionData, $kplh_data, $InspectionDataValue);
                                        }
                                    }

                                    if ($type == 'k3-apar' || $type == 'k3-apab' || $type == 'k3-hydrant' || $type == 'k3-hose-rail' || $type == 'k3-eye-wash') {
                                        if ($InspectionDataValue == 'Tidak Standard' || $InspectionDataValue == 'Tidak Ada' || $InspectionDataValue == 'Warna Demarkasi Pudar' || $InspectionDataValue == 'Perlu Penggantian' || $InspectionDataValue == 'Terdapat Penghalang') {
                                            $pica = $this->toPica($label, $InspectionData, $kplh_data, $InspectionDataValue);
                                        }
                                    }
                                }
                                // END PICA
                            }
                        }
                    }

                    $label_store = $label;
                    $label_stores[$i_] = [$label_store];

                    DB::commit();
                } else { // Add
                    DB::beginTransaction();

                    $count_label = KplhLabel::withTrashed()->count();
                    $date = Carbon::parse($date);

                    if ($type == 'k3-apar' || $type == 'k3-apab' || $type == 'k3-hydrant' || $type == 'k3-hose-rail' || $type == 'k3-eye-wash') {
                        $inspect_id = 'INSP-ALK3-' . $date->format('dmY') . '-' . (sprintf("%06d", ($count_label + 1))) . '';
                    } else {
                        $inspect_id = 'INSP-' . $date->format('dmY') . '-' . (sprintf("%06d", ($count_label + 1))) . '';
                    }

                    $labeldata = [
                        'company_id' => $company_id,
                        'department_id' => $department_id,
                        'section_id' => $section_id,
                        'maker_id' => Auth::user()->id,
                        'inspect_id' => $inspect_id,
                        'inspect_criteria' => $type,
                        'ccow_id' => $ccow_id,
                        'date' => $date,
                        'area_location_id' => $area_location_id,
                        'location_detail' => $location_detail,
                        'ktt_id' => $ktt_id,
                        'pja_id' => $pja_id,
                        'status' => $status,
                        'summary' => $summary,
                    ];

                    $label_store = KplhLabel::create($labeldata);

                    if ($inspection_officers) {
                        foreach ($inspection_officers as $io) {
                            $labeliodata = [
                                'label_id' => $label_store->id,
                                'employee_id' => $io->employee_id,
                            ];

                            $label_io_store = KplhLabelIO::create($labeliodata);
                        }
                    } else {
                        $label_io_store = null;
                    }

                    if ($request->inspection_data) {
                        foreach ($request->inspection_data as $InspectionDataX) {
                            $InspectionData = json_decode(json_encode($InspectionDataX), true);
                            if ($type == 'food-hygiene' || $type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {
                                $InspectionDataValue = $InspectionData['value'];

                                if ($type == 'area-maintank' || $type == 'area-jetty' || $type == 'workplace') {
                                    $InspectionData['k3_value'] = $InspectionData['value'];
                                }
                            } else {
                                if (in_array('k3_value_3', $InspectionData)) {
                                    $InspectionDataValue = $InspectionData['k3_value_2'];
                                } else {
                                    $InspectionDataValue = $InspectionData['k3_value'];
                                }
                            }

                            if (isset($InspectionDataValue)) {

                                $InspectionData['label_id'] = $label_store->id;

                                // Create Kplh Data & PICA
                                $kplh_data = InspectionData::create($InspectionData);

                                if ($status != 'draft') {
                                    if ($type == 'food-hygiene') {
                                        if ($InspectionDataValue < 10) {
                                            $pica = $this->toPica($label_store, $InspectionData, $kplh_data, $InspectionDataValue);
                                        }
                                    }

                                    if ($type == 'workplace' || $type == 'area-maintank' || $type == 'area-jetty') {
                                        if ($InspectionDataValue == 'Tidak') {
                                            $pica = $this->toPica($label_store, $InspectionData, $kplh_data, $InspectionDataValue);
                                        }
                                    }

                                    if ($type == 'k3-apar' || $type == 'k3-apab' || $type == 'k3-hydrant' || $type == 'k3-hose-rail' || $type == 'k3-eye-wash') {
                                        if ($InspectionDataValue == 'Tidak Standard' || $InspectionDataValue == 'Tidak Ada' || $InspectionDataValue == 'Warna Demarkasi Pudar' || $InspectionDataValue == 'Perlu Penggantian' || $InspectionDataValue == 'Terdapat Penghalang') {
                                            $pica = $this->toPica($label_store, $InspectionData, $kplh_data, $InspectionDataValue);
                                        }
                                    }
                                }
                                // END PICA
                            }
                        }
                    }

                    $label_stores[$i_] = [$label_store];
                    DB::commit();
                }

                if ($mode == 'save') {
                    $sendmail = Mail::to($label_store->pja->user->email)->send(new RequestApprovalPJA($label_store));
                }
            }
            return response()->json($label_stores, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Internal Server Error',
                'detail' => $th->getMessage(),
            ], 500);
        }
    }

    public function submit_update(Request $request)
    {
    }

    private function toPica($label_store, $InspectionData, $kplh_data, $InspectionDataValue)
    {
        if (empty($InspectionData['file'])) {
            return response()->json([
                'status' => 'error',
                'msg' => 'File ' . $InspectionData['criteria'] . ' wajib diisi',
            ], 200);
        }

        if (empty($InspectionData['note'])) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Note ' . $InspectionData['criteria'] . ' wajib diisi',
            ], 200);
        }

        // $riskCondition = $kplh_data->risks()->create([
        //     'kplh_data_id' => $kplh_data->id,
        //     'risk_value' => $InspectionDataValue,
        //     'risk_condition' => $kplh_data->note,
        // ]);

        // $picaDocument = $riskCondition->pica()->create([
        //     'source' => PicaSource::InspeksiKPLH, // buat enum
        //     'type' => 'food-hygiene',
        //     'ccow_id' => $label_store->ccow_id,
        //     'company_id' => $label_store->company_id,
        //     'section_id' => $label_store->section_id,
        //     'pja_id' => $label_store->pja_id,
        //     'pjo_id' => $label_store->ktt_id,
        // ]);

        // $picaDocument->pica()->create([
        //     'source' => 'Inspeksi KPLH',
        //     'source_id' => $riskCondition->id,
        //     'picaable_id' => $picaDocument->id,
        //     'picaable_type' => InspectionRisks::class,
        // ]);

        // if (isset($kplh_data->file)) {
        //     $picaDocument->picaFiles()->create([
        //         'file' => $kplh_data->file,
        //         'size' => null,
        //         'type' => null,
        //     ]);
        // }

        $picaDocument = true;
        return $picaDocument;
    }

    public function uploadFile()
    {
        $type = request()->type;
        $criteria = request()->criteria;
        $file = request()->file('file');
        $filetype = $file->getClientOriginalExtension();

        $date = Carbon::now()->format('dmy_his');
        $file_name = "$criteria-$date-mobile.$filetype";

        if ($type == 'food-hygiene') {
            $path = $file->storeAs('kplh/food_hygiene', $file_name, ['disk' => 'local']);
        } elseif ($type == 'area-maintank') {
            $path = $file->storeAs('kplh/maintank', $file_name, ['disk' => 'local']);
        } elseif ($type == 'area-jetty') {
            $path = $file->storeAs('kplh/jetty', $file_name, ['disk' => 'local']);
        } elseif ($type == 'workplace') {
            $path = $file->storeAs('kplh/workplace', $file_name, ['disk' => 'local']);
        } elseif ($type == 'k3') {
            $path = $file->storeAs('kplh/k3', $file_name, ['disk' => 'local']);
        }

        return response()->json([
            'status' => 'success',
            'data' =>
            [
                'path' => $path,
                'file_name' => $file_name,
            ],
        ]);
    }

    public function getInspectionLists(Request $r)
    {
        // dd(auth()->user()->name);
        // if ($r->type == 'food-hygiene') {

        //     if ($r->limit > 0) {
        //         $data = KplhLabel::where('inspect_criteria', 'food-hygiene')->with('inspection_data')->orderBy('created_at', 'ASC')->paginate($r->limit);
        //     } else {
        //         $data = KplhLabel::where('inspect_criteria', 'food-hygiene')->with('inspection_data')->orderBy('created_at', 'ASC')->get();
        //     }

        // } elseif ($r->type == 'area-maintank') {
        //     $data = [
        //         [
        //             'criteria' => 'criteria_1',
        //             'option' => [
        //                 0, 5, 10,
        //             ],
        //             'question' => 'bbbb',
        //         ],
        //     ];
        // }

        if ($r->limit > 0) {
            $data = KplhLabel::where('inspect_criteria', $r->type)->orderBy('created_at', 'ASC')->paginate($r->limit);
        } else {
            $data = KplhLabel::where('inspect_criteria', $r->type)->orderBy('created_at', 'ASC')->get();
        }

        return response()->json($data);
    }

    public function getForms(Request $r)
    {
        try {
            $data = file_get_contents("" . public_path() . "/modules/kplh/question.json");
            $data = json_decode($data, true);
            $data = $data[$r->type];
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 404,
            ], 200);
        }

        return response()->json($data);
    }

    public function getCcows(): AnonymousResourceCollection
    {
        $ccows = Company::where('type', CompanyType::Internal)->get();

        return CompanyResource::collection($ccows);
    }

    public function getCompanies(): AnonymousResourceCollection
    {
        $company = Company::all();

        return CompanyResource::collection($company);
    }

    public function getDepartments($id): AnonymousResourceCollection
    {
        $department = Department::where('company_id', $id)->get();

        return DepartmentResource::collection($department);
    }

    public function getSections($id): AnonymousResourceCollection
    {
        $section = Section::where('department_id', $id)->get();

        return SectionResource::collection($section);
    }

    public function getAreaLocations($id): AnonymousResourceCollection
    {
        $area_location = AreaLocation::where('section_id', $id)->get();

        return AreaLocationResource::collection($area_location);
    }

    public function getPJA($id)
    {
        $area_managers = AreaManager::where('section_id', $id)->get();

        $data = [];
        $i = -1;
        foreach ($area_managers as $am) {
            if ($am->user->employee) {
                $i++;
                $data[$i] = [
                    'id' => $am->id,
                    'name' => $am->user->employee->name,
                    'section' => $am->section->name,
                    'is_active' => $am->is_active == 1 ? 'Active' : 'Inactive',
                ];
            }
        }

        return response()->json(["data" => $data]);
    }

    public function getKTT($id)
    {
        $company = Company::find($id);
        $employee = Employee::where('user_id', $company->user_id)->first();

        return response()->json([
            'id' => $employee->user->id,
            'company_name' => $employee->user->department->company->company_name ?? null,
            'department_name' => $employee->user->department->name ?? null,
            'name' => $employee->name,
            'number' => $employee->number,
            'id_number' => $employee->id_number,
            'date_of_birth' => $employee->date_of_birth,
            'gender' => $employee->gender,
            'blood_type' => $employee->blood_type,
            'marital_status' => $employee->marital_status,
            'employee_status' => $employee->employee_status,
            'company' => $employee->user->company->company_name,
            'department' => $employee->user->department->name,
            'position' => $employee->position,
        ]);
    }

    public function getInspection($id)
    {
        $inspection = KplhLabel::find($id);
        $inspection_data = [];
        $inspection_officers = [];

        $inspection_label = [
            'id' => $inspection->id,
            "date" => $inspection->date,
            "maker_id" => $inspection->maker_id,
            "company_id" => $inspection->company_id,
            "department_id" => $inspection->department_id,
            "section_id" => $inspection->section_id,
            "ccow_id" => $inspection->ccow_id,
            "pja_id" => $inspection->pja_id,
            "ktt_id" => $inspection->ktt_id,
            "inspect_id" => $inspection->inspect_id,
            "inspect_criteria" => $inspection->inspect_criteria,
            "area_location_id" => $inspection->area_location_id,
            "location_detail" => $inspection->location_detail,
            "summary" => $inspection->summary,
            "status" => $inspection->status,
        ];

        if ($inspection->inspection_officers) {
            $i = -1;
            foreach ($inspection->inspection_officers as $io) {
                $i++;
                $inspection_officers[$i]['employee_id'] = $io->employee_id;
            }
        }

        if ($inspection->inspection_data) {
            $i = -1;
            foreach ($inspection->inspection_data as $data) {
                $i++;

                $inspection_data[$i]['criteria'] = $data->criteria;

                if ($inspection->inspect_criteria == 'food-hygiene') {
                    $inspection_data[$i]['value'] = $data->value;
                } elseif ($inspection->inspect_criteria == 'workplace' || $inspection->inspect_criteria == 'area-maintank' || $inspection->inspect_criteria == 'area-jetty') {
                    $inspection_data[$i]['value'] = $data->k3_value;
                } else {
                    $inspection_data[$i]['k3_value'] = $data->k3_value;

                    if ($data->criteria == 'tuas_apar' || $data->criteria == 'handle_apar' || $data->criteria == 'pressure_gauge' || $data->criteria == 'pin_apar' || $data->criteria == 'hose_apar' || $data->criteria == 'nozzle_apar' || $data->criteria == 'kondisi_tabung' || $data->criteria == 'cat_tabung' || $data->criteria == 'powder' || $data->criteria == 'bracket' || $data->criteria == 'penempatan' || $data->criteria == 'tuas_apab' || $data->criteria == 'handle_apab' || $data->criteria == 'pressure_gauge' || $data->criteria == 'pin_apab' || $data->criteria == 'hose_apab' || $data->criteria == 'nozzle_apab' || $data->criteria == 'troli_apab' || $data->criteria == 'box_hydrant' || $data->criteria == 'kip' || $data->criteria == 'velve_pipa' || $data->criteria == 'box_hr' || $data->criteria == 'kondisi_tangki' || $data->criteria == 'kondisi_air' || $data->criteria == 'pancuran_air') {
                        $inspection_data[$i]['k3_value_2'] = $data->k3_value_2;
                    } elseif ($data->criteria == 'ukuran_coupling' || $data->criteria == 'hose_hydrant' || $data->criteria == 'type_nozzle' || $data->criteria == 'jenis_hose_rail') {
                        $inspection_data[$i]['k3_value_2'] = $data->k3_value_2;
                        $inspection_data[$i]['k3_value_3'] = $data->k3_value_3;
                    }
                }

                $inspection_data[$i]['file'] = $data->file;
                $inspection_data[$i]['note'] = $data->note;
            }

            // dd(array_key_exists("tool_id",$inspection_data[$i]));
            if ($inspection->tool_id) {
                $x = $this->searchArrayKey('tool_id', $inspection_data);
                if (!$x) {
                    $i++;
                    $inspection_data[$i]['criteria'] = 'tool_id';
                    $inspection_data[$i]['k3_value'] = $inspection->tool_id;
                    $inspection_data[$i]['file'] = null;
                    $inspection_data[$i]['note'] = null;
                }
            }
            if ($inspection->tool_date) {
                $x = $this->searchArrayKey('tool_date', $inspection_data);
                if (!$x) {
                    $i++;
                    $inspection_data[$i]['criteria'] = 'tool_date';
                    $inspection_data[$i]['k3_value'] = $inspection->tool_date;
                    $inspection_data[$i]['file'] = null;
                    $inspection_data[$i]['note'] = null;
                }
            }
            if ($inspection->tool_type) {
                $x = $this->searchArrayKey('tool_type', $inspection_data);
                if (!$x) {
                    $i++;
                    $inspection_data[$i]['criteria'] = 'tool_type';
                    $inspection_data[$i]['k3_value'] = $inspection->tool_type;
                    $inspection_data[$i]['file'] = null;
                    $inspection_data[$i]['note'] = null;
                }
            }
        }

        return response()->json([
            // $inspection_label,

            'id' => $inspection->id,
            "date" => $inspection->date,
            "maker_id" => $inspection->maker_id,
            "company_id" => $inspection->company_id,
            "department_id" => $inspection->department_id,
            "section_id" => $inspection->section_id,
            "ccow_id" => $inspection->ccow_id,
            "pja_id" => $inspection->pja_id,
            "ktt_id" => $inspection->ktt_id,
            "inspect_id" => $inspection->inspect_id,
            "inspect_criteria" => $inspection->inspect_criteria,
            "area_location_id" => $inspection->area_location_id,
            "location_detail" => $inspection->location_detail,
            "summary" => $inspection->summary,
            "status" => $inspection->status,
            'inspection_officers' => $inspection_officers,
            'inspection_data' => $inspection_data,
        ]);
    }

    public function searchArrayKey($k, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['criteria'] === $k) {
                return true;
            }
        }
        return false;
    }

    public function getInspectionOfficers($id)
    {
        $employees = Employee::whereHas('user', function ($sql) use ($id) {
            $sql->whereHas('department', function ($query) use ($id) {
                $query->where('company_id', $id);
            });
        })->get();

        // return EmployeeResource::collection($employee);
        $data = [];
        $i = -1;
        foreach ($employees as $e) {
            $i++;
            $data[$i] = [
                'id' => $e->id,
                'company_name' => $e->user->department->company->company_name ?? null,
                'department_name' => $e->user->department->name ?? null,
                'name' => $e->name,
                'number' => $e->number,
                'id_number' => $e->id_number,
                'date_of_birth' => $e->date_of_birth,
                'gender' => $e->gender,
                'blood_type' => $e->blood_type,
                'marital_status' => $e->marital_status,
                'employee_status' => $e->employee_status,
                'company' => $e->user->department->company,
                'department' => $e->user->department,
                'position' => $e->position,
            ];
        }

        return response()->json(["data" => $data]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('kplh::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('kplh::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
