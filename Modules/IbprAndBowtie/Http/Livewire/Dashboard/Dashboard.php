<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Dashboard;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Concerns\ToArray;
use Modules\IbprAndBowtie\Http\Controllers\BaseApp;

class Dashboard extends Component
{
    public $label1;
    public $data1;

    public $label2;
    public $data2;
    public $label3;
    public $data3;
    public $label4;
    public $data4;
    public $label5;
    public $data5;

    public $data6;

    public function mount(){
        $this->generateData1();
        $this->generateData2();
        $this->generateData3();
        $this->generateData4();
        $this->generateData5();
        $this->generateData6();
    }

    public function generateData1() {
        $data1 = DB::select('select c.company_name, count(i.id) as amount from companies c  left join ibprs i on i.ccow_id = c.id group by c.company_name');
        $resultsArray = json_decode(json_encode($data1), true);

        $this->label1 = array_map(function ($item) {
            return "'". $item["company_name"]. "'";
        }, $resultsArray);

        $this->data1 = array_map(function ($item) {
            return $item["amount"];
        }, $resultsArray);

    }

    public function generateData2() {
        $data1 = DB::select('select u.name, count(i.id) as amount from employees e left join users u on u.id = e.user_id left join ibprs i on i.pja_id = e.user_id group by u.name');
        $resultsArray = json_decode(json_encode($data1), true);

        $this->label2 = array_map(function ($item) {
            return "'". $item["name"]. "'";
        }, $resultsArray);

        $this->data2 = array_map(function ($item) {
            return $item["amount"];
        }, $resultsArray);

    }

    public function generateData3() {
        $data1 = DB::select("select DISTINCT i.status, (select count(if2.id) from ibprs if2 where if2.status = i.status) as amount from ibprs i where i.status != ''");
        $resultsArray = json_decode(json_encode($data1), true);

        $this->label3 = array_map(function ($item) {
            return "'". $item["status"]. "'";
        }, $resultsArray);

        $this->data3 = array_map(function ($item) {
            return $item["amount"];
        }, $resultsArray);
    }

    public function generateData4() {
        $data1 = DB::select('select c.company_name, count(i.id) as amount from companies c left join bowtie i on i.ccow_id = c.id group by c.company_name ');
        $resultsArray = json_decode(json_encode($data1), true);

        $this->label4 = array_map(function ($item) {
            return "'". $item["company_name"]. "'";
        }, $resultsArray);

        $this->data4 = array_map(function ($item) {
            return $item["amount"];
        }, $resultsArray);

    }

    public function generateData5() {
        $data1 = DB::select('select u.name, count(i.id) as amount from employees e 
        left join users u on u.id = e.user_id  
        left join bowtie i on i.pja_id = e.user_id 
        group by u.name');
        $resultsArray = json_decode(json_encode($data1), true);

        $this->label5 = array_map(function ($item) {
            return "'". $item["name"]. "'";
        }, $resultsArray);

        $this->data5 = array_map(function ($item) {
            return $item["amount"];
        }, $resultsArray);

    }

    public function generateData6() {
        $data1 = DB::select('select c.company_name,
            (select COALESCE(sum(if2.preliminary_consequence_k3), 0) from ibprs i left join ibpr_forms if2 on if2.ibpr_id = i.id WHERE i.ccow_id = c.id) as k3,
            (select COALESCE(sum(if3.preliminary_consequence_lh), 0) from iadl ia left join iadl_forms if3 on if3.iadl_id = ia.id where ia.ccow_id = c.id) as lh,
            (select COALESCE(sum(if2.preliminary_consequence_kp), 0) from ibprs i left join ibpr_forms if2 on if2.ibpr_id = i.id WHERE i.ccow_id = c.id) as kp,
            (select COALESCE(sum(if2.preliminary_consequence_ksl), 0) from ibprs i left join ibpr_forms if2 on if2.ibpr_id = i.id WHERE i.ccow_id = c.id) as ksl,
            (select COALESCE(sum(if2.preliminary_consequence_kk), 0) from ibprs i left join ibpr_forms if2 on if2.ibpr_id = i.id WHERE i.ccow_id = c.id) as kk,
            (select COALESCE(count(if2.preliminary_frequence), 0) from ibprs i left join ibpr_forms if2 on if2.ibpr_id = i.id WHERE i.ccow_id = c.id) as frequency,
            (select COALESCE(count(if2.preliminary_level_of_risk), 0) from ibprs i left join ibpr_forms if2 on if2.ibpr_id = i.id WHERE i.ccow_id = c.id) as level_of_risk,
            (select COALESCE(count(if2.preliminary_main_risk), 0) from ibprs i left join ibpr_forms if2 on if2.ibpr_id = i.id WHERE i.ccow_id = c.id) as main_risk
            from companies c');
        $resultsArray = json_decode(json_encode($data1), true);

        
        $this->data6 = $resultsArray;

    }

    public function generateRandomRGB() {
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
    
        return 'rgb('.$red.', '.$green.', '.$blue.')';
    }

    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.dashboard.dashboard')->layout('ibprandbowtie::layouts.ibpr-and-bowtie');;
    }
}
