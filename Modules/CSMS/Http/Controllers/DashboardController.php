<?php

namespace Modules\CSMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CSMS\Entities\CsmsChecklist;
use Modules\CSMS\Entities\CsmsPjo;
use Modules\CSMS\Entities\Bidding;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{

    public function dashboardIndex(request $request)
    {
        //filter
        $thisYear = date('Y');
        $lastYear = $thisYear - 1;

        $thisMonth = date('m');
        $lastMonth = Carbon::now()->subMonth(1)->format('m');
        $lastMonthYear = Carbon::now()->subMonth(1)->format('Y');

        $month = ($request->months) ? $request->months : null;
        $arrayMonth = $month ? explode(",", $month) : [];

        $year = ($request->years) ? $request->years : $thisYear;
        $arrayYear = explode(",", $year);

        $companyId = ($request->companies) ? $request->companies : null;
        $arrayCompanyId = $companyId ? explode(",", $companyId) : [];

        //proccess
        $yearExists = CsmsChecklist::groupByRaw('YEAR(created_at)')
            ->get([DB::raw('created_at as year')]);

        //DETAILS
        $ytd = CsmsChecklist::whereRaw('YEAR(created_at) in (' . $year . ')')->count();
        $complete = CsmsChecklist::whereRaw('YEAR(created_at) in (' . $year . ')')
            ->where('point', 'POST KUALIFIKASI')
            ->count();

        $yearly = [
            'ytd' => $ytd,
            'percent' => $complete & $ytd ? round(($complete / $ytd * 100), 0) : 0,
        ];

        $manualCategory = [
            ['name' => 'Bidding', 'slug' => 'BIDDING PROCESS'],
            ['name' => 'Extension', 'slug' => 'PERPANJANGAN SERTIFIKASI CSMS'],
            ['name' => 'Qualification', 'slug' => 'POST KUALIFIKASI']
        ];

        //year
        $detail = [];
        foreach ($manualCategory as $c) {
            $cName = $c['name'];
            $cSlug = $c['slug'];

            $dataThisYear = CsmsChecklist::whereRaw('YEAR(created_at) in (' . $thisYear . ')')->where('point', $cSlug)->count();
            $dataLastYear = CsmsChecklist::whereRaw('YEAR(created_at) in (' . $lastYear . ')')->where('point', $cSlug)->count();
            $detail[] = [
                'name' => ucfirst(strtolower($cName)),
                'this_year' =>  $dataThisYear,
                'this_year_percent' =>  $dataThisYear  && $ytd ? round(($dataThisYear / $ytd * 100), 0) : 0,
                'this_year_mark' => $dataThisYear > $dataLastYear ? 'up' : 'down'
            ];
        }

        //MONTHLY
        $monthly = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));
                $countMonthly = CsmsChecklist::whereYear('created_at', $yearList)
                    ->whereMonth('created_at', $i)
                    ->count();
                $monthly[] = [
                    'month' => $month_name,
                    'count' => $countMonthly
                ];
                $i++;
            } while ($i <= 12);
        }
        //filter by month
        if (count($arrayMonth) > 0) {
            $monthly = collect($monthly)->whereIn('month', $arrayMonth);
            $monthly->all();
        }

        //CATEGORY
        //gouping category
        $category = CsmsChecklist::groupBy('point')
            ->get([DB::raw('point as name')]);

        $categories = [];
        foreach ($category as $categoryList) {
            $countCategory = CsmsChecklist::whereRaw('YEAR(created_at) in (' . $year . ')')
                ->where('point',  $categoryList['name'])
                ->count();

            $categories[] = [
                'name' => ucfirst(strtolower($categoryList['name'])),
                'value' => ($countCategory && $ytd) ? round(($countCategory / $ytd * 100), 0) : 0,
                'count' => $countCategory
            ];
        }

        //progress
        $valid =  Bidding::whereRaw('YEAR(created_at) in (' . $year . ')')
            ->where(function ($q) {
                $q->where('criteria', 'Post Bidding')
                    ->orWhere('criteria', 'Renewal');
            })
            ->where('status', 'Approved') //valid = approved
            ->count();


        $expires =  Bidding::whereRaw('YEAR(created_at) in (' . $year . ')')
            ->where(function ($q) {
                $q->where('criteria', 'Post Bidding')
                    ->orWhere('criteria', 'Renewal');
            })
            ->where('status', 'Inactive') //Expires = inactive
            ->count();

        $biddingAll = $valid + $expires;
        $valid_percent = $valid && $biddingAll ? round(($valid / $biddingAll * 100), 0) : 0;
        $expires_percent = $expires && $biddingAll ? round(($expires / $biddingAll * 100), 0) : 0;

        $progress = [
            'pra_kualifikasi_valid' => [
                'name' => 'Pra Qualification Valid',
                'target' => $valid_percent ? 100 - $valid_percent : 0,
                'actual' => $valid_percent
            ],
            'pra_kualifikasi_expired' => [
                'name' => 'Pra Qualification Expired',
                'target' => $expires_percent ? 100 - $expires_percent : 0,
                'actual' => $expires_percent
            ],
            'certification_extention_valid' => [
                'name' => 'Certification Extention Valid',
                'target' => $valid_percent ? 100 - $valid_percent : 0,
                'actual' => $valid_percent
            ],
            'certification_extention_expired' => [
                'name' => 'Certification Extention Expired',
                'target' => $expires_percent ? 100 - $expires_percent : 0,
                'actual' => $expires_percent
            ]
        ];

        return [
            'yearly' => $yearly,
            'detail' => $detail,
            'monthly' => $monthly,
            'category' => $categories,
            'progress' => $progress
        ];
    }
}
