<?php

namespace Modules\Audit\Http\Livewire\Dashboard;

use Livewire\Component;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Enums\AuditCategory;

class Index extends Component
{
    public $radarChart = [];

    public $audits;
    public $counts = [];

    protected function getAudit(): void
    {
        $this->audits = Audit::
            groupBy('audit_category')
            ->selectRaw('count(*) as total, audit_category')
            ->get();

        $colors = [
            "green","blue","yellow","pink","blue"
        ];
        $i=0;
        foreach (AuditCategory::asArray() as $key => $value) {
            $this->counts[$i] = [
                "category"=>$value,
                "total" => 0,
                "color" => $colors[$i]
            ];

            foreach ($this->audits as $audit) {
                if($value == $audit->audit_category){
                    $this->counts[$i]["total"] = $audit->total;
                }
            }

            $i++;

        }
        // dd($this->counts);

    }

    public function mount()
    {
        // $this->radarChart = [
        //     'idChart' => 'grafikChart',
        //     'labels' => [
        //         'Kebijakan',
        //         'Perencanaan',
        //         'Organisasi dan Personel',
        //         'Implementasi',
        //         'Pemantauan, Evaluasi, dan Tindak Lanjut',
        //         'Dokumentasi',
        //         'Tijuaan Manajemen dan Peningkatan Kinerja'
        //     ],
        //     'datasets' => [[
        //         'label' => 'Poin SMKP',
        //         'fill' => true,
        //         'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
        //         'borderColor' => 'rgb(54, 162, 235)',
        //         'pointBackgroundColor' => 'rgb(54, 162, 235)',
        //         'pointBorderColor' => '#fff',
        //         'pointHoverBackgroundColor' => '#fff',
        //         'pointHoverBorderColor' => 'rgb(54, 162, 235)',
        //         'data' => [-65, 59, 50, 81, 56, 55, 40]
        //     ]],
        //     'labelX' => [
        //         'display' => true,
        //         'color' => 'rgba(0,0,0,0.8)',
        //         'beginAtZero' => true
        //     ]
        // ];
        $this->getAudit();
    }

    public function render()
    {
        // if (\Auth::user()->hasPermissionTo('Audit - Detail SMKP Notice Letter')) {
            return view('audit::livewire.dashboard.index-main')->layout('audit::livewire.layouts.app');
        // } else {
        //     return abort(404);
        // }

    }
}
