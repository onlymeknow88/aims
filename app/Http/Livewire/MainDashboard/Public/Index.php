<?php

namespace App\Http\Livewire\MainDashboard\Public;

use Livewire\Component;
use Illuminate\Http\Request;

use App\Models\MainDashboard\General;

use Modules\Coe\Http\Controllers\CoeController as Coe; //coe
use Modules\DocumentSystem\Http\Controllers\MainDashboard\MainDashboardController as Ds; //document system
use Modules\Sap\Http\Controllers\Api\ApiController as Sap; //sap
use Modules\FieldLeadership\Http\Controllers\MainDashboard\MainDashboardController as Fl; //fl
use Modules\Kplh\Http\Controllers\KplhController as Kplh; //inpection
use Modules\Audit\Http\Controllers\Api\AuditController as Audit; //Audit
use Modules\KO\Http\Controllers\Api\DashboardController as Ko; //safety_operation
use Modules\IbprAndBowtie\Http\Controllers\DashboardController as IbprAndBowtie; //management_resiko
use Modules\KPP\Http\Controllers\Api\DashboardController as Kpp; //compliance_regulation
use Modules\Mcu\Http\Controllers\McuController as Mcu; //mcu
use Modules\CSMS\Http\Controllers\DashboardController as Csms; //contractor_safety_management_system

//sap
use Modules\Sap\Http\Controllers\Api\ApiController as SapChart;

//dashboard
use App\Http\Controllers\Api\DashboardController as Production;


class Index extends Component
{
    public $query = [];
    public $general = [];
    public $check;
    public $filter;

    public $dataCoe = [];
    public $dataDs = [];
    public $dataSap = [];
    public $dataFi = [];
    public $dataKplh = [];
    public $dataAudit = [];
    public $dataKo = [];
    public $dataIbprAndBowtie = [];
    public $dataKpp = [];
    public $dataMcu = [];
    public $dataCsms = [];

    public $dataSapYtdHor = [];
    public $dataSapYtdVer = [];
    public $dataSapYtdDept = [];

    public $dataProduction = [];

    public function mount()
    {
        $request = Request();
        $this->filter = $request->all();
        $this->moduleChart($request);
    }

    protected $listeners = ['filter'];
    public function filter($filter)
    {
        $this->filter = $filter['data'];
        $request = Request();
        foreach ($filter['data'] as $index => $list) {
            $request[$index] = $list;
        }

        $this->moduleChart($request);
    }

    public function moduleChart($request)
    {

        //module
        $getCoe = (new Coe)->getAllIn($request);
        $getCoe = json_decode($getCoe->content(), true);
        $this->dataCoe =  $getCoe;

        $getDs = (new Ds)->index($request);
        $getDs = json_decode($getDs->content(), true);
        $this->dataDs = $getDs ? $getDs['data'] : $getDs;

        $getSap = (new Sap)->ApiDashboard($request);
        $getSap = json_decode($getSap->content(), true);
        $this->dataSap = $getSap ? $getSap['data'] : $getSap;

        $getFi = (new Fl)->mainDashboard($request);
        $getFi = json_decode($getFi->content(), true);
        $this->dataFi =  $getFi ?  $getFi['data'] :  $getFi;

        $getKplh = (new Kplh)->getAllIn($request);
        $this->dataKplh = json_decode($getKplh->content(), true);

        $getAudit = (new Audit)->dashboard($request);
        $this->dataAudit = $getAudit ? $getAudit['data'] : $getAudit;

        $getKo = (new Ko)->Index($request);
        $this->dataKo = json_decode($getKo->content(), true);

        $getIbprAndBowtie = (new IbprAndBowtie)->index($request);
        $this->dataIbprAndBowtie = json_decode($getIbprAndBowtie->content(), true);

        $getKpp = (new Kpp)->index($request);
        $this->dataKpp = json_decode($getKpp->content(), true);

        $getMcu = (new Mcu)->getAllIn($request);
        $this->dataMcu = json_decode($getMcu->content(), true);

        $dataCsms = (new Csms)->dashboardIndex($request);
        $this->dataCsms = $dataCsms;

        $this->dataSapYtdHor = (new SapChart)->SapCategoryAll($request);
        $this->dataSapYtdVer = (new SapChart)->SapMonthly($request);
        $this->dataSapYtdDept = (new SapChart)->SapDepartments($request);

        $this->dataProduction = (new Production)->Production($request);
    }

    public function render()
    {
        //new
        $new = General::orderBy('created_at', 'asc')
            ->where('visible', 'true')
            ->get()
            ->last();

        if ($new) {
            $new->project_to_date = number_format($new->project_to_date);
            $new->manhours = number_format($new->manhours);
            $new->day_after_last_lti = number_format($new->day_after_last_lti);
            $new->manpower = number_format($new->manpower);
        }
        $this->general = $new;


        return view('livewire.main-dashboard.public.index')
            ->extends('layouts.main-dashboard.dashboard-white');
    }
}
