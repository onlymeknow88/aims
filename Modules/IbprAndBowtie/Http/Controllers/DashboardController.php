<?php

namespace Modules\IbprAndBowtie\Http\Controllers;

use App\Enums\KO\KoStatus;
use App\Models\IbprBowty\Iadl;
use App\Models\IbprBowty\Ibpr;
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

        $months = ($request->months) ? $request->months : null;
        $arrayMonth = $months ? explode(",", $months) : [];

        $years = ($request->years) ? $request->years : $thisYear;
        $arrayYear = explode(",", $years);

        $companyIds = ($request->companies) ? $request->companies : null;
        $arrayCompanyId = $companyIds ? explode(",", $companyIds) : [];

        $proposals = Ibpr::query()->whereRaw('YEAR(created_at) in (' . $years . ')');
        if (count($arrayMonth) > 0) {
            $proposals = $proposals->whereRaw('MONTH(created_at) in (' . $months . ')');
        }
        if (count($arrayCompanyId) > 0) {
            $proposals = $proposals->whereIn('ccow_id', $arrayCompanyId);
        }

        $total = $proposals->count();
        $completed = $proposals->where('status', 'Disetujui')->count();

        $proposals_iadl = Iadl::query()->whereRaw('YEAR(created_at) in (' . $years . ')');
        if (count($arrayMonth) > 0) {
            $proposals_iadl =  $proposals_iadl->whereRaw('MONTH(created_at) in (' . $months . ')');
        }
        if (count($arrayCompanyId) > 0) {
            $proposals_iadl = $proposals_iadl->whereIn('ccow_id', $arrayCompanyId);
        }

        $total_iadl = $proposals_iadl->count();
        $completed_iadl = $proposals_iadl->where('status', 'Disetujui')->count();

        $count_ytd = [
            'ytd' => $total_iadl,
            'ytd_target' => $total_iadl != 0 ? round((($completed + $completed_iadl) / $total_iadl) * 100) : 0,
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
            $proposal = Ibpr::query()->whereRaw('YEAR(created_at) in (' . $years . ')')
                ->whereMonth('created_at', $monthNumber);

            if (count($arrayCompanyId) > 0) {
                $proposal = $proposal->whereIn('ccow_id', $arrayCompanyId);
            }

            $proposals_iadl = Iadl::query()->whereRaw('YEAR(created_at) in (' . $years . ')')
                ->whereMonth('created_at', $monthNumber);

            if (count($arrayCompanyId) > 0) {
                $proposals_iadl =  $proposals_iadl->whereIn('ccow_id', $arrayCompanyId);
            }

            $byMonth[$monthName] = [
                'month' => $monthNumber,
                'target' => 0, // $proposal->count() + $proposals_iadl->count(),
                'actual' => $proposal->where('status', 'Disetujui')->count() + $proposals_iadl->where('status', 'Disetujui')->count()
            ];
        }

        //filter by month
        if (count($arrayMonth) > 0) {
            $byMonth = collect($byMonth)->whereIn('month', $arrayMonth);
            $byMonth->all();
        }

        //byCategory
        $byCategory = [
            [
                'name' => 'IBPR',
                'value' => $total != 0 ? round(($completed / $total) * 100) : 0
            ],
            [
                'name' => 'IADL',
                'value' => $total != 0 ? round(($completed / $total) * 100) : 0
            ]
        ];

        //percentage
        $proposals = Ibpr::query()->whereRaw('YEAR(created_at) in (' . $years . ')');
        if (count($arrayMonth) > 0) {
            $proposal = $proposal->whereRaw('MONTH(created_at) in (' . $months . ')');
        }
        if (count($arrayCompanyId) > 0) {
            $proposal = $proposal->whereIn('ccow_id', $arrayCompanyId);
        }

        $total = $proposals->count();
        $completed = $proposals->where('status', 'Disetujui')->count();
        $notComplete = $proposals->whereNot('status', 'Disetujui')->count();

        $proposals_iadl = Iadl::query()->whereRaw('YEAR(created_at) in (' . $years . ')');
        if (count($arrayMonth) > 0) {
            $proposals_iadl =  $proposals_iadl->whereRaw('MONTH(created_at) in (' . $months . ')');
        }
        if (count($arrayCompanyId) > 0) {
            $proposals_iadl =  $proposals_iadl->whereIn('ccow_id', $arrayCompanyId);
        }
        $total_iadl = $proposals_iadl->count();
        $completed_iadl = $proposals_iadl->where('status', 'Disetujui')->count();
        $notComplete_iadl = $proposals_iadl->whereNot('status', 'Disetujui')->count();

        $percentUpdate = $total + $total_iadl != 0 ? round((($completed + $completed_iadl) / ($total + $total_iadl)) * 100) : 0;

        $progress = [
            'update' => [
                'completed' => $percentUpdate,
                'ongoing' => $percentUpdate ? 100 - $percentUpdate : 0
            ],
            'obsolute' => [
                'completed' => $percentUpdate ? 100 - $percentUpdate : 0,
                'ongoing' => $percentUpdate
            ]
        ];

        //
        $startOfThisMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfThisMonth = Carbon::now()->endOfMonth()->toDateString();

        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $thisMonthData = Ibpr::query()->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth]);
        $thisMonthData = $thisMonthData->whereIn('ccow_id', $arrayCompanyId);

        $thisMonthTotal = $thisMonthData->count();
        $thisMonthTargetCount = $thisMonthData->where('status', 'Disetujui')->count();

        $thisMonthData_iadl = Iadl::query()->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth]);
        if (count($arrayCompanyId) > 0) {
            $thisMonthData_iadl = $thisMonthData_iadl->whereIn('ccow_id', $arrayCompanyId);
        }

        $thisMonthTotal_iadl = $thisMonthData_iadl->count();
        $thisMonthTargetCount_iadl = $thisMonthData_iadl->where('status', 'Disetujui')->count();

        $thisMonthActual = ($thisMonthTotal + $thisMonthTotal_iadl) != 0 ? round((($thisMonthTargetCount + $thisMonthTargetCount_iadl) / ($thisMonthTotal + $thisMonthTotal_iadl)) * 100) : 0;

        $lastMonthData = Ibpr::query()->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
        if (count($arrayCompanyId) > 0) {
            $lastMonthData = $lastMonthData->whereIn('ccow_id', $arrayCompanyId);
        }

        $lastMonthTotal = $thisMonthData->count();
        $lastMonthTargetCount = $lastMonthData->where('status', 'Disetujui')->count();

        $lastMonthData_iadl = Iadl::query()->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
        if (count($arrayCompanyId) > 0) {
            $lastMonthData_iadl = $lastMonthData_iadl->whereIn('ccow_id', $arrayCompanyId);
        }

        $lastMonthTotal_iadl = $thisMonthData->count();
        $lastMonthTargetCount_iadl = $lastMonthData_iadl->where('status', 'Disetujui')->count();

        $lastMonthActual = $lastMonthTotal + $lastMonthTotal_iadl != 0 ? round((($lastMonthTargetCount + $lastMonthTargetCount_iadl) / ($lastMonthTotal + $lastMonthTotal_iadl)) * 100) : 0;

        $eventThisAndLastMonth = [
            'thisMonth' => $thisMonthTotal + $thisMonthTotal_iadl,
            'thisMonthActual' => $thisMonthActual,
            'thisMonthArrow' => $thisMonthActual > $lastMonthActual ? 'up' : 'down',
            'lastMonth' => $lastMonthTotal + $lastMonthTotal_iadl,
            'lastMonthActual' => $lastMonthActual,
            'lastMonthArrow' => $lastMonthActual > $lastMonthActual ? 'down' : 'up',
        ];

        $thisYearData = Ibpr::query()->whereRaw('YEAR(created_at) in (' . $thisYear . ')');
        if (count($arrayCompanyId) > 0) {
            $thisYearData = $thisYearData->whereIn('ccow_id', $arrayCompanyId);
        }

        $thisYearTotal = $thisYearData->count();
        $thisYearTargetCount = $thisYearData->where('status', 'Disetujui')->count();

        $thisYearData_iadl = Iadl::query()->whereRaw('YEAR(created_at) in (' . $thisYear . ')');
        if (count($arrayCompanyId) > 0) {
            $thisYearData_iadl =  $thisYearData_iadl->whereIn('ccow_id', $arrayCompanyId);
        }

        $thisYearTotal_iadl = $thisYearData_iadl->count();
        $thisYearTargetCount_iadl = $thisYearData_iadl->where('status', 'Disetujui')->count();

        $thisYearActual = ($thisYearTotal + $thisYearTotal_iadl) != 0 ? round((($thisYearTargetCount + $thisYearTargetCount_iadl) / ($thisYearTotal + $thisYearTotal_iadl)) * 100) : 0;

        $lastYearData = Ibpr::query()->whereRaw('YEAR(created_at) in (' . $thisYear - 1 . ')');
        if (count($arrayCompanyId) > 0) {
            $lastYearData = $lastYearData->whereIn('ccow_id', $arrayCompanyId);
        }

        $lastYearTotal = $lastYearData->count();
        $lastYearTargetCount = $lastMonthData->where('status', 'Disetujui')->count();

        $lastYearData = Iadl::query()->whereRaw('YEAR(created_at) in (' . $thisYear - 1 . ')');
        if (count($arrayCompanyId) > 0) {
            $lastYearData = $lastYearData->whereIn('ccow_id', $arrayCompanyId);
        }

        $lastYearTotal_iadl = $lastYearData->count();
        $lastYearTargetCount_iadl = $lastMonthData_iadl->where('status', 'Disetujui')->count();

        $lastYearActual = ($lastYearTotal + $lastYearTotal_iadl) != 0 ? round(($lastYearTargetCount / ($lastYearTotal + $lastYearTotal_iadl)) * 100) : 0;

        $eventThisAndLastYear = [
            'thisYear' => ($thisYearTotal + $thisYearTotal_iadl),
            'thisYearActual' => $thisYearActual,
            'thisYearArrow' => $thisYearTargetCount > $lastYearActual ? 'up' : 'down',
            'lastYear' => ($lastYearTotal + $lastYearTotal_iadl),
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
