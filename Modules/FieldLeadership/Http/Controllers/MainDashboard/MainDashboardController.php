<?php

namespace Modules\FieldLeadership\Http\Controllers\MainDashboard;

use App\Enums\FieldLeadership\FieldLeadershipType;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Transformers\MainDashboard\MainDashboardResource;
use DB;

class MainDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function mainDashboard(Request $request)
    {
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $lastMonth = Carbon::now()->subMonth(1)->format('m');
        $lastMonthYear = Carbon::now()->subMonth(1)->format('Y');
        $lastYear = $thisYear - 1;

        $months = ($request->months) ? $request->months : null;
        $arrayMonth = $months ? explode(",", $months) : [];

        $years = ($request->years) ? $request->years : $thisYear;
        $arrayYear = explode(",", $years);

        $companyIds = ($request->companies) ? $request->companies : null;
        $arrayCompanyId = $companyIds ? explode(",", $companyIds) : [];

        // dd(isset($request->months), $years, $companyIds);

        $thisYearCount = FieldLeadership::whereRaw('YEAR(created_at) in (' . $thisYear . ')')->count();
        $lastYearCount = FieldLeadership::whereRaw('YEAR(created_at) in (' . $thisYear - 1 . ')')->count();

        $data = FieldLeadership::when(isset($request->months) && $request->months != '', function ($query) use ($request, $months) {
            return $query->whereRaw('MONTH(created_at) in (' . $months . ')');
        })
            ->when(isset($request->years) && $request->years != '', function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            });
        $all = $data->count();
        $ytd =  $data->where('status', FieldLeadershipType::Close)->count();

        //target SAP
        $bulan = 1;
        $sumTargetSap = 0;
        do {
            $namaBulan = date('F', strtotime('1-' . $bulan . '-' . $thisYear));
            $namaBulan = strtolower($namaBulan);
            $sumPersonalData = DB::table('sap_monthly')->where('year', $thisYear)->sum($namaBulan);
            $sumTargetSap += $sumPersonalData;
            ++$bulan;
        } while ($bulan <= 12);
        $targetSapPercent = $all && $sumTargetSap ? round($all / $sumTargetSap * 100, 0) : 0;

        //kategori
        $categories =   [
            [
                'name' => 'Planned Task Observation',
                'status' => FieldLeadershipType::Close,
            ],
            [
                'name' => 'Take Time Talk',
                'status' => FieldLeadershipType::Close,
            ],
            [
                'name' => 'Hazard Report',
                'status' => FieldLeadershipType::Close,
            ]
        ];

        $categoryAll = [];
        foreach ($categories as $list) {
            $count = FieldLeadership::when(isset($request->months) && $request->months != '', function ($query) use ($request, $months) {
                return $query->whereRaw('MONTH(created_at) in (' . $months . ')');
            })
                ->when(isset($request->years) && $request->years != '', function ($query) use ($request, $years) {
                    return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
                })
                ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                    return $query->whereIn('company_id', explode(',', $companyIds));
                })
                ->where('type', $list['name'])
                ->where('status',  $list['status'])
                ->count();

            $categoryAll[] = [
                'name' => $list['name'],
                'count' => $count,
                'value' => $count && $all ? round($count / $all * 100, 0) : 0,
            ];
        }

        $m = [];
        for ($i = 1; $i <= 12; $i++) {
            $mo = Carbon::create(null, $i, 1)->format('M');
            $label = $mo;

            $data = FieldLeadership::whereMonth('created_at', $i)
                ->when(isset($request->years) && $request->years != '', function ($query) use ($years) {
                    return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
                })
                ->when(isset($request->companies), function ($query) use ($companyIds) {
                    return $query->whereIn('company_id', explode(',', $companyIds));
                });
            $tar = $data->count();
            $act =  $data->where('status', FieldLeadershipType::Close)->count();

            $m[$label] = [
                'month' => $i,
                'target' => $tar,
                'actual' => $act,
            ];
        }

        //filter by month
        if (count($arrayMonth) > 0) {
            $m = collect($m)->whereIn('month', $arrayMonth);
            $m->all();
        }

        //yearly
        $data_year = FieldLeadership::whereYear('created_at', $thisYear);
        $done_year = $data_year->where('status', FieldLeadershipType::Close)->count();
        $target_year = $thisYearCount;

        $data_past_year = FieldLeadership::whereYear('created_at', $lastYear);
        $done_past_year = $data_past_year->where('status', FieldLeadershipType::Close)->count();
        $target_past_year = $lastYearCount;

        //monthly
        $data_monthly = FieldLeadership::whereMonth('created_at', $thisMonth);
        $done_month = $data_monthly->where('status', FieldLeadershipType::Close)->count();
        $target_month = $thisYearCount;


        $data_past_month = FieldLeadership::whereMonth('created_at', $lastMonth)->whereYear('created_at', $lastMonthYear);
        $done_past_month = $data_past_month->where('status', FieldLeadershipType::Close)->count();
        $target_past_month = $thisYearCount;



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
                'donutChartByActual' => [
                    'target' => [
                        'complete' => $targetSapPercent,
                        'ongoing' => $targetSapPercent ? 100 - $targetSapPercent : 0
                    ],
                    'actual' => [
                        'complete' => $targetSapPercent ? 100 - $targetSapPercent : 0,
                        'ongoing' => $targetSapPercent
                    ]
                ],
                'summary_all' => $all,
                'summary_monthly' => [
                    'this_month_done' => $done_month,
                    'this_month_target' => $target_month,
                    'this_month_percent' => $done_month && $target_month ?  round($done_month / $target_month * 100, 0) : 0,
                    'this_month_mark' => $done_month > $done_past_month ?  'up' : 'down',
                    'past_month_done' => $done_past_month,
                    'past_month_target' => $target_past_month,
                    'past_month_percent' => $done_past_month && $target_past_month ?  round($done_past_month / $target_past_month * 100, 0) : 0,
                    'past_month_mark' => $done_month > $done_past_month ?  'down' : 'up',

                ],
                'summary_yearly' => [
                    'this_year_done' => $done_year,
                    'this_year_target' => $target_year,
                    'this_year_percent' => $done_year && $target_year ? round($done_year / $target_year * 100, 0) : 0,
                    'this_year_mark' => $done_year > $done_past_year ? 'up' : 'down',
                    'past_year_done' => $done_past_year,
                    'past_year_target' => $target_past_year,
                    'past_year_percent' => $done_past_year && $target_past_year ? round($done_past_year / $target_past_year * 100, 0) : 0,
                    'past_year_mark' => $done_year > $done_past_year ? 'down' : 'up',
                ],

            ]
        ]);
    }

    public function sap(Request $request)
    {
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $months = ($request->months) ? $request->months : $thisMonth;
        $years = ($request->years) ? $request->years : $thisYear;
        $companyIds = ($request->companies) ? $request->companies : null;


        $all = FieldLeadership::when(isset($request->months), function ($query) use ($request, $months) {
            return $query->whereRaw('MONTH(created_at) in (' . $months . ')');
        })
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->count();

        // SAP
        // Maker
        $sap_user_maker_pto = FieldLeadership::with('createdBy')
            ->selectRaw('count(*) as total, created_by, created_at, company_id')
            ->whereMonth('created_at', $thisMonth)
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->where('type', 'Planned Task Observation')
            ->where('status', FieldLeadershipType::OnReviewPja)
            ->groupBy('created_by')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->createdBy?->user?->id,
                    'employee_number' => $item->createdBy?->user?->employee?->number ?? 0,
                    'name' => $item->createdBy?->user?->name,
                    'total' => $item->total,
                    'document_created' => Carbon::parse($item->created_at)->format('Y-m-d')
                ];
            });

        $sap_user_maker_ttt = FieldLeadership::with('createdBy')
            ->selectRaw('count(*) as total, created_by, created_at, company_id')
            ->whereMonth('created_at', $thisMonth)
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->where('type', 'Take Time Talk')
            ->where('status', FieldLeadershipType::OnReviewPja)
            ->groupBy('created_by')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->createdBy?->user?->id,
                    'employee_number' => $item->createdBy?->user?->employee?->number ?? 0,
                    'name' => $item->createdBy?->user?->name,
                    'total' => $item->total,
                    'document_created' => Carbon::parse($item->created_at)->format('Y-m-d')
                ];
            });

        $sap_user_maker_hr = FieldLeadership::with('createdBy')
            ->selectRaw('count(*) as total, created_by, created_at, company_id')
            ->whereMonth('created_at', $thisMonth)
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->where('type', 'Hazard Report')
            ->where('status', FieldLeadershipType::OnReviewPja)
            ->groupBy('created_by')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->createdBy?->user?->id,
                    'employee_number' => $item->createdBy?->user?->employee?->number ?? 0,
                    'name' => $item->createdBy?->user?->name,
                    'total' => $item->total,
                    'document_created' => Carbon::parse($item->created_at)->format('Y-m-d')
                ];
            });

        // PJA
        $sap_user_pja_pto = FieldLeadership::with('pja')
            ->selectRaw('count(*) as total, pja_id, created_at, company_id')
            ->whereMonth('created_at', $thisMonth)
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->where('type', 'Planned Task Observation')
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->groupBy('pja_id')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->pja?->user?->id,
                    'employee_number' => $item->pja?->user?->employee?->number ?? 0,
                    'name' => $item->pja?->user?->name,
                    'total' => $item->total,
                    'document_created' => Carbon::parse($item->created_at)->format('Y-m-d')
                ];
            });

        $sap_user_pja_ttt = FieldLeadership::with('pja')
            ->selectRaw('count(*) as total, pja_id, created_at, company_id')
            ->whereMonth('created_at', $thisMonth)
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->where('type', 'Take Time Talk')
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->groupBy('pja_id')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->pja?->user?->id,
                    'employee_number' => $item->pja?->user?->employee?->number ?? 0,
                    'name' => $item->pja?->user?->name,
                    'total' => $item->total,
                    'document_created' => Carbon::parse($item->created_at)->format('Y-m-d')
                ];
            });

        $sap_user_pja_hr = FieldLeadership::with('pja')
            ->selectRaw('count(*) as total, pja_id, created_at, company_id')
            ->whereMonth('created_at', $thisMonth)
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->where('type', 'Hazard Report')
            ->where('status', FieldLeadershipType::OnReviewApproval)
            ->groupBy('pja_id')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->pja?->user?->id,
                    'employee_number' => $item->pja?->user?->employee?->number ?? 0,
                    'name' => $item->pja?->user?->name,
                    'total' => $item->total,
                    'document_created' => Carbon::parse($item->created_at)->format('Y-m-d')
                ];
            });

        // PJO
        $sap_user_pjo_pto = FieldLeadership::with('pjo', 'pjo.employee')
            ->selectRaw('count(*) as total, pjo_id, created_at, company_id')
            ->whereMonth('created_at', $thisMonth)
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->where('type', 'Planned Task Observation')
            ->whereIn('status', [FieldLeadershipType::Close, FieldLeadershipType::Open])
            ->groupBy('pjo_id')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->pjo_id ?? null,
                    'employee_number' => $item->pjo?->employee?->number ?? 0,
                    'name' => $item->pjo->name ?? null,
                    'total' => $item->total,
                    'document_created' => Carbon::parse($item->created_at)->format('Y-m-d')
                ];
            });

        $sap_user_pjo_ttt = FieldLeadership::with('pjo', 'pjo.employee')
            ->selectRaw('count(*) as total, pjo_id, created_at, company_id')
            ->whereMonth('created_at', $thisMonth)
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->where('type', 'Take Time Talk')
            ->whereIn('status', [FieldLeadershipType::Close, FieldLeadershipType::Open])
            ->groupBy('pjo_id')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->pjo?->id ?? null,
                    'employee_number' => $item->pjo?->employee?->number ?? 0,
                    'name' => $item->pjo->name ?? null,
                    'total' => $item->total,
                    'document_created' => Carbon::parse($item->created_at)->format('Y-m-d')
                ];
            });

        $sap_user_pjo_hr = FieldLeadership::with('pjo', 'pjo.employee')
            ->selectRaw('count(*) as total, pjo_id, created_at, company_id')
            ->whereMonth('created_at', $thisMonth)
            ->when(isset($request->years), function ($query) use ($request, $years) {
                return $query->whereRaw('YEAR(created_at) in (' . $years . ')');
            })
            ->when(isset($request->companies), function ($query) use ($request, $companyIds) {
                return $query->whereIn('company_id', explode(',', $companyIds));
            })
            ->where('type', 'Hazard Report')
            ->whereIn('status', [FieldLeadershipType::Close, FieldLeadershipType::Open])
            ->groupBy('pjo_id')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->pjo?->id ?? null,
                    'employee_number' => $item->pjo?->employee?->number ?? 0,
                    'name' => $item->pjo->name ?? null,
                    'total' => $item->total,
                    'document_created' => Carbon::parse($item->created_at)->format('Y-m-d')
                ];
            });


        return response()->json([
            'data' => [
                'maker' => [
                    'category' => [
                        [
                            'name' => 'Planned Task Observation',
                            'value' => $sap_user_maker_pto,
                        ],
                        [
                            'name' => 'Take Time Talk',
                            'value' => $sap_user_maker_ttt,
                        ],
                        [
                            'name' => 'Hazard Report',
                            'value' => $sap_user_maker_hr,
                        ],
                    ],
                ],
                'pja' => [
                    'category' => [
                        [
                            'name' => 'Planned Task Observation',
                            'value' => $sap_user_pja_pto,
                        ],
                        [
                            'name' => 'Take Time Talk',
                            'value' => $sap_user_pja_ttt,
                        ],
                        [
                            'name' => 'Hazard Report',
                            'value' => $sap_user_pja_hr,
                        ],
                    ],
                ],
                'pjo' => [
                    'category' => [
                        [
                            'name' => 'Planned Task Observation',
                            'value' => $sap_user_pjo_pto,
                        ],
                        [
                            'name' => 'Take Time Talk',
                            'value' => $sap_user_pjo_ttt,
                        ],
                        [
                            'name' => 'Hazard Report',
                            'value' => $sap_user_pjo_hr,
                        ],
                    ],
                ],
            ]
        ]);
    }
}
