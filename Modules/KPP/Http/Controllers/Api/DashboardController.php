<?php

namespace Modules\KPP\Http\Controllers\Api;

use App\Enums\KPP\ExtractionStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Modules\KPP\Entities\KppExtraction;
use Modules\KPP\Entities\KppObedience;
use Modules\KPP\Entities\KppRuleType;
use Modules\KPP\Transformers\Dashboard\DashboardResource;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
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


        //ytd
        $extractions = KppExtraction::query()->whereRaw('YEAR(kpp_extractions.created_at) in (' . $years . ')');
        if (count($arrayMonth) > 0) {
            $extractions = $extractions->whereRaw('MONTH(kpp_extractions.created_at) in (' . $months . ')');
        }
        //kpp_extractions join kpp_obediences
        $extractions = $extractions->leftJoin('kpp_obediences', 'kpp_obediences.id', '=', 'kpp_extractions.obedience_id');
        //kpp_obediences join kpp_rules
        $extractions = $extractions->leftJoin('kpp_rules', 'kpp_rules.id', '=', 'kpp_obediences.rule_id');
        //kpp_rules join rule type with filter type
        $extractions = $extractions->leftJoin('kpp_rule_types', 'kpp_rule_types.id', '=', 'kpp_rules.rule_type_id');

        if (count($arrayCompanyId) > 0) {
            $extractions = $extractions->whereIn('kpp_obediences.company_id', $arrayCompanyId);
        }

        $total = $extractions->count();
        $complied = $extractions->where('kpp_extractions.status', ExtractionStatus::Complied()->value)->count();

        $count_ytd = [
            'ytd' => $total,
            'ytd_target' => $total != 0 ? round(($complied / $total) * 100) : 0,
        ];

        $percentComplied = $complied && $total ? round(($complied / $total) * 100) : 0;

        $progress = [
            'complied' => [
                'target' => $percentComplied,
                'actual' => $percentComplied ? 100 - $percentComplied : 0
            ],
            'notcomply' => [
                'target' => $percentComplied ? 100 - $percentComplied : 0,
                'actual' =>  $percentComplied
            ]
        ];

        //byMonth
        $byMonth = [];
        $month_list = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];

        foreach ($month_list as $monthNumber => $monthName) {
            $data = KppExtraction::query()->whereRaw('YEAR(kpp_extractions.created_at) in (' . $years . ')')
                ->whereMonth('kpp_extractions.created_at', $monthNumber);

            //kpp_extractions join kpp_obediences
            $extractions = $extractions->leftJoin('kpp_obediences', 'kpp_obediences.id', '=', 'kpp_extractions.obedience_id');
            //kpp_obediences join kpp_rules
            $extractions = $extractions->leftJoin('kpp_rules', 'kpp_rules.id', '=', 'kpp_obediences.rule_id');
            //kpp_rules join rule type with filter type
            $extractions = $extractions->leftJoin('kpp_rule_types', 'kpp_rule_types.id', '=', 'kpp_rules.rule_type_id');

            if (count($arrayCompanyId) > 0) {
                $extractions = $extractions->whereIn('kpp_obediences.company_id', $arrayCompanyId);
            }

            $byMonth[$monthName] = [
                'month' => $monthNumber,
                'target' => 0, //$data->count(),
                'actual' => $data->where('status', ExtractionStatus::Complied()->value)->count()
            ];
        }

        //filter by month
        if (count($arrayMonth) > 0) {
            $byMonth = collect($byMonth)->whereIn('month', $arrayMonth);
            $byMonth->all();
        }

        //byCategory
        $byCategory = [];
        $types = KppRuleType::all();
        foreach ($types as $key => $type) {
            $extractions = KppExtraction::whereRaw('YEAR(kpp_extractions.created_at) in (' . $years . ')');
            if (count($arrayMonth) > 0) {
                $extractions = $extractions->whereRaw('MONTH(kpp_extractions.created_at) in (' . $months . ')');
            }

            //kpp_extractions join kpp_obediences
            $extractions = $extractions->leftJoin('kpp_obediences', 'kpp_obediences.id', '=', 'kpp_extractions.obedience_id');
            //kpp_obediences join kpp_rules
            $extractions = $extractions->leftJoin('kpp_rules', 'kpp_rules.id', '=', 'kpp_obediences.rule_id');
            //kpp_rules join rule type with filter type
            $extractions = $extractions->leftJoin('kpp_rule_types', 'kpp_rule_types.id', '=', 'kpp_rules.rule_type_id');

            $extractions = $extractions->where('kpp_rule_types.name', '=', $type->name);
            if (count($arrayCompanyId) > 0) {
                $extractions = $extractions->whereIn('kpp_obediences.company_id', $arrayCompanyId);
            }

            $total = $extractions->count();
            $complied = $extractions->where('kpp_extractions.status', ExtractionStatus::Complied()->value)->count();

            $byCategory[] = [
                'name' => $type->name,
                'value' => $complied && $total ?  round($complied / $total * 100, 0) : 0,
                //'data' => $extractions->get(),
            ];
        }


        $thisMonthData = KppExtraction::query()
            ->whereRaw('YEAR(created_at) in (' . $thisYear . ')')
            ->whereRaw('MONTH(created_at) in (' . $thisMonth . ')');

        if (count($arrayCompanyId) > 0) {
            $thisMonthData = $thisMonthData->whereHas('obedience', function ($query) use ($type, $request, $arrayCompanyId) {
                $query->when($request->has('companies'), function ($query) use ($request, $arrayCompanyId) {
                    return $query->whereIn('company_id', $arrayCompanyId);
                });
            });
        }

        $thisMonthTotal = $thisMonthData->count();
        $thisMonthTargetCount = $thisMonthData->where('status', ExtractionStatus::Complied()->value)->count();
        $thisMonthActual = $thisMonthTotal != 0 ? round(($thisMonthTargetCount / $thisMonthTotal) * 100) : 0;
        $lastMonthTotal = $thisMonthData->count();


        $lastMonthData = KppExtraction::query()->whereRaw('YEAR(created_at) in (' . $lastMonthYear . ')')
            ->whereRaw('MONTH(created_at) in (' . $lastMonth . ')');
        if (count($arrayCompanyId) > 0) {
            $lastMonthData = $lastMonthData->whereHas('obedience', function ($query) use ($type, $request, $arrayCompanyId) {
                $query->when($request->has('companies'), function ($query) use ($request, $arrayCompanyId) {
                    return $query->whereIn('company_id', $arrayCompanyId);
                });
            });
        }

        $lastMonthTargetCount = $lastMonthData->where('status', ExtractionStatus::Complied()->value)->count();
        $lastMonthActual = $lastMonthTotal != 0 ? round(($lastMonthTargetCount / $lastMonthTotal) * 100) : 0;

        $eventThisAndLastMonth = [
            'thisMonth' => $thisMonthTotal,
            'thisMonthActual' => $thisMonthActual,
            'thisMonthArrow' => $thisMonthActual > $lastMonthActual ? 'up' : 'down',
            'lastMonth' => $lastMonthTotal,
            'lastMonthActual' => $lastMonthActual,
            'lastMonthArrow' => $lastMonthActual > $lastMonthActual ? 'down' : 'up',
        ];

        $thisYearData = KppExtraction::query()->whereRaw('YEAR(created_at) in (' . $thisYear . ')');
        if (count($arrayCompanyId) > 0) {
            $thisYearData = $thisYearData->whereHas('obedience', function ($query) use ($type, $request, $arrayCompanyId) {
                $query->when($request->has('companies'), function ($query) use ($request, $arrayCompanyId) {
                    return $query->whereIn('company_id', $arrayCompanyId);
                });
            });
        }

        $thisYearTotal = $thisYearData->count();
        $thisYearTargetCount = $thisMonthData->where('status', ExtractionStatus::Complied()->value)->count();
        $thisYearActual = $thisYearTotal != 0 ? round(($thisYearTargetCount / $thisYearTotal) * 100) : 0;

        $lastYearData = KppExtraction::query()->whereRaw('YEAR(created_at) in (' . $lastYear . ')');
        if (count($arrayCompanyId) > 0) {
            $lastYearData = $lastYearData->whereHas('obedience', function ($query) use ($type, $request, $arrayCompanyId) {
                $query->when($request->has('companies'), function ($query) use ($request, $arrayCompanyId) {
                    return $query->whereIn('company_id', $arrayCompanyId);
                });
            });
        }

        $lastYearTotal = $lastYearData->count();
        $lastYearTargetCount = $lastMonthData->where('status', ExtractionStatus::Complied()->value)->count();
        $lastYearActual = $lastYearTotal != 0 ? round(($lastYearTargetCount / $lastYearTotal) * 100) : 0;

        $eventThisAndLastYear = [
            'thisYear' => $thisYearTotal,
            'thisYearActual' => $thisYearActual,
            'thisYearArrow' => $thisYearTargetCount > $lastYearActual ? 'up' : 'down',
            'lastYear' => $lastYearTotal,
            'lastYearActual' => $lastYearActual,
            'lastYearArrow' => $thisYearTargetCount > $lastYearActual ? 'down' : 'up',
        ];

        return response()->json([
            'ytd' => $count_ytd,
            'byMonth' => $byMonth,
            'byCategory' => $byCategory,
            'progress' => $progress,
            'thisMonthEvent' => $eventThisAndLastMonth,
            'lastYearEvent' => $eventThisAndLastYear,
        ]);
    }
}
