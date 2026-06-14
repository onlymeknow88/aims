<?php

namespace Modules\Sap\Http\Livewire\Home;

use Livewire\Component;
use Carbon\Carbon;
use Modules\Sap\Http\Controllers\Api\ApiController;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Sap\Exports\Dashboard as DashboardExport;
use App\Access\dateSetup;
use Illuminate\Support\Facades\Cache;

class Index extends Component
{
    public $filter = [
        'search' => null,
        'year' => null,
        'month' => null,
        'department' => null,
        'grade' => null
    ];

    public $month, $year, $department, $grade;
    public $data_all = [];

    protected $listeners = ['filter', 'submitFilter'];
    public function filter($filter)
    {
    }

    public function submitFilter($filter)
    {
        $filter = $filter['filter'];
        foreach ($filter as $index => $item) {
            $this->filter[$index] = $item;
        }
        
    }

    public function mount()
    {
        $this->filter['year'] = date('Y');
        //ambil dari query url
        if (Request()->get('month')) {
            $month = Request()->get('month');
            $month = count(explode(",", $month)) == 1 ? $month : date('m');
            $this->filter['month'] = $month;
        }

        if (Request()->get('year')) {
            $this->filter['year'] = Request()->get('year');
        }
        if (Request()->get('department')) {
            $this->filter['department'] = Request()->get('department');
        }
        if (Request()->get('grade')) {
            $this->filter['grade'] = Request()->get('grade');
        }

        $this->getData();
    }

    public function getData()
    {
        $filter = $this->filter;
        $request = [];
        $request['year'] = isset($filter['year']) ? $filter['year'] : date('Y');
        $request['month'] = isset($filter['month']) ? $filter['month'] : NULL;
        $request['department'] = isset($filter['department']) ? $filter['department'] : NULL;
        $request['grade'] = isset($filter['grade']) ? $filter['grade'] : NULL;

        $data = (new ApiController)->dataSapChartCategory($request);
        $this->data_all = $data;
    }

    public function download()
    {
        $data = $this->data_all;
        $filename = 'sap_dashboard ' . date('d-m-Y H:i:s') . '.xlsx';
        return Excel::download(new DashboardExport($data), $filename, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function render()
    {
        return view('sap::livewire.home.index')
            ->extends('sap::layouts.dashboard-white');
    }
}
