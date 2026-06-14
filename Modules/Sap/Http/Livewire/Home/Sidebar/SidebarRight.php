<?php

namespace Modules\Sap\Http\Livewire\Home\Sidebar;

use Livewire\Component;
use App\Models\MainDashboard\RunningDate;
use Illuminate\Support\Facades\DB;
use App\Access\dateSetup;
use Modules\Sap\Entities\SapDepartmentCodes;

class SidebarRight extends Component
{
    public $monthCount = 12;
    public $yearCount = 100;
    public $companyCount = 1000;
    public $departmentCount = 1000;
    public $query;

    public $input = [
        'month' => 'january',
        'month_start' => 'january',
        'month_end' => 'december',
    ];
    public $months = [];
    public $years = [];
    public $departmentCodes = [];
    public $departments = [];
    public $grades = [];

    public $companies = [];
    public $data = [];
    public $route_name;

    //query
    public $month, $year, $department, $grade;


    public function mount()
    {
        // $this->departmentCodes = [
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
        //     ['code' => 'PROC', 'checked' => false]
        // ];

        $departementCode = SapDepartmentCodes::has('dataDepartment')
            ->selectRaw("
            code,
            false as checked
        ")
            ->orderBy('code', 'ASC')
            ->get();

        $this->departmentCodes =  json_decode($departementCode, true);

        $this->route_name = Request()
            ->route()
            ->getName();


        //MONTH
        $this->dataMonths();
        //YEAR
        $this->dataYears();
        //dept
        $this->dataDepartment();
        //grade
        $this->dataGrade();

        //olah filter
        $month = Request()->get('month');
        $months = (explode(",", $month));
        if (empty($month)) {
            $this->input['month'] =  intval(date('m'));
        } else {
            $this->input['month'] =  $month;
        }

        foreach ($months as $item) {
            if ($item) {
                $this->SelectMonths($item);
            }
        }

        $month_start = Request()->get('month_start');
        if ($month_start) {
            $this->input['month_start'] = $month_start;
        }

        $month_end = Request()->get('month_end');
        if ($month_end) {
            $this->input['month_end'] = $month_end;
        }

        $years = Request()->get('year');
        $years = (explode(",", $years));
        foreach ($years as $item) {
            if ($item) {
                $this->SelectYear($item);
            }
        }

        $department = Request()->get('department');
        $department = (explode(",", $department));
        foreach ($department as $item) {
            if ($item) {
                $this->SelectDept($item);
            }
        }
        $this->dataDepartment();

        $grade = Request()->get('grade');
        $grade = (explode(",", $grade));
        foreach ($grade as $item) {
            if ($item) {
                $this->SelectGrade($item);
            }
        }
    }

    //membuat Bulan
    public function dataMonths($jumlah = null)
    {
        if ($jumlah) {
            $this->monthCount = $jumlah;
        }
        $this->months =  dateSetup::month(null, $jumlah);
    }

    //membuat tahun
    public function dataYears($jumlah = null)
    {
        $this->years = dateSetup::yearPlus();
    }


    //membuat department
    public function dataDepartment($jumlah = 3)
    {
        if ($jumlah) {
            $this->departmentCount = $jumlah;
        }

        $departmentCodes = $this->departmentCodes;
        $Codes = [];
        for ($i = 0; $i < $jumlah; $i++) {
            if (isset($departmentCodes[$i])) {
                $Codes[] = $departmentCodes[$i];
            } else {
                break;
            }
        }
        $this->departments = $Codes;
    }

    //membuat grade
    public function dataGrade($jumlah = null)
    {
        $this->grades = [
            [
                'grade' => 'Dept Head',
                'grade_code' => 'pjo',
                'checked' => false
            ],
            [
                'grade' => 'Foreman, Spv, S/H',
                'grade_code' => 'pja',
                'checked' => false
            ],
            [
                'grade' => 'Karyawan',
                'grade_code' => 'maker',
                'checked' => false
            ]
        ];
    }


    public function SelectMonth($item = null)
    {
        foreach ($this->months as $index => $list) {
            $this->months[$index]['checked'] = false;
        }
        $index =  array_search($this->input['month_start'], array_column($this->months, 'month_name'));
        $this->months[$index]['checked']  = true;
        $this->ArrayToQuery();
    }

    public function SelectMonths($item = null)
    {

        // input antara
        $month_start = isset($this->input['month_start']) ? $this->input['month_start'] :  1;
        $month_start = intval(date('m', strtotime($month_start)));
        $month_end =  isset($this->input['month_end']) ? $this->input['month_end'] : 12;
        $month_end = intval(date('m', strtotime($month_end)));

        if ($month_start && $month_end) {
            foreach ($this->months as $index => $list) {
                $this->months[$index]['checked'] = false;
            }

            for ($i = $month_start; $i <= $month_end; $i++) {
                $index =  array_search($i, array_column($this->months, 'month'));
                $this->months[$index]['checked']  = true;
            }
            $this->ArrayToQuery();
        }

        //      model checked
        //     $index =  array_search($item, array_column($this->months, 'month_name'));
        //     $row = $this->months[$index];

        //     if ($row['checked'] == true) {
        //         $this->months[$index]['checked'] = false;
        //     } else {
        //         $this->months[$index]['checked']  = true;
        //     }
        //     $this->ArrayToQuery();
    }

    public function SelectYear($item)
    {
        //radio button
        foreach ($this->years as $index => $list) {
            $this->years[$index]['checked'] = false;
        }

        $index =  array_search($item, array_column($this->years, 'year'));
        $row = $this->years[$index];

        if ($row['checked'] == true) {
            $this->years[$index]['checked'] = false;
        } else {
            $this->years[$index]['checked']  = true;
        }
        $this->emit('postAdded');
        $this->ArrayToQuery();
    }



    public function SelectDept($item)
    {
        $index =  array_search($item, array_column($this->departmentCodes, 'code'));
        $row = $this->departmentCodes[$index];
        if ($row['checked'] == true) {
            $this->departmentCodes[$index]['checked'] = false;
        } else {
            $this->departmentCodes[$index]['checked']  = true;
        }
        $this->ArrayToQuery();
    }


    public function SelectGrade($item)
    {
        $index =  array_search($item, array_column($this->grades, 'grade_code'));
        $row = $this->grades[$index];

        if ($row['checked'] == true) {
            $this->grades[$index]['checked'] = false;
        } else {
            $this->grades[$index]['checked']  = true;
        }
        $this->ArrayToQuery();
    }

    public function ArrayToQuery()
    {
        $months = collect($this->months)->where('checked', true);
        $months = $months->pluck('month');
        $months = $months->all();
        $months = implode(",", $months);

        $years = collect($this->years)->where('checked', true);
        $years = $years->pluck('year');
        $years = $years->all();
        $years = implode(",", $years);
        $this->emit('changeYear', $years);

        $departments = collect($this->departmentCodes)->where('checked', true);
        $departments = $departments->pluck('code');
        $departments = $departments->all();
        $departments = implode(",", $departments);

        $grades = collect($this->grades)->where('checked', true);
        $grades = $grades->pluck('grade_code');
        $grades = $grades->all();
        $grades = implode(",", $grades);

        $year =  $years ? $years : date('Y');
        $data = [
            'month' => $months,
            'month_start' => $this->input['month_start'],
            'month_end' => $this->input['month_end'],
            'year' => $year,
            'department' => $departments,
            'grade' => $grades
        ];

        $this->data = $data;

        //refresh API
        $query = http_build_query($data);
        $this->query = $query;
        $this->emit('filter', ['query' => $query, 'filter' => $data]);
        $this->dispatchBrowserEvent('getAPI', ['query' => $query]);
        return ['query' => $query, 'filter' => $data];
    }

    public function filter()
    {
        $filter = $this->ArrayToQuery();
        $this->emit('submitFilter', $filter);
    }

    public function render()
    {
        return view('sap::livewire.home.sidebar.sidebar-right');
    }
}
