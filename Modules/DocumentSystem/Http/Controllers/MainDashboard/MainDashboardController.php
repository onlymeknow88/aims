<?php

namespace Modules\DocumentSystem\Http\Controllers\MainDashboard;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\JsaDocument;
use Modules\DocumentSystem\Entities\PtwDocument;

class MainDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $thisMonth = Carbon::now()->format('m');
        $lastMonth = Carbon::now()->subMonth(1)->format('m');
        $lastMonthYear = Carbon::now()->subMonth(1)->format('Y');

        $thisYear = Carbon::now()->format('Y');
        $lastYear = $thisYear - 1;

        $months = ($request->months) ? $request->months : null;
        $arrayMonth = $months ? explode(",", $months) : [];

        $years = ($request->years) ? $request->years : $thisYear;
        $arrayYear = explode(",", $years);

        $companyIds = ($request->companies) ? $request->companies : null;
        $arrayCompanyId = $companyIds ? explode(",", $companyIds) : [];

        // dd(isset($request->months), $years, $companyIds);
        $thisYearCount = Document::whereRaw('YEAR(created_at) in (' . $thisYear . ')')->count();
        $lastYearCount = Document::whereRaw('YEAR(created_at) in (' . $thisYear - 1 . ')')->count();

        $dataDocument = Document::when(isset($request->months) && $request->months != '', function ($query) use ($request, $months) {
            return $query->whereRaw('MONTH(created_at) in (' . $months . ')');
        })
            ->when(isset($request->years) && $request->years != '', function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereHas('department', function ($query) use ($request, $companyIds) {
                    return $query->whereIn('company_id', explode(',', $companyIds));
                });
            });

        $all = $dataDocument->count();

        $ytd =  $dataDocument->where('status', Document::ACTIVE)->count();
        $categories =   [
            [
                'name' => 'Document',
                'status' => Document::ACTIVE,
            ],
            [
                'name' => 'Job Safety Analysis',
                'status' => JsaDocument::ACTIVE,
            ],
            [
                'name' => 'Permit to Work',
                'status' => PtwDocument::ACTIVE,
            ]
        ];

        $categoryAll = [];
        foreach ($categories as $list) {
            $categoryCount = Document::whereNotNull('status')->whereRaw('YEAR(created_at) in (' . $years . ')');
            if (count($arrayMonth) > 0) {
                $categoryCount = $categoryCount->whereRaw('MONTH(created_at) in (' . $months . ')');
            }
            if (count($arrayCompanyId) > 0) {
                $categoryCount = $categoryCount->whereHas('department', function ($query) use ($companyIds) {
                    return $query->whereIn('company_id', explode(',', $companyIds));
                });
            }
            $categoryCount = $categoryCount->where('status', $list['status']);
            $categoryCount = $categoryCount->count();
            $categoryAll[] = [
                'name' => $list['name'],
                'value' =>  $categoryCount
            ];
        }

        //monthly 
        $m = [];
        for ($i = 1; $i <= 12; $i++) {
            $mo = Carbon::create(null, $i, 1)->format('M');
            $label = $mo;

            $dataMontlhy = Document::whereMonth('created_at', $i)
                ->when(isset($request->years) && $request->years != '', function ($query) use ($years) {
                    return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
                })
                ->when(isset($request->companies), function ($query) use ($companyIds) {
                    return $query->whereHas('department', function ($query) use ($companyIds) {
                        return $query->whereIn('company_id', explode(',', $companyIds));
                    });
                });
            $tar = $dataMontlhy->count();
            $act =  $dataMontlhy->where('status', Document::ACTIVE)->count();

            $m[$label] = [
                'month' => $i,
                'target' => $tar,
                'actual' => $act,
            ];
        }

        //filter
        if (count($arrayMonth) > 0) {
            $m = collect($m)->whereIn('month', $arrayMonth);
            $m->all();
        }

        //donat
        $donat_document = Document::when(isset($request->months)  && $request->months != '', function ($query) use ($request, $months) {
            return $query->whereRaw('MONTH(created_at) in (' . $months . ')');
        })
            ->when(isset($request->years) && $request->years != '', function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereHas('department', function ($query) use ($request, $companyIds) {
                    return $query->whereIn('company_id', explode(',', $companyIds));
                });
            });


        $donat_active = $donat_document->where('status', 5)->count();

        $donat_obsolute = $donat_document->where('status', 8)->count();

        $donat_active_percent = $donat_active && $all ?  round(($donat_active / $all * 100), 0) : 0;
        $donat_obsolute_percent =  $donat_obsolute && $all ? round(($donat_obsolute / $all * 100), 0) : 0;

        $donat = [
            'active' => [
                'target' => 100 - $donat_active_percent,
                'actual' => $donat_active_percent,
            ],
            'obsolute' => [
                'target' => 100 - $donat_obsolute_percent,
                'actual' => $donat_obsolute_percent
            ]
        ];

        //details
        //yearly
        $data_done_year = Document::whereYear('created_at', $thisYear);
        $done_year = $data_done_year->where('status', Document::ACTIVE)->count();
        $target_year = $thisYearCount;

        $data_done_past_year = Document::whereYear('created_at', $lastYear);
        $done_past_year =  $data_done_past_year->where('status', Document::ACTIVE)->count();
        $target_past_year =  $lastYearCount;

        //monthly
        $data_done_month = Document::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear);
        $done_month = $data_done_month->where('status', Document::ACTIVE)->count();
        $target_month =  $thisYearCount;

        $data_done_past_month = Document::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear);
        $done_past_month = $data_done_past_month->where('status', Document::ACTIVE)->count();
        $target_past_month =  $thisYearCount;

        return response()->json([
            'data' => [
                'ytd' => [
                    'target' => $all,
                    'actual' => $ytd,
                ],
                'barChartByMonth' => $m,
                'barChartByCategory' => $categoryAll,
                'donutChartByTarget' => [
                    'target' => $all,
                    'actual' => $ytd,
                ],
                'donut' => $donat,
                'summary_all' => $all,
                'summary_monthly' => [
                    'this_month_done' => $done_month,
                    'this_month_target' => $target_month,
                    'this_month_percent' => $done_month && $target_month ?  round($done_month / $target_month * 100, 0) : 0,
                    'this_month_mark' => $done_month > $done_past_month ? 'up' : 'down',

                    'past_month_done' => $done_past_month,
                    'past_month_target' => $target_past_month,
                    'past_month_percent' => $done_past_month && $target_past_month ?  round($done_past_month / $target_past_month * 100, 0) : 0,
                    'past_month_mark' => $done_month > $done_past_month ? 'up' : 'down'
                ],

                'summary_yearly' => [
                    'this_year_done' => $done_year,
                    'this_year_target' => $target_year,
                    'this_year_percent' => $done_year && $target_year ?  round($done_year / $target_year * 100, 0) : 0,
                    'this_year_mark' => $done_year > $done_past_year ? 'up' : 'down',

                    'past_year_done' => $done_past_year,
                    'past_year_target' => $target_past_year,
                    'past_year_percent' => $done_past_year && $target_past_year ?  round($done_past_year / $target_past_year * 100, 2) : 0,
                    'past_year_mark' => $done_year > $done_past_year ? 'down' : 'up'

                ],
            ]
        ]);
    }
}
