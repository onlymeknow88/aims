<?php

namespace Modules\Audit\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Audit\Entities\Audit;
use Carbon\Carbon;


class AuditController extends Controller
{

    public function dashboard(Request $request)
    {
        $from = Carbon::now();
        $from->startOfYear();
        $to = Carbon::now();

        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $month = ($request->months) ? $request->months : null;
        $arrayMonth = $month ? explode(",", $month) : [];

        $selectedYear = ($request->years) ? $request->years : $thisYear;
        $arrayYear = explode(",", $selectedYear);

        $companyId = ($request->companies) ? $request->companies : null;
        $arrayCompanyId = $companyId ? explode(",", $companyId) : [];

        $countAll = Audit::whereRaw('YEAR(start_at) in (' . $selectedYear . ')')->count();



        $countNotDraft = Audit::whereRaw('YEAR(start_at) in (' . $selectedYear . ')')->where('status', '!=', 'Draft')->count();

        $percentActual = $countNotDraft & $countAll ? round(($countNotDraft / $countAll * 100), 0) : 0;
        $percentTarget = 100 - $percentActual;


        $dataMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $count = Audit::whereRaw('YEAR(start_at) in (' . $selectedYear . ')')->whereMonth('created_at', $i)->get()->count();
            $M = date('M', strtotime(date('Y') . '-' . $i . '-1'));
            $dataMonth[$M] = [
                'month' => $i,
                'target' => 0,
                'actual' => $count
            ];
            $countAll += $count;
        }

        //filter by month
        if (count($arrayMonth) > 0) {
            $dataMonth = collect($dataMonth)->whereIn('month', $arrayMonth);
            $dataMonth->all();
        }

        $kategory = ["SMKP", "SMK3", "ISO45001", "ISO14001", "ISO9001"];
        $dataKategory = [];
        foreach ($kategory as $list) {
            $count = Audit::where('audit_category', $list)->whereRaw('YEAR(start_at) in (' . $selectedYear . ')')->get()->count();
            $countLastYear = Audit::where('audit_category', $list)->whereRaw('YEAR(start_at) in (' . (($request->years) ? $arrayYear[array_key_last($arrayYear)] : $thisYear) - 1 . ')')->get()->count();
            $dataKategory[] = [
                'name' => $list,
                'value' => $count ? round($count /  $countAll * 100, 0) : 0,
                'countThisYear' => $count,
                'countLastYear' => $countLastYear,
                'mark' => $count > $countLastYear ? 'up' : 'down',
            ];
        }


        // dd($audits);
        return ["data" => [
            "ytd" => [
                "target" => $countAll,
                "actual" =>  $countAll
            ],
            "barChartByMonth" => $dataMonth,
            "barChartByCategory" => $dataKategory,
            "progress" => [
                "target" => [
                    "completed" => $percentTarget,
                    "ongoing" => $percentActual
                ],
                "actual" => [
                    "completed" => $percentActual,
                    "ongoing" => $percentTarget
                ]
            ],

            //tidak digunakan
            "summary_all" => 0,
            "summary_monthly" => [
                "this_month_done" => 0,
                "this_month_target" => 0,
                "past_month_done" => 0,
                "past_month_target" => 0
            ],
            "summary_yearly" => [
                "this_year_done" => 0,
                "this_year_target" => 0,
                "past_year_done" => 0,
                "past_year_target" => 0
            ]

        ]];
    }
}
