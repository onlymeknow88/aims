<?php

namespace Modules\Sap\Http\Livewire\Summary;

use Livewire\Component;
use App\Access\ApiModules;
use Carbon\Carbon;

use Modules\Sap\Http\Controllers\Api\ApiController;

use Modules\Sap\Entities\SapSetup;
use App\Access\dateSetup;
use Modules\Sap\Entities\SapMonthlyEmployee;
use Modules\Sap\Entities\SapSetupCategory;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Sap\Exports\Summary as SummaryExport;

class Index extends Component
{
    public $apiResponse = [];
    public $ach = 0;
    public $title;

    public $slug;
    public $data;
    public $employee = [];
    public $months = [];

    public $search = null;
    public $year = null;
    public $tahun = 0;

    public $filter = [
        'search' => null,
        'year' => null,
        'month' => null,
        'department' => null,
        'grade' => null
    ];

    protected $queryString = ['year'];

    public function mount($slug = null, $year = null)
    {

        $this->filter['year'] = date('Y');
        //ambil dari query url
        if (Request()->get('month')) {
            $month = Request()->get('month');
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

        if ($slug) {
            $setup = SapSetup::where('slug', $slug)->first();
            $this->title = $setup ? $setup->safety_accountability_progam : null;
        }

        if ($this->year) {
            $this->year = $this->year;
        } else {
            $thisYear = date('Y');
            $this->year = $thisYear;
        }

        //MONTH
        $month = dateSetup::month($this->year);
        $this->months = $month;

        $this->slug = $slug;
        $this->submitFilter(['filter' => $this->filter]);
    }

    protected $listeners = ['search', 'filter', 'submitFilter'];

    public function search($search)
    {
        $this->filter['search'] = $search;
        $this->getData();
    }

    public function filter($filter)
    {
    }

    public function submitFilter($filter)
    {
        $filter = $filter['filter'];
        foreach ($filter as $index => $item) {
            $this->filter[$index] = $item;
        }
        $this->year = $this->filter['year'] ?  $this->filter['year'] : date('Y');

        $month = $this->filter['month'];
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

        $this->getData($this->slug);
    }

    public function getData($slug = null)
    {
        //jadi satu dengan API agar 1 action
        $request = [];
        $request['search'] = isset($this->filter['search']) ? $this->filter['search'] : null;
        $request['month'] = $this->filter['month'];
        $request['year'] = $this->filter['year'];
        $request['department'] = $this->filter['department'];
        $request['grade'] = $this->filter['grade'];
        $request['company'] = null;
        $this->employee = (new ApiController)->dataSapCategory($slug, $request);
    }

    public function download($slug = null)
    {
        $months = $this->months;
        $employee = $this->employee;
        $filename = 'summary ' . date('d-m-Y H:i:s') . '.xlsx';
        return Excel::download(new  SummaryExport($months, $employee), $filename, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function render()
    {
        return view('sap::livewire.summary.index')
            ->extends('sap::layouts.dashboard-white');
    }
}
