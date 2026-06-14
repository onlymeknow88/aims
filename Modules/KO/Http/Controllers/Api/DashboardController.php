<?php

namespace Modules\KO\Http\Controllers\Api;

use App\Enums\KO\KoStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Modules\KO\Entities\KoProposal;
use Modules\KO\Entities\KoSpipCategory;

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

        $proposals = KoProposal::query()->whereRaw('YEAR(created_at) in (' . $years . ')');
        if (count($arrayMonth) > 0) {
            $proposals = $proposals->whereRaw('MONTH(created_at) in (' . $months . ')');
        }
        if (count($arrayCompanyId) > 0) {
            $proposals = $proposals->whereIn('company_id', $arrayCompanyId);
        }

        $total = $proposals->count();
        $completed = $proposals->where('status', KoStatus::Completed()->value)->count();

        $count_ytd = [
            'ytd' => $total,
            'ytd_target' => $total != 0 ? round(($completed / $total) * 100) : 0,
        ];

        //byMonth
        $byMonth = [];
        $monthNumber = 1;
        do {
            $monthName = date('M', strtotime('1-' . $monthNumber . '-' . $thisYear));
            $proposal = KoProposal::query()->whereRaw('YEAR(created_at) in (' . $years . ')')
                ->whereMonth('created_at', $monthNumber);

            if (count($arrayCompanyId) > 0) {
                $proposal = $proposal->whereIn('company_id', $arrayCompanyId);
            }

            $byMonth[$monthName] = [
                'month' => $monthNumber,
                'target' => 0, //$proposal->count(),
                'actual' => $proposal->where('status', KoStatus::Completed()->value)->count()
            ];
            $a[] = [$monthNumber, $monthName];
            $monthNumber = $monthNumber + 1;
        } while ($monthNumber <= 12);

        //filter by month
        if (count($arrayMonth) > 0) {
            $byMonth = collect($byMonth)->whereIn('month', $arrayMonth);
            $byMonth->all();
        }

        //byCategory
        $byCategory = new Collection();
        $categories = KoSpipCategory::all();
        foreach ($categories as $key => $category) {
            $proposal = KoProposal::query()->whereRaw('YEAR(created_at) in (' . $years . ')');
            if (count($arrayMonth) > 0) {
                $proposal = $proposal->whereRaw('MONTH(created_at) in (' . $months . ')');
            }
            if (count($arrayCompanyId) > 0) {
                $proposal = $proposal->whereIn('company_id', $arrayCompanyId);
            }

            $proposal =  $proposal->whereHas('koUnit', function ($query) use ($category) {
                $query->whereHas('koSpipUnit', function ($query) use ($category) {
                    $query->whereHas('koSpipType', function ($query) use ($category) {
                        $query->where('ko_spip_category_id', $category->id);
                    });
                });
            });

            $total = $proposal->count();
            $completed = $proposal->where('status', KoStatus::Completed()->value)->count();

            $byCategory->push([
                'name' => $category->name,
                'value' => $total != 0 ? round(($completed / $total) * 100) : 0
            ]);
        }

        //percentage
        $proposals = KoProposal::query()->whereRaw('YEAR(created_at) in (' . $years . ')');
        if (count($arrayMonth) > 0) {
            $proposals =  $proposals->whereRaw('MONTH(created_at) in (' . $months . ')');
        }
        if (count($arrayCompanyId) > 0) {
            $proposals =  $proposals->whereIn('company_id', $arrayCompanyId);
        }

        $total = $proposals->count();
        $completed = $proposals->where('status', KoStatus::Completed()->value)->count();
        $percentCompleted = $completed && $total ? round($completed / $total * 100, 0) : 0;

        $progress = [
            'completed' => [
                'completed' => $percentCompleted,
                'ongoing' => $percentCompleted ? 100 - $percentCompleted : 0
            ],
            'issue' => [
                'completed' => $percentCompleted ? 100 - $percentCompleted : 0,
                'ongoing' => $percentCompleted
            ]
        ];

        //
        $startOfThisMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfThisMonth = Carbon::now()->endOfMonth()->toDateString();

        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $thisMonthData = KoProposal::query()->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth]);
        if (count($arrayCompanyId) > 0) {
            $thisMonthData =  $thisMonthData->whereIn('company_id', $arrayCompanyId);
        }

        $thisMonthTotal = $thisMonthData->count();
        $thisMonthTargetCount = $thisMonthData->where('status', KoStatus::Completed()->value)->count();
        $thisMonthActual = $thisMonthTotal != 0 ? round(($thisMonthTargetCount / $thisMonthTotal) * 100) : 0;

        $lastMonthData = KoProposal::query()->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
        if (count($arrayCompanyId) > 0) {
            $lastMonthData = $lastMonthData->whereIn('company_id', $arrayCompanyId);
        }

        $lastMonthTotal = $thisMonthData->count();
        $lastMonthTargetCount = $lastMonthData->where('status', KoStatus::Completed()->value)->count();
        $lastMonthActual = $lastMonthTotal != 0 ? round(($lastMonthTargetCount / $lastMonthTotal) * 100) : 0;

        $eventThisAndLastMonth = [
            'thisMonth' => $thisMonthTotal,
            'thisMonthActual' => $thisMonthActual,
            'thisMonthArrow' => $thisMonthActual > $lastMonthActual ? 'up' : 'down',
            'lastMonth' => $lastMonthTotal,
            'lastMonthActual' => $lastMonthActual,
            'lastMonthArrow' => $lastMonthActual > $lastMonthActual ? 'down' : 'up',
        ];

        $thisYearData = KoProposal::query()->whereRaw('YEAR(created_at) in (' . $thisYear . ')');
        if (count($arrayCompanyId) > 0) {
            $thisYearData =  $thisYearData->whereIn('company_id', $arrayCompanyId);
        }

        $thisYearTotal = $thisYearData->count();
        $thisYearTargetCount = $thisMonthData->where('status', KoStatus::Completed()->value)->count();
        $thisYearActual = $thisYearTotal != 0 ? round(($thisYearTargetCount / $thisYearTotal) * 100) : 0;

        $lastYearData = KoProposal::query()->whereRaw('YEAR(created_at) in (' . $thisYear - 1 . ')');
        if (count($arrayCompanyId) > 0) {
            $lastYearData = $lastYearData->whereIn('company_id', $arrayCompanyId);
        }

        $lastYearTotal = $lastYearData->count();
        $lastYearTargetCount = $lastMonthData->where('status', KoStatus::Completed()->value)->count();
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
