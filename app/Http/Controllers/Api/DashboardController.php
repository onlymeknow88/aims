<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainDashboard\Banner;
use App\Models\MainDashboard\Production;
use App\Access\dateSetup;
use DB;

class DashboardController extends Controller
{
    public function Banner()
    {
        $data = Banner::where('visible', 'true')->first();
        return [
            'status' => $data ? true : false,
            'url' => $data ? $data->url : null
        ];
    }

    public function Production(request $request)
    {
        $thisYear = date('Y');
        $thisMonth = date('m');

        $month = $request->get('months') ? $request->get('months') : null;
        $arrayMonth = $month ? explode(",", $month) : [];

        $year = $request->get('years') ? $request->get('years') : $thisYear;
        $arrayYear = explode(",", $year);

        $companyId = ($request->companies) ? $request->companies : null;
        $arrayCompanyId = $companyId ? explode(",", $companyId) : [];

        //this year
        $dataThisYear = Production::where('visible', 'true')
            ->selectRaw("
                *,
                coal_shiping+
                waste_removal+
                coal_mining+
                coal_hauling+
                coal_barged as total
            ");
        $dataThisYear = $dataThisYear->whereYear('month', $thisYear)->get();
        $totalThisYear = collect($dataThisYear)->sum('total');

        //this month
        $dataThisMonth = Production::where('visible', 'true')
            ->selectRaw("
            *,
            coal_shiping+
            waste_removal+
            coal_mining+
            coal_hauling+
            coal_barged as total
        ");
        $dataThisMonth = $dataThisMonth->whereYear('month', $thisYear)
            ->whereYear('month', $thisMonth)
            ->get();
        $totalThisMonth = collect($dataThisYear)->sum('total');

        $actual = $totalThisMonth && $totalThisYear  ? ($totalThisMonth / $totalThisYear * 100) : 0;
        $progress = [
            'actual' => $actual,
            'target' => $actual ? 100 - $actual : 0
        ];

        $getCategory =  [
            [
                'name' => 'Coal Shiping',
                'slug' => 'coal_shiping'
            ],
            [
                'name' => 'Waste Removal',
                'slug' => 'waste_removal'
            ],
            [
                'name' => 'Coal Mining',
                'slug' => 'coal_mining'
            ],
            [
                'name' => 'Coal Hauling',
                'slug' => 'coal_hauling'
            ],
            [
                'name' => 'Coal Barged',
                'slug' => 'coal_barged'
            ]
        ];

        //yearly
        $yearly = [];
        //$dataYear = dateSetup::yearPlus();
        $dataYear = Production::where('visible', 'true')->groupByRaw('YEAR(month)')->get([DB::raw(" DATE_FORMAT(month, '%Y') as year")]);
        foreach ($dataYear as $listYear) {
            $production = Production::where('visible', 'true')
                ->selectRaw("
                *,
                coal_shiping+
                waste_removal+
                coal_mining+
                coal_hauling+
                coal_barged as total
            ");
            $prod = $production->whereYear('month',  $listYear['year'])->get();
            $total = collect($prod)->sum('total');

            $yearlyCategory = [];
            foreach ($getCategory as $categoryList) {
                $totalCategory = collect($prod)->sum($categoryList['slug']);
                $yearlyCategory[] = [
                    'name' => $categoryList['name'],
                    'total' => $totalCategory
                ];
            }

            $yearly[] = [
                'year' => $listYear['year'],
                'total' => $total,
                'category' => $yearlyCategory
            ];
        }

        //monthly
        $tahun = is_array($year) ? $thisYear : $year;
        $dataMonth = dateSetup::month($tahun);
        $monthly = [];
        foreach ($dataMonth  as $month) {
            $production = Production::where('visible', 'true')
                ->selectRaw("
                *,
                coal_shiping+
                waste_removal+
                coal_mining+
                coal_hauling+
                coal_barged as total
            ");
            $prod = $production->whereYear('month',  $month['year'])
                ->whereMonth('month',  $month['month'])
                ->get();
            $total = collect($prod)->sum('total');
            $monthly[] = [
                'month' =>  ucfirst($month['month2']),
                'total' => $total
            ];
        }


        $categories = [];
        foreach ($getCategory  as $category) {
            $production = Production::where('visible', 'true')
                ->selectRaw("
                *,
                coal_shiping+
                waste_removal+
                coal_mining+
                coal_hauling+
                coal_barged as total
            ");
            $total = $production->whereYear('month',  $year)->sum($category['slug']);

            $categories[] = [
                'category' =>  $category['name'],
                'total' => $total
            ];
        }

        return [
            //'data' => $production->get(),
            'query' => $request->all(),
            'yearly' => $yearly,
            'monthly' => $monthly,
            'category' => $categories,
            'progress' => $progress
        ];
    }
}
