<?php

namespace Modules\Sap\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Modules\Sap\Entities\SapSetupCategory;

use App\Access\ApiModules;
use Modules\Sap\Entities\SapSetup;
use Modules\Sap\Entities\SapMonthlyEmployee;
use Modules\Sap\Entities\SapMonthlyActual;
use Modules\Sap\Entities\SapDepartmentCodes;
use App\Access\dateSetup;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Sap\Exports\Summary;
use Modules\FieldLeadership\Http\Controllers\MainDashboard\MainDashboardController as dataUserFl;
use Modules\Kplh\Http\Controllers\KplhController as dataUserInspaction;

class ApiController extends Controller
{

    public $date = [];
    public $months;
    public $search;
    public $year;
    public $filter_department = [];
    public $filter_grade = [];
    public $filter = [];

    public $slug;
    public $ach;
    public $employee;
    public $departmentCodes = [];
    public $departmentCodeNames = [];

    public $bulan = [
        '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'NOVEMBER', 'DESENBER'
    ];

    public function __construct()
    {
        $this->setDate();
        $departementCode = SapDepartmentCodes::has('dataDepartment')
            ->selectRaw("
                code,
                false as checked
            ")
            ->orderBy('code', 'ASC')
            ->get();

        $this->departmentCodes =  $departementCode;

        //  $this->departmentCodes = [
        //     ['code' => 'CPP', 'checked' => false],
        //     ['code' => 'ENV', 'checked' => false],
        //     ['code' => 'EXP', 'checked' => false],
        //     ['code' => 'EXT', 'checked' => false],
        //     ['code' => 'FIN', 'checked' => false],
        //     ['code' => 'HRGA', 'checked' => false],
        //     ['code' => 'IT', 'checked' => false],
        //     ['code' => 'LOG', 'checked' => false],
        //     ['code' => 'MTN', 'checked' => false],
        //     ['code' => 'ME', 'checked' => false],
        //     ['code' => 'OHS', 'checked' => false],
        //     ['code' => 'PORT', 'checked' => false],
        //     ['code' => 'PROC', 'checked' => false],
        //     ['code' => 'PMSS', 'checked' => false] //test
        // ];

        $departmentCodeNames = collect($this->departmentCodes)->pluck('code');
        $this->departmentCodeNames = $departmentCodeNames->all();
    }


    public function test()
    {
    }

    public function setDate($setYear = null)
    {
        $year = $setYear ? $setYear : date('Y');
        $month_now = date('F');
        $month_now = strtolower($month_now);

        $month_number_now = date('m');
        $month_number_now = intval($month_number_now);

        $day = date('d');
        $day = intval($day);

        $months = dateSetup::month($year);
        $this->months = $months;
        $dayInYear = dateSetup::days_in_year($year);

        $this->date = [
            'day_now' => $day,
            'month_now_name' => $month_now,
            'month_now' => $month_number_now,
            'months' => $months,
            'running_day' => $dayInYear,
            'year_now' => $year
        ];

        $this->getApiMonthly();
    }


    public function filter($filter)
    {
        $search = isset($filter['search']) ? $filter['search'] : null;
        $this->search = $search;
        $year = isset($filter['year']) ?  $filter['year'] :  date('Y');
        $this->year = $year;

        //dept
        $departments = isset($filter['department']) ?  $filter['department'] : null;
        $this->filter['departments'] = $departments ? (explode(",", $departments)) : [];

        //grade 
        $grades = isset($filter['grade']) ? $filter['grade'] : null;
        $this->filter['grades'] = $grades ? (explode(",", $grades)) : [];

        $month = isset($filter['month']) ?  $filter['month'] :  null;
        $monthArray = explode(",", $month);
        if (count($monthArray) > 0 && $month != null) {
            $months = dateSetup::month($this->year);
            $months = collect($months)->whereIn('month', $monthArray);
            $months = $months->values()->all();
            $this->months =  $months;
        } else {
            $months = dateSetup::month($this->year);
            $this->months =  $months;
        }

        return '';
    }

    /******************************************
     * AMBIL DATA
     *****************************************/
    public function dataAll($request)
    {
        //filter
        $this->filter($request);
        $search = $this->search;
        $year = $this->year;
        $months = $this->months;

        $getData = SapMonthlyEmployee::where('sap_monthly_employee.name', 'LIKE', '%' . $search . '%')
            ->leftjoin('sap_monthly_actual', function ($join) use ($year) {
                $join->on('sap_monthly_actual.user_id', '=', 'sap_monthly_employee.user_id')
                    ->where('sap_monthly_actual.year', '=', $year);
            })
            ->leftjoin('sap_setup', function ($join) {
                $join->on('sap_setup.slug', '=', 'sap_monthly_actual.module_slug')
                    ->where('available', '=', 'true');
            })
            ->leftjoin('sap_monthly', function ($join) use ($year) {
                $join->on('sap_monthly.employee_id', '=', 'sap_monthly_employee.id')
                    ->where('sap_monthly.year', '=', $year);
            });

        $getData =  $getData->selectRaw("
            sap_monthly_employee.id as id_employee,
            sap_monthly_employee.*,

            sap_monthly.*,
            sap_monthly.january +
            sap_monthly.february +
            sap_monthly.march +
            sap_monthly.april +
            sap_monthly.may +
            sap_monthly.june +
            sap_monthly.july +
            sap_monthly.august +
            sap_monthly.september +
            sap_monthly.october +
            sap_monthly.november +
            sap_monthly.december      
            AS kehadiran,

            sap_monthly_actual.january as january_actual,
            sap_monthly_actual.february as february_actual,
            sap_monthly_actual.march as march_actual,
            sap_monthly_actual.april as april_actual,
            sap_monthly_actual.may as may_actual,
            sap_monthly_actual.june as june_actual,
            sap_monthly_actual.july as july_actual,
            sap_monthly_actual.august as august_actual,
            sap_monthly_actual.september as september_actual,
            sap_monthly_actual.october as october_actual,
            sap_monthly_actual.november as november_actual,
            sap_monthly_actual.december as december_actual,

            sap_monthly_actual.january +
            sap_monthly_actual.february +
            sap_monthly_actual.march +
            sap_monthly_actual.april +
            sap_monthly_actual.may +
            sap_monthly_actual.june +
            sap_monthly_actual.july +
            sap_monthly_actual.august +
            sap_monthly_actual.september +
            sap_monthly_actual.october+
            sap_monthly_actual.november+
            sap_monthly_actual.december AS actual,

            CASE
                WHEN  INSTR(sap_monthly_employee.grade, 'Dept head') AND sap_setup.dept_head THEN sap_setup.dept_head
                WHEN  INSTR(sap_monthly_employee.grade, 'Foreman') AND sap_setup.foreman_supervisor_sechead THEN sap_setup.foreman_supervisor_sechead
                WHEN  INSTR(sap_monthly_employee.grade, 'karya') AND sap_setup.employee THEN sap_setup.employee
                ELSE 0
            END AS grade_value
            ");

        foreach ($months as $list) {
            $x = $list['month_name'];
            $getData =  $getData->selectRaw("
                CASE
                    WHEN sap_monthly.$x IS NULL THEN 0
                    ELSE sap_monthly.$x
                END AS $x
                ");
        }

        $getData =  $getData->get()->map(function ($item, $key) use ($year) {
            $sumTarget = 0;
            for ($i = 1; $i <= 12; $i++) {
                $f = strtolower(date('F', strtotime($year . '-' . $i)));

                //jumlah hari //bulan_day
                $day = Carbon::parse('1-' . $i . '-' . $year)->daysInMonth;
                $count_name = $f . '_day';
                $item->{$count_name} = $day;

                //actual //bulan_actual
                $f_actual_name = $f . '_actual';
                $actual = $item->{$f_actual_name};

                //target //bulan_target
                $f_name = $f . '_target';
                $month = floatval($item->{$f});
                $grade_value = floatval($item->grade_value);
                $target = $month && $grade_value ? round($month / $day * $grade_value, 2) : 0;
                $item->{$f_name} = $target;
                $sumTarget += $target;

                //persentase //bulan_persentase
                $percentase_name = $f . '_percentase';
                $item->{$percentase_name} = $actual && $item->{$f_name} ? 100 : 0;
            }
            $item->target = $sumTarget;
            return $item;
        });

        $getData = json_decode($getData, true);
        return $getData;
    }


    public function dataByCategory($slug, $filter, $group = null)
    {
        $view = isset($filter['view']) ? $filter['view'] : null;
        //filter
        $this->filter($filter);
        $search = $this->search;
        $year = $this->year;

        $departments = $this->filter['departments'];
        $grades = $this->filter['grades'];

        //perbarui aktual
        $this->getApiMonthly();

        //getSetup
        $setupCategory = SapSetupCategory::where('name', $year)
            ->with(['setup' => function ($q) use ($slug) {
                $q->where('slug', $slug);
            }])
            ->first();

        $setupCategory = json_decode($setupCategory, true);
        $setup = $setupCategory ? $setupCategory['setup'] : [];
        //variable jabatan mengantisipasi kalo tambah jabatan secara dinamis
        $cols = ['dept_head', 'foreman_supervisor_sechead', 'employee'];
        foreach ($cols as $jabatan) {
            ${$jabatan} = isset($setup[$jabatan]) ? $setup[$jabatan] : null;;
        }

        //kategori name
        $partName = 'inspe';
        if (is_numeric(stripos($slug, $partName))) {
        } else {
            //mengantisipasi kl ada kategori lain
            $category_name = ["observa", "hazar", "talk"];
            foreach ($category_name as $index => $list) {
                if (is_numeric(stripos($slug, $list))) {
                    $partName = $list;
                }
            }
        }

        $getData = SapMonthlyEmployee::where('sap_monthly_employee.name', 'LIKE', '%' . $search . '%')
            ->where(function ($q) use ($departments) {
                if (count($departments) > 0) {
                    $q->whereIn('sap_monthly_employee.code', $departments);
                }
            })
            ->where(function ($q) use ($grades) {
                if (count($grades) > 0) {
                    $q->whereIn('sap_monthly_employee.grade_code', $grades);
                }
            })
            ->leftjoin('sap_monthly_actual', function ($join) use ($year, $partName) {
                $join->on('sap_monthly_actual.grade_code', '=', 'sap_monthly_employee.grade_code');
                $join->on('sap_monthly_actual.user_id', '=', 'sap_monthly_employee.user_id')
                    ->where('sap_monthly_actual.year', '=', $year)
                    ->where('sap_monthly_actual.module_name', 'like', '%' . $partName . '%');
            })
            ->leftjoin('sap_setup', function ($join) use ($partName, $year) {
                $join->on('sap_setup.slug', '=', 'sap_monthly_actual.module_slug')
                    ->where('sap_setup.safety_accountability_progam', 'like', '%' . $partName . '%')
                    ->where('sap_setup.year', $year);
            })

            ->leftjoin('sap_monthly', function ($join) use ($year) {
                $join->on('sap_monthly.employee_id', '=', 'sap_monthly_employee.id')
                    ->where('sap_monthly.year', '=', $year)
                    ->selectRaw("sap_monthly.*");
            });

        $a = [];

        $getData =  $getData->selectRaw("
            sap_monthly_employee.id as id_employee,
            sap_monthly_employee.*,

            sap_monthly.*,
            sap_monthly.january +
            sap_monthly.february +
            sap_monthly.march +
            sap_monthly.april +
            sap_monthly.may +
            sap_monthly.june +
            sap_monthly.july +
            sap_monthly.august +
            sap_monthly.september +
            sap_monthly.october +
            sap_monthly.november +
            sap_monthly.december      
            AS kehadiran,


            sap_monthly_actual.january +
            sap_monthly_actual.february +
            sap_monthly_actual.march +
            sap_monthly_actual.april +
            sap_monthly_actual.may +
            sap_monthly_actual.june +
            sap_monthly_actual.july +
            sap_monthly_actual.august +
            sap_monthly_actual.september +
            sap_monthly_actual.october+
            sap_monthly_actual.november+
            sap_monthly_actual.december AS actual,

            
            sap_monthly_actual.january as january_actual,
            sap_monthly_actual.february as february_actual,
            sap_monthly_actual.march as march_actual,
            sap_monthly_actual.april as april_actual,
            sap_monthly_actual.may as may_actual,
            sap_monthly_actual.june as june_actual,
            sap_monthly_actual.july as july_actual,
            sap_monthly_actual.august as august_actual,
            sap_monthly_actual.september as september_actual,
            sap_monthly_actual.october as october_actual,
            sap_monthly_actual.november as november_actual,
            sap_monthly_actual.december as december_actual,

                CASE
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'pjo') AND sap_setup.dept_head IS NOT NULL THEN sap_setup.dept_head
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'pja') AND sap_setup.foreman_supervisor_sechead IS NOT NULL THEN sap_setup.foreman_supervisor_sechead
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'maker') AND sap_setup.employee IS NOT NULL THEN sap_setup.employee
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'pjo') THEN '$dept_head'
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'pja') THEN '$foreman_supervisor_sechead'
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'maker') THEN '$employee'
                    ELSE ''
                END AS grade_value
            ");
        $getData =  $getData->get()->map(function ($item, $key) use ($year) {
            $sumTarget = 0;
            for ($i = 1; $i <= 12; $i++) {
                $f = strtolower(date('F', strtotime($year . '-' . $i)));

                //jumlah hari //bulan_day
                $day = Carbon::parse('1-' . $i . '-' . $year)->daysInMonth;
                $count_name = $f . '_day';
                $item->{$count_name} = $day;

                //actual //bulan_actual
                $f_actual_name = $f . '_actual';
                $actual = $item->{$f_actual_name};

                //target //bulan_target
                $f_name = $f . '_target';
                $month = floatval($item->{$f});
                $grade_value = floatval($item->grade_value);
                $target = $month && $grade_value ? round($month / $day * $grade_value, 2) : 0;
                $item->{$f_name} = $target;
                $sumTarget += $target;

                //persentase //bulan_persentase
                $percentase_name = $f . '_percentase';
                $item->{$percentase_name} = $actual && $item->{$f_name} ? 100 : 0;
            }
            $item->target = $sumTarget;
            return $item;
        });

        $getData = json_decode($getData, true);

        //gruopBy
        if ($group) {
            $grouped = collect($getData)->groupBy($group);
            $grouped->all();
            return  $grouped;
        }
        return $getData;
    }

    /******************************************
     * PROSES
     *****************************************/

    /**
     * SEMUA DEPARTEMENT (SAP DASHBOARD)
     */
    public function SapChart(request $request)
    {
        $filter = $request->all();
        return $this->dataSapChart($filter);
    }

    public function dataSapChart($filter)
    {
        $filterYear = isset($filter['year']) ? $filter['year'] : date('Y');
        $filterMonth =  isset($filter['month']) ? $filter['month'] : null;

        //MONTH
        $year =  $filterYear ?  $filterYear : $this->date['year_now'];
        $month_now = $filterMonth ? $filterMonth : $this->date['month_now_name'];
        $month_number_now =  $month_now ?  date('m', strtotime($month_now)) : $this->date['month_now'];
        $month_number_now =  intval($month_number_now);

        $day = $this->date['day_now'];
        $dayInYear = $this->date['running_day'];
        $month = $this->date['months'];

        //nama departemnt
        $departmentCodes = $this->departmentCodeNames;
        $deptName = $departmentCodes;

        $getData = $this->dataAll($filter);

        /**
         * TAHUN INI
         */
        $dataYear = [];
        foreach ($deptName as $deptNameList) {
            $getDeptAll =  collect($getData)->where('code', $deptNameList);
            $total_actual = $getDeptAll->sum('actual');
            $target = round($getDeptAll->sum('target'), 0);

            $percentase_dept = $target != 0 && $total_actual != 0 ? 100 : null;
            $deficiency = $target - $total_actual;
            $deficiency =  $deficiency < 0 ? 0 : $deficiency;

            $dataYear[$deptNameList] = [
                'target_dept' => $target,
                'actual_dept' => $total_actual,
                'percentase_dept' => $percentase_dept,
                'deficiency' => $deficiency,
                //'data' => $getDeptAll
            ];
        }


        /**
         * BULAN INI
         */
        $dataMonths = [];
        $countDayAll = 0;

        $yearly_target_dept = 0;
        $yearly_actual_dept = 0;
        $yearly_persentase_dept = 0;
        $yearly_deficiency = 0;

        foreach ($month as $index => $row) {
            //proccess
            $month_name = $row['month_name']; //bulan jan-dec
            $month_number = $row['month']; //bulan 1-12
            $dayCount = Carbon::parse('1-' . $month_number . '-' . $year)->daysInMonth;
            $countDayAll += $dayCount;
            $resultDept = [];

            $monthly_target_dept = 0;
            $monthly_actual_dept = 0;
            $monthly_persentase_dept = 0;
            $monthly_deficiency = 0;

            foreach ($deptName as $deptNameList) {
                $dataDept =  collect($getData)->where('code', $deptNameList);
                $dataDeptAll = [];
                $totalTarget = 0;
                $totalActual = 0;
                $percentase_dept = 0;
                $deficiency = 0;
                foreach ($dataDept as $list) {
                    $actual = is_numeric($list[$month_name . '_actual']) ? $list[$month_name . '_actual'] : 0; //actual
                    $target = is_numeric($list[$month_name . '_target']) ? $list[$month_name . '_target'] : 0; //actual
                    $ach = $list[$month_name . '_percentase'];

                    $dataDeptAll[] = [
                        'dept' => $deptNameList,
                        'month_name' => $month_name,
                        'target' => round($target, 2),
                        'actual' => round($actual, 2),
                        'ach' => $ach,
                    ];

                    $totalTarget += is_numeric($target) ? $target : 0;
                    $totalActual +=  is_numeric($actual) ? $actual : 0;
                }
                $deficiency = $totalTarget - $totalActual;
                $percentase_dept = $totalTarget != 0 && $totalActual  != 0  ? 100 : 0;
                $percentase_dept = round($percentase_dept, 2);

                $resultDept[$deptNameList] = [
                    'target_dept' => $totalTarget,
                    'actual_dept' => $totalActual,
                    'persentase_dept' => $percentase_dept,
                    'deficiency' => $deficiency < 0 ? 0 : $deficiency,
                    'data' => $dataDeptAll,
                ];

                $monthly_target_dept += $totalTarget;
                $monthly_actual_dept += $totalActual;
            }

            $monthly_target_dept = round($monthly_target_dept, 2);
            $monthly_actual_dept = round($monthly_actual_dept, 2);

            $monthly_deficiency = $monthly_target_dept - $monthly_actual_dept;
            $monthly_deficiency = $monthly_deficiency < 0 ? 0 : $monthly_deficiency;
            $monthly_persentase_dept = $monthly_target_dept != 0 && $monthly_actual_dept  != 0  ? 100 : 0;
            $monthly_persentase_dept = round($monthly_persentase_dept, 2);

            $dataMonths[$month_name] = [
                'monthly_target_dept' => $monthly_target_dept,
                'monthly_actual_dept' => $monthly_actual_dept,
                'monthly_persentase_dept' => $monthly_persentase_dept,
                'monthly_deficiency' => $monthly_deficiency,
                'data' => $resultDept
            ];

            $yearly_target_dept += $monthly_target_dept;
            $yearly_actual_dept += $monthly_actual_dept;
        }

        $ytd = $yearly_target_dept;
        $ytd = round($ytd);

        $yearly_persentase_dept = $yearly_target_dept  != 0  && $yearly_actual_dept != 0 ? 100 : 0;
        $yearly_persentase_dept = round($yearly_persentase_dept);

        $result = [
            'status' => true,
            'data' => [
                'weeks' => $dayInYear < 1 ? 1 : ceil($dayInYear / 7),
                'date' => date('Y-m', strtotime($year . '-' . $month_number_now)),
                'year_now' =>  $year,
                'month_now_ina' => isset($this->bulan[$month_number_now]) ?  $this->bulan[$month_number_now] : '',
                'month_now' => $month_now,
                'month_now_number' => $month_number_now,

                'ytd' => [
                    'count' => $ytd,
                    'progress' => $yearly_persentase_dept ? round($yearly_persentase_dept, 0) : 0
                ],

                'progress' => [
                    'actual' => $yearly_actual_dept ? round($yearly_actual_dept, 0) : 0,
                    'target' => $yearly_target_dept ? round($yearly_target_dept, 0) : 0,
                ],
                'yearly' => $dataYear,
                'monthly' => $dataMonths,
                'departement' => $deptName
            ]
        ];
        return $result;
    }

    public function SapChartCategory(Request $request)
    {
        $filter = $request->all();
        return $this->dataSapChartCategory($filter);
    }

    public function dataSapChartCategory($filter)
    {
        $departmentCodes = $this->departmentCodeNames;

        $this->filter($filter);
        $year = isset($filter['year']) ? $filter['year'] : date('Y'); //2001

        $month =  isset($filter['month']) ? $filter['month'] : null; //1,2,3
        $month = $month ? $month : strtolower(date('m'));
        $month = explode(",", $month);
        $month = collect($this->date['months'])->whereIn('month', $month);
        $month = $month->all();


        $departments = isset($filter['department']) ? $filter['department'] : ''; //env,cpp
        if ($departments) {
            $departments = explode(",",  $departments);
            $deptName =  $departments;
        } else {
            $deptName = $departmentCodes;
        }

        $dayInYear = $this->date['running_day'];

        $moduls = SapSetup::whereHas('SapSetupCategory', function ($q) use ($year) {
            $q->where('name', $year);
        })
            ->get();

        $categoryAll = [];
        foreach ($moduls  as $modul) {
            $slug = $modul->slug;
            $getData = $this->dataByCategory($slug, $filter, $group = null);

            /**
             * TAHUN INI
             */
            $dataYear = [];
            foreach ($deptName as $deptNameList) {
                $getDeptAll =  collect($getData)->where('code', $deptNameList);
                $kehadiran =  $getDeptAll->sum('kehadiran');
                $total_actual =  round($getDeptAll->sum('actual'), 2);
                $target = round($getDeptAll->sum('target'), 2);

                $percentase_dept = $target != 0 && $total_actual != 0 ? 100 : null;
                $deficiency = $target - $total_actual;
                $deficiency =  $deficiency < 0 ? 0 : $deficiency;

                $dataYear[$deptNameList] = [
                    'target_dept' => $target,
                    'actual_dept' => $total_actual,
                    'percentase_dept' => $percentase_dept,
                    'deficiency' => $deficiency,
                    //'data' => $getDeptAll
                ];
            }


            /**
             * BULAN INI
             */
            $dataMonths = [];
            $countDayAll = 0;

            $yearly_target_dept = 0;
            $yearly_actual_dept = 0;
            $yearly_persentase_dept = 0;
            $yearly_deficiency = 0;

            foreach ($month as $index => $row) {
                //proccess
                $month_name = $row['month_name']; //bulan jan-dec
                $month_number = $row['month']; //bulan 1-12
                $dayCount = Carbon::parse('1-' . $month_number . '-' . $year)->daysInMonth;
                $countDayAll += $dayCount;
                $resultDept = [];

                $monthly_target_dept = 0;
                $monthly_actual_dept = 0;
                $monthly_persentase_dept = 0;
                $monthly_deficiency = 0;

                foreach ($deptName as $deptNameList) {
                    $dataDept =  collect($getData)->where('code', $deptNameList);
                    $dataDeptAll = [];
                    $totalTarget = 0;
                    $totalActual = 0;
                    $percentase_dept = 0;
                    $deficiency = 0;
                    foreach ($dataDept as $list) {
                        $gradeTarget = $list['grade_value'];
                        $actual = is_numeric($list[$month_name . '_actual']) ? $list[$month_name . '_actual'] : 0; //actual
                        $kehadiran = is_numeric($list[$month_name]) ? $list[$month_name] : 0; //datamonthly
                        $target = is_numeric($list[$month_name . '_target']) ? $list[$month_name . '_target'] : 0; //actual
                        $ach = $target & $actual ? 100 : 0;
                        $totalTarget += is_numeric($target) ? $target : 0;
                        $totalActual +=  is_numeric($actual) ? $actual : 0;
                        $dataDeptAll[] = [
                            'dept' => $deptNameList,
                            'month_name' => $month_name,
                            'target' => $target,
                            'actual' => $actual,
                            'ach' => $ach,
                        ];
                    }
                    $deficiency = $totalTarget - $totalActual;
                    $percentase_dept = $totalTarget != 0 && $totalActual  != 0  ? 100 : 0;
                    $percentase_dept = round($percentase_dept, 2);

                    $resultDept[$deptNameList] = [
                        'target_dept' => $totalTarget,
                        'actual_dept' => $totalActual,
                        'persentase_dept' => $percentase_dept,
                        'deficiency' => $deficiency < 0 ? 0 : $deficiency,
                        //'data' => $dataDeptAll,
                    ];

                    $monthly_target_dept += $totalTarget;
                    $monthly_actual_dept += $totalActual;
                }

                $monthly_target_dept = round($monthly_target_dept, 2);
                $monthly_actual_dept = round($monthly_actual_dept, 2);

                $monthly_deficiency = $monthly_target_dept - $monthly_actual_dept;
                $monthly_deficiency = $monthly_deficiency < 0 ? 0 : $monthly_deficiency;
                $monthly_persentase_dept = $monthly_target_dept != 0 && $monthly_actual_dept  != 0  ? 100 : 0;
                $monthly_persentase_dept = round($monthly_persentase_dept, 2);

                $dataMonths[] = [
                    'month' => $month_name,
                    'monthly_target_dept' => $monthly_target_dept,
                    'monthly_actual_dept' => $monthly_actual_dept,
                    'monthly_persentase_dept' => $monthly_persentase_dept,
                    'monthly_deficiency' => $monthly_deficiency,
                    'data' => $resultDept
                ];

                $yearly_target_dept += $monthly_target_dept;
                $yearly_actual_dept += $monthly_actual_dept;
            }

            //$ytd = $yearly_actual_dept && $yearly_target_dept ?  $yearly_actual_dept / $yearly_target_dept : 0;
            $ytd = $yearly_target_dept;
            $ytd = round($ytd);

            $yearly_persentase_dept = $yearly_target_dept  != 0  && $yearly_actual_dept != 0 ? 100 : 0;
            $yearly_persentase_dept = round($yearly_persentase_dept);

            $result = [
                'status' => true,
                'slug' => $modul->slug,
                'name' => $modul->safety_accountability_progam,
                'weeks' => $dayInYear < 1 ? 1 : ceil($dayInYear / 7),
                'year_now' =>  $year,
                'yearly' => $dataYear,
                'monthly' => $dataMonths,
                'departement' => $deptName
            ];
            $categoryAll[] = [
                'filter' => ['year' => $year],
                'data' => $result
            ];
        }
        return $categoryAll;
    }


    public function SapMonthly(request $request)
    {
        $getData = $this->dataAll($request);
        $getData = collect($getData);

        $year = $this->date['year_now'];
        $month = $this->date['months'];
        $monthAll = [];

        foreach ($month as $list) {
            $month = $list['month_name'];
            $month_number = $list['month']; //bulan 1-12
            $dayCount = Carbon::parse('1-' . $month_number . '-' . $year)->daysInMonth;
            $gradeTarget = $getData->whereNotNull($month)->sum('grade_value');

            $total_kehadiran = $getData->sum($month);
            $total_target = $total_kehadiran != 0 && $dayCount != 0 ? ($total_kehadiran / $dayCount * $gradeTarget) : 0;
            $total_actual = $getData->sum($month . '_actual');

            $monthAll[] = [
                'month' => $month,
                'month_short' => date('M', strtotime($month)),
                'kehadiran' => $total_kehadiran,
                'target' => $total_target,
                'actual' => $total_actual,
            ];
        }

        return $monthAll;
    }





    //SETIAP KATEGORI
    public function SapCategory($slug, request $request)
    {
        $request =  $request->all();
        return $this->dataSapCategory($slug, $request);
    }

    public function dataSapCategory($slug, $filter)
    {
        $view = isset($filter['view']) ? $filter['view'] : null;

        //filter
        $this->filter($filter);
        $search = $this->search;
        $year = $this->year;
        $months = $this->months;

        $departments = $this->filter['departments'];
        $grades = $this->filter['grades'];

        //perbarui aktual
        $this->getApiMonthly();

        //getSetup
        $setupCategory = SapSetupCategory::where('name', $year)
            ->with(['setup' => function ($q) use ($slug) {
                $q->where('slug', $slug);
            }])
            ->first();
        $setupCategory = json_decode($setupCategory, true);
        $setup = $setupCategory ? $setupCategory['setup'] : [];
        //variable jabatan mengantisipasi kalo tambah jabatan secara dinamis
        $cols = ['dept_head', 'foreman_supervisor_sechead', 'employee'];
        foreach ($cols as $jabatan) {
            ${$jabatan} = isset($setup[$jabatan]) ? $setup[$jabatan] : null;;
        }

        //kategori name
        $partName = 'inspe';
        if (is_numeric(stripos($slug, $partName))) {
        } else {
            //mengantisipasi kl ada kategori lain
            $category_name = ["observa", "hazar", "talk"];
            foreach ($category_name as $index => $list) {
                if (is_numeric(stripos($slug, $list))) {
                    $partName = $list;
                }
            }
        }

        $getData = SapMonthlyEmployee::where('sap_monthly_employee.name', 'LIKE', '%' . $search . '%')
            ->where(function ($q) use ($departments) {
                if (count($departments) > 0) {
                    $q->whereIn('sap_monthly_employee.code', $departments);
                }
            })
            ->where(function ($q) use ($grades) {
                if (count($grades) > 0) {
                    $q->whereIn('sap_monthly_employee.grade_code', $grades);
                }
            })
            ->leftjoin('sap_monthly_actual', function ($join) use ($year, $partName) {
                $join->on('sap_monthly_actual.grade_code', '=', 'sap_monthly_employee.grade_code');
                $join->on('sap_monthly_actual.user_id', '=', 'sap_monthly_employee.user_id')
                    ->where('sap_monthly_actual.year', '=', $year)
                    ->where('sap_monthly_actual.module_name', 'like', '%' . $partName . '%');
            })
            ->leftjoin('sap_setup', function ($join) use ($partName, $year) {
                $join->on('sap_setup.slug', '=', 'sap_monthly_actual.module_slug')
                    ->where('sap_setup.safety_accountability_progam', 'like', '%' . $partName . '%')
                    ->where('sap_setup.year', $year);
            })

            ->leftjoin('sap_monthly', function ($join) use ($year) {
                $join->on('sap_monthly.employee_id', '=', 'sap_monthly_employee.id')
                    ->where('sap_monthly.year', '=', $year)
                    ->selectRaw("sap_monthly.*");
            });


        $getData =  $getData->selectRaw("
                sap_monthly.*,
                sap_monthly_employee.id as id_employee,
                sap_monthly_employee.id_number as jde,
                sap_monthly_employee.name,
                sap_monthly_employee.position,
                sap_monthly_employee.code as dept,
                sap_monthly_employee.company_name,
                sap_monthly_employee.grade,
                sap_monthly_employee.grade_code,

                sap_monthly_actual.module_slug,
                sap_monthly_actual.total,
                sap_monthly_actual.january AS actual_january,
                sap_monthly_actual.february AS actual_february,
                sap_monthly_actual.march AS actual_march,
                sap_monthly_actual.april AS actual_april,
                sap_monthly_actual.may AS actual_may,
                sap_monthly_actual.june AS actual_june,
                sap_monthly_actual.july AS actual_july,
                sap_monthly_actual.august AS actual_august,
                sap_monthly_actual.september AS actual_september,
                sap_monthly_actual.october AS actual_october,
                sap_monthly_actual.november AS actual_november,
                sap_monthly_actual.december AS actual_december,

                CASE
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'pjo') AND sap_setup.dept_head IS NOT NULL THEN sap_setup.dept_head
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'pja') AND sap_setup.foreman_supervisor_sechead IS NOT NULL THEN sap_setup.foreman_supervisor_sechead
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'maker') AND sap_setup.employee IS NOT NULL THEN sap_setup.employee
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'pjo') THEN '$dept_head'
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'pja') THEN '$foreman_supervisor_sechead'
                    WHEN  INSTR(sap_monthly_employee.grade_code, 'maker') THEN '$employee'
                    ELSE ''
                END AS 'grade_value'
            ")
            ->get();
        $getData = json_decode($getData, true);

        $totalTarget = 0;
        $totalActual = 0;
        $data = [];
        foreach ($getData as $list) {
            $gradeTarget = $list['grade_value'];
            $dataMonths = [];
            foreach ($months as $index => $row) {
                $month_name = $row['month_name']; //nama bulan
                $month_number = $row['month']; //angka bulan
                $kehadiran = $list[$month_name]; //datamonthly
                $actual = $list['actual_' . $month_name]; //data api
                //jumlah hari 
                $dayCount = Carbon::parse('1-' . $month_number . '-' . $year)->daysInMonth;
                //hitung target
                $target = is_numeric($gradeTarget) ? ($kehadiran > 0 ? $kehadiran / $dayCount * $gradeTarget : 0) : '-';
                $target =  is_numeric($target) ? round($target, 2) : $target;

                $ach =  $actual != 0 && $target != 0 ? '100%' : null;
                $dataMonths[] = [
                    'month_name' => $month_name,
                    'target' => $target,
                    'actual' =>  $actual,
                    'ach' => $ach,
                ];

                //total
                $totalTarget += is_numeric($target)  ? $target : 0;
                $totalActual += is_numeric($actual)  ? $actual : 0;
            }

            $list['months'] = $dataMonths;
            $data[] = $list;
        }

        $employee =  [
            'filter' => $this->filter,
            'year' => $year,
            'months' => $months,
            'slug' => $slug,
            'target' => round($totalTarget, 2),
            'actual' => round($totalActual, 2),
            'data' => $data,
        ];

        if ($view == 'download') {
            $months = $month;
            $filename = 'summary-' . $slug . '.xlsx';
            return Excel::download(new Summary($months, $employee), $filename);
        } else {
            return $employee;
        }
    }



    public function getApiMonthly()
    {
        $filter = [
            'month' => null,
            'year' => null,
            'company' => null
        ];

        $inspection =  $this->ApiUserInspection($filter);
        $fieldLeadership = $this->ApiUserFieldLeadership($filter);
        $all =  array_merge($inspection, $fieldLeadership);

        //simpan database
        foreach ($all as $list) {
            $month = $list['month'];
            SapMonthlyActual::updateOrCreate(
                [
                    'user_id' => $list['user_id'],
                    'module_slug' =>  Str::slug($list['module_name'], '-'),
                    'grade' => $list['grade'],
                ],
                [
                    'grade_code' => $list['grade'],
                    'module_name' => $list['module_name'],
                    $month  => $list['total'],
                    'year' => $list['year'],
                    'employee_number' => $list['employee_number'],
                    'employee_name' => $list['name']
                ]
            );
        }
    }


    public function ApiUserInspection($filter)
    {

        $month = $filter['month'];
        $year = $filter['year'] ? $filter['year'] : date('Y');
        $company = $filter['company'];
        $moduleName = 'Inspection';

        //$apiFL = ApiModules::module('inspection-user-status', $month, $year, $company);
        $request = Request();
        $request['month'] =  $month;
        $request['year'] = $year;
        $request['company'] = $company;

        $getDataUserInspection = (new dataUserInspaction)->getUserStats($request);
        $getDataUserInspection = json_decode($getDataUserInspection->content(), true);

        $apiFL = [
            'status' => 'true',
            'data' => $getDataUserInspection
        ];

        $userAll = [];
        try {
            if ($apiFL['status'] == 'true') {
                $dataSap = $apiFL['data'];
                foreach ($dataSap  as $row) {
                    $row['employee_number'] = isset($row['employee_number']) ? $row['employee_number'] : null;
                    $list = [
                        'grade' => 'maker',
                        'user_id' => $row['user_id'],
                        'employee_number' => $row['employee_number'],
                        'name' => $row['employee_name'],
                        'target' => $row['target'],
                        'total' => $row['actual'],
                        'module_name' => $moduleName,
                        'year' => $year,

                        'grade' => $row['grade'],
                        'month' =>  strtolower(date("F", strtotime($row['document_created']))),
                        'document_created' => date('Y-m', strtotime($row['document_created'])),
                    ];

                    $userAll[] = $list;
                }
            }
        } catch (\Throwable $e) {
        }

        return $userAll;
    }




    public function ApiUserFieldLeadership($filter)
    {
        $month = $filter['month'];
        $year = $filter['year'] ? $filter['year'] : date('Y');
        $company = $filter['company'];

        //$apiFL = ApiModules::module('field_leadership-user-status', $month, $year, $company);
        $request = Request();
        $request['month'] =  $month;
        $request['year'] = $year;
        $request['company'] = $company;

        $getDataUserFl = (new dataUserFl)->sap($request);
        $apiFL = json_decode($getDataUserFl->content(), true);
        $apiFL['status'] = 'true';

        $userAll = [];
        try {
            if ($apiFL['status'] == 'true') {
                $dataSap = $apiFL['data'];
                foreach ($dataSap as $index => $list) {
                    $grade = $index;
                    $getCategory = $list['category'];
                    $categoryAll[] = $getCategory;
                    foreach ($getCategory as $category) {
                        $moduleName = isset($category['name']) ? $category['name'] : [];
                        $user = isset($category['value']) ? $category['value'] : [];
                        foreach ($user as $list) {
                            $list['module_name'] = 'FL ' . $moduleName;
                            $list['year'] = $year;
                            $list['grade'] = $grade;
                            $list['month'] =  strtolower(date("F", strtotime($list['document_created'])));
                            $list['document_created'] = date('Y-m', strtotime($list['document_created']));
                            $userAll[] =  $list;
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
        }

        return $userAll;
    }



    /*******************************************************************************
     *  SAP chart dashboard 
     ********************************************************************************/
    public function ApiDashboard(Request $request)
    {
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $last_date =  Carbon::now()->subMonths(1);
        $last_month = strtolower(date('F', strtotime($last_date)));
        $last_month_year = strtolower(date('Y', strtotime($last_date)));

        $year =  $thisYear;
        $last_year =   $thisYear - 1;

        $months = ($request->months) ? $request->months : null;
        $arrayMonth = $months ? explode(",", $months) : [];

        $years = ($request->years) ? $request->years : $thisYear;
        $arrayYear = explode(",", $years);

        $companyIds = ($request->companies) ? $request->companies : null;
        $arrayCompanyId = $companyIds ? explode(",", $companyIds) : [];


        $filter = $request->all();
        $categories = $this->dataSapCategoryAll($filter);

        $sap = $this->dataSapChart($filter);
        $sap = isset($sap['data']) ? $sap['data'] : [];

        $date = $sap['date'];
        $this_month_name = $sap['month_now'];
        $data_this_month = isset($sap['monthly'][$this_month_name]) ? $sap['monthly'][$this_month_name] : [];

        $this_year = $sap['year_now'];
        $ytd = $sap['ytd'];
        $progress = $sap['progress'];

        $data_last_months = $sap['monthly'][$last_month];

        $filter = [];
        $filter['year'] = $last_year;
        $filter['month'] =  $last_month;
        $last_sap = $this->dataSapChart($filter);
        $last_sap = isset($last_sap['data']) ? $last_sap['data'] : [];
        if ($this_year != $year) {
            $data_last_months = $last_sap['monthly'][$last_month];
        }

        $result = [
            'status' => true,
            'status_code' => 0,
            'data' => [
                'ytd' => [],
                'by_month' => [],
                'by_category' => [],
                'all_processes' => [],
                'details' => [],
            ]
        ];

        /**
         * ytd count
         */
        $ytd = [
            'count' => $ytd['count'],
            'progress' => $ytd['progress']
        ];


        /**
         * by month
         */
        $byMonth = collect($sap['monthly'])->map(function ($item, $key) {
            return [
                "number" => date('m', strtotime($key)),
                "month" => date('M', strtotime($key)),
                "target" => $item['monthly_target_dept'],
                "actual" => $item['monthly_actual_dept'],
                "persentase" => $item['monthly_persentase_dept'],
                "deficiency" => $item['monthly_deficiency'],
            ];
        });

        //filter by month
        if (count($arrayMonth) > 0) {
            $byMonth = collect($byMonth)->whereIn('number', $arrayMonth);
            $byMonth->all();
        }


        /**
         * by category
         */
        $categories = collect($categories)->map(function ($item) {
            return [
                'name' => $item['name'],
                'value' => $item['percentase'],
                //'item' => $request->all()
            ];
        });

        /**
         * all progress
         */
        $progress = [
            'update' => [
                'target' =>  $progress['target'],
                'actual' => $progress['actual']
            ],
            'obsolute' => [
                'target' => $progress['actual'],
                'actual' => $progress['target']
            ]
        ];

        /**
         * details
         */
        $details = [
            'monthly' => [
                'this_month' => $data_this_month['monthly_actual_dept'],
                'this_month_progress' => $data_this_month['monthly_persentase_dept'],
                'this_month_mark' =>  $data_this_month['monthly_actual_dept'] < $data_this_month['monthly_actual_dept'] ? 'down' : 'up',

                'last_month' => $data_last_months['monthly_actual_dept'],
                'last_month_progress' => $data_last_months['monthly_persentase_dept'],
                'last_month_mark' => $data_last_months['monthly_actual_dept'] < $data_last_months['monthly_actual_dept'] ? 'up' : 'down',
            ],
            'yearly' => [
                'this_year' => $sap['progress']['actual'],
                'this_year_progress' => $sap['ytd']['progress'],
                'this_year_mark' => $sap['progress']['actual'] < $last_sap['progress']['actual'] ? 'down' : 'up',

                'last_year' => $last_sap['progress']['actual'],
                'last_year_progress' => $last_sap['ytd']['progress'],
                'last_year_mark' => $sap['progress']['actual'] < $last_sap['progress']['actual'] ? 'up' : 'down',
            ],
        ];

        $result = [
            'status' => true,
            'data' => [
                'ytd' => $ytd,
                'by_month' => $byMonth,
                'by_category' => $categories,
                'progress' => $progress,
                'details' => $details,
            ]
        ];
        return response()->json($result);
    }


    //SEMUA KATEGORY
    public function SapCategoryAll(request $request)
    {
        $request = $request->all();
        return $this->dataSapCategoryAll($request);
    }

    public function dataSapCategoryAll($filter)
    {
        $getCategory = SapSetupCategory::where('available', 'true')
            ->with('setupList')
            ->first();

        $getCategory = json_decode($getCategory, true);
        $setup_list =  $getCategory ? $getCategory['setup_list']  : [];

        $categoryAll = [];
        foreach ($setup_list as $list) {
            $slug = $list['slug'];
            $name = $list['safety_accountability_progam'];
            $dataCategory = $this->dataSapCategory($slug, $filter);
            $percentase = $dataCategory['target'] &&  $dataCategory['actual'] ? $dataCategory['actual'] / $dataCategory['target'] * 100 : 0;
            $percentase = $percentase <= 100 ? round($percentase) : 100;
            $categoryAll[] = [
                'name' => $name,
                'target' => $dataCategory['target'],
                'actual' => $dataCategory['actual'],
                'percentase' =>  $percentase,
                'data' => $dataCategory
            ];
        }

        return  $categoryAll;
    }


    /** SAP chart dashboard monthly */
    public function ApiDashboardMonthly(Request $request)
    {
        return $this->SapCategoryAll($request);
    }

    /**Departement */
    public function  SapDepartments(Request $request)
    {
        return $this->SapChart($request)['data']['yearly'];
    }
}























// $partName = 'inspe';
// if (is_numeric(stripos($slug, $partName))) {
// } else {
//     $category_name = ["observa", "hazar", "talk"];
//     foreach ($category_name as $index => $list) {
//         if (is_numeric(stripos($slug, $list))) {
//             $partName = $list;
//         }
//     }
// }