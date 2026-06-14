<?php

namespace App\Http\Livewire\MainDashboard\Public\Widgets;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\MainDashboard\RunningDate;
use App\Models\Company;
use App\Access\dateSetup;

class Filter extends Component
{
    public $monthCount = 12;
    public $yearCount = 100;
    public $companyCount = 1000;

    public $query;
    public $months = [];
    public $years = [];
    public $companies = [
        //['company' => 'PT Karya Maju Bersama', 'checked' => false],
        //['company' => 'PT Sejahtera Mandiri', 'checked' => false],
        //['company' => 'PT Kita', 'checked' => false],
    ];

    public function mount()
    {


        //MONTH
        $this->dataMonths();

        //YEAR
        $this->dataYears();

        //companies
        $this->dataCompanies();

        //olah filter
        $month = Request()->get('month');
        $month = (explode(",", $month));
        foreach ($month as $item) {
            if ($item) {
                $this->SelectMonth($item);
            }
        }

        $years = Request()->get('year');
        $years = (explode(",", $years));
        foreach ($years as $item) {
            if ($item) {
                $this->SelectYear($item);
            }
        }

        $company = Request()->get('company');
        $company = (explode(",", $company));
        foreach ($company as $item) {
            if ($item) {
                $this->SelectCompany($item);
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
        $this->years = dateSetup::year($jumlah);
    }

    //membuat company
    public function dataCompanies($jumlah = null)
    {
        if ($jumlah) {
            $this->companyCount = $jumlah;
        }

        $companies = Company::groupBy('company_name')
            ->select(
                'company_name',
                'id',
                DB::raw("'' as checked")
            )
            ->take($this->companyCount)
            ->get();
        $this->companies = json_decode($companies, true);
    }



    public function SelectMonth($item)
    {
        $index =  array_search($item, array_column($this->months, 'month_'));
        $row = $this->months[$index];

        if ($row['checked'] == true) {
            $this->months[$index]['checked'] = false;
        } else {
            $this->months[$index]['checked']  = true;
        }
        $this->ArrayToQuery();
    }

    public function SelectYear($item)
    {
        $index =  array_search($item, array_column($this->years, 'year'));
        $row = $this->years[$index];

        if ($row['checked'] == true) {
            $this->years[$index]['checked'] = false;
        } else {
            $this->years[$index]['checked']  = true;
        }
        $this->ArrayToQuery();
    }


    public function SelectCompany($item)
    {
        $index =  array_search($item, array_column($this->companies, 'id'));
        $row = $this->companies[$index];

        if ($row['checked'] == true) {
            $this->companies[$index]['checked'] = false;
        } else {
            $this->companies[$index]['checked']  = true;
        }
        $this->ArrayToQuery();
    }

    public function ArrayToQuery()
    {
        $months = collect($this->months)->where('checked', true);
        $months = $months->pluck('month_');
        $months = $months->all();
        $months = implode(",", $months);

        $years = collect($this->years)->where('checked', true);
        $years = $years->pluck('year');
        $years = $years->all();
        $years = implode(",", $years);

        $companies = collect($this->companies)->where('checked', true);
        $companies = $companies->pluck('id');
        $companies = $companies->all();
        $companies = implode(",", $companies);

        $data = [
            'month' => $months,
            'years' => $years,
            'company' => $companies
        ];

        //refresh API
        $query = http_build_query($data);
        $this->query = $query;

        //listener
        $this->emit('filter', ['data' => $data, 'query' => $query]);
        $this->emit('getAPI', $query);
        $this->dispatchBrowserEvent('getAPI', ['query' => $query]);
    }



    public function render()
    {
        //$this->ArrayToQuery();
        return view('livewire.main-dashboard.public.widgets.filter');
    }
}
