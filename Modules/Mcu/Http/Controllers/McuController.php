<?php

namespace Modules\Mcu\Http\Controllers;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Mcu\Entities\MedicalHistory;

class McuController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasPermissionTo('MCU - View List MCU Medical Staff')) {
            return redirect()->route('mcu::medical-staff');
        } elseif (Auth::user()->hasPermissionTo('MCU - View Dashboard MCU')) {
            return redirect()->route('mcu::doctor');
        } else {
            return redirect()->route('mcu::patient');
        }
        // return view('mcu::index');
    }

    public function getAllIn(Request $r)
    {
        // YTD
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $lastMonth = Carbon::now()->subMonth(1)->format('m');
        $lastMonthYear = Carbon::now()->subMonth(1)->format('Y');
        $lastYear = $thisYear - 1;

        $month = ($r->months) ? $r->months : null;
        $arrayMonth = $month ? explode(",", $month) : [];

        $selectedYear = ($r->years) ? $r->years : $thisYear;
        $arrayYear = explode(",", $selectedYear);

        $companyId = ($r->companies) ? $r->companies : null;
        $arrayCompanyId = $companyId ? explode(",", $companyId) : [];

        $mcu = MedicalHistory::whereNotNull('id');
        if (count($arrayCompanyId) > 0) {
            $mcu = $mcu->whereHas('employee', function ($q) use ($arrayCompanyId) {
                $q->whereHas('company', function ($q) use ($arrayCompanyId) {
                    $q->whereIn('id',  $arrayCompanyId);
                });
            });
        }

        // END YTD

        /*********
         * DETAILS
         ********/

        //yearly
        $arrayYear = [
            [
                'name' => 'thisYear',
                'year' => $thisYear,
            ]
        ];

        $dataYearly = [];
        foreach ($arrayYear as $listYear) {
            $dataYear = $mcu->whereYear('mcu_date',  $listYear['year']);
            $fit =  $dataYear->where('doctor_status_review', 'DONE')->count();
            $unfit =  $dataYear->where('doctor_status_review', 'Unfit')->count();
            $CurentlyUnfit =  $dataYear->where('doctor_status_review', 'Curently Unfit')->count();
            $FitWithRecomendation = $dataYear->where('doctor_status_review', 'Fit with Recomendation')->count();
            $countDetailAll = $fit +  $unfit + $CurentlyUnfit + $FitWithRecomendation;

            $fit_percent = $fit && $countDetailAll ? $fit / $countDetailAll / 100 : 0;
            $unfit_percent = $unfit && $countDetailAll ? $unfit / $countDetailAll / 100 : 0;
            $CurentlyUnfit_percent =  $CurentlyUnfit && $countDetailAll ? $CurentlyUnfit / $countDetailAll / 100  : 0;
            $FitWithRecomendation_percent = $FitWithRecomendation && $countDetailAll ? $FitWithRecomendation / $countDetailAll / 100 : 0;
            $dataYearly[$listYear['name']] = [
                'fit' => $fit,
                'fit_percent' => $fit_percent,
                'unfit' => $unfit,
                'unfit_percent' => $unfit_percent,
                'curently_unfit' => $CurentlyUnfit,
                'curently_unfit_percent' => $CurentlyUnfit_percent,
                'fit_with_recomendation' => $FitWithRecomendation,
                'fit_with_recomendation_percent' => $FitWithRecomendation_percent
            ];
        }

        $yearlyAll =  $dataYearly['thisYear'];
        $ytd = $yearlyAll['fit'] + $yearlyAll['unfit'] + $yearlyAll['curently_unfit'] + $yearlyAll['fit_with_recomendation'];
        $ytd_target = 0;

        $annual = MedicalHistory::whereRaw('YEAR(mcu_date) in (' . $selectedYear . ')')
            ->count();

        /***************
         * Dougnut
         */
        $fitDougnut = $dataYearly['thisYear']['fit'];
        $unfitDougnut = $dataYearly['thisYear']['unfit'];
        $curentlyUnfitDougnut = $dataYearly['thisYear']['curently_unfit'];
        $countAllDougnut =  $fitDougnut + $unfitDougnut + $curentlyUnfitDougnut;

        $fitDougnut_percent = $fitDougnut && $countAllDougnut ? $fitDougnut / $countAllDougnut * 100  : 0;
        $unfitDougnut_percent = $unfitDougnut && $countAllDougnut ?  $unfitDougnut / $countAllDougnut * 100 : 0;
        $curentlyUnfitDougnut_percent = $curentlyUnfitDougnut && $countAllDougnut ?  $curentlyUnfitDougnut / $countAllDougnut * 100 : 0;

        $Dougnut = [
            'fit_percent_actual' => $fitDougnut_percent,
            'fit_percent_target' => $fitDougnut_percent ? 100 - $fitDougnut_percent : 0,
            'unfit_percent_actual' => $unfitDougnut_percent,
            'unfit_percent_target' => $unfitDougnut_percent ? 100 - $unfitDougnut_percent : 0,
            'curentlyUnfit_percent_actual' => $curentlyUnfitDougnut_percent,
            'curentlyUnfit_percent_target' => $curentlyUnfitDougnut_percent ? 100 - $curentlyUnfitDougnut_percent : 0,
        ];


        $category = [
            [
                'name' => 'Pre Employment',
                'type' => 'pre-employment'
            ],
            [
                'name' => 'Periodic',
                'type' => 'periodic'
            ],
            [
                'name' => 'Specific',
                'type' => 'specific'
            ],
            [
                'name' => 'Pre Retirement',
                'type' => 'pre-retirement'
            ]
        ];
        $categoryAll = [];
        foreach ($category as $list) {
            $data = MedicalHistory::where('medical_type', $list['type']);
            $data =  $data->whereRaw('YEAR(mcu_date) in (' . $selectedYear . ')');
            if (count($arrayMonth) > 0) {
                $data =   $data->whereRaw('MONTH(mcu_date) in (' . $month . ')');
            }
            $data = $data->count();
            $categoryAll[] = [
                'name' => $list['name'],
                'value' => $data
            ];
        }




        $dataMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $m = $thisYear . '-' . $i . '-1';
            $monthName = date('M', strtotime($m));
            $dataMcu = MedicalHistory::whereNotNull('id');
            if (count($arrayCompanyId) > 0) {
                $dataMcu = $dataMcu->whereHas('employee', function ($q) use ($arrayCompanyId) {
                    $q->whereHas('company', function ($q) use ($arrayCompanyId) {
                        $q->whereIn('id',  $arrayCompanyId);
                    });
                });
            }
            $dataMcu = $dataMcu->whereRaw('YEAR(mcu_date) in (' . $selectedYear . ')')
                ->whereMonth('mcu_date', $i);

            $dataMcu =  $dataMcu->selectRaw("
                    mcu_medical_history.*,
                    DATE_FORMAT(mcu_date, '%M %d %Y' ) as date
            ");

            $dataMonth[$monthName] = [
                'year' => $selectedYear,
                'month' => $i,
                'date' => $m,
                'target' => 0,
                'actual' => $dataMcu->count(),
            ];
        }

        //filter by month
        if (count($arrayMonth) > 0) {
            $dataMonth = collect($dataMonth)->whereIn('month', $arrayMonth);
            $dataMonth->all();
        }

        return response()->json([
            'count_ytd' => [
                'ytd' => $ytd,
                'ytd_target' => $ytd_target,
            ],
            'count_annual' => $annual,
            'count_annual_completion' => $dataYearly,
            'count_by_category' => $categoryAll,
            'completion_by_month' => $dataMonth,
            'progress' => $Dougnut,

        ], 200);
    }

    public function getMcu()
    {
    }

    public function create()
    {
    }
}
