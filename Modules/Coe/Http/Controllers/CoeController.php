<?php

namespace Modules\Coe\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Support\Renderable;
// use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// use Modules\Coe\Transformers\EventResource;
use Modules\Coe\Entities\Event;

class CoeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function getAllIn(Request $r)
    {
        // YTD
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');
        $month = ($r->months) ? $r->months : null;
        $arrayMonth = $month ? explode(",", $month) : [];

        $selectedYear = ($r->years) ? $r->years : $thisYear;
        $arrayYear = explode(",", $selectedYear);

        $companyId = ($r->companies) ? $r->companies : null;
        $arrayCompanyId = $companyId ? explode(",", $companyId) : [];

        $thisYearCount = Event::whereRaw('YEAR(start_date) in (' . $thisYear . ')')->count();
        $thisYearDoneCount = Event::whereRaw('YEAR(start_date) in (' . $thisYear . ')')
            ->where('status', 'DONE')
            ->count();
        $thisYearDonePercent =  $thisYearDoneCount && $thisYearCount ?  round($thisYearDoneCount / $thisYearCount * 100, 0) : 0;

        $lastYearCount = Event::whereRaw('YEAR(start_date) in (' . $thisYear - 1 . ')')->count();

        $event = Event::whereNotNull('id');
        if (count($arrayCompanyId) > 0) {
            $event = $event->whereHas('section', function ($q) use ($arrayCompanyId) {
                $q->whereHas('department', function ($q) use ($arrayCompanyId) {
                    $q->whereHas('company', function ($q) use ($arrayCompanyId) {
                        $q->whereIn('id', $arrayCompanyId);
                    });
                });
            });
        }

        $count_annual = $event->count();

        $eventPast = $event->whereMonth('start_date', ($thisMonth - 1));
        $eventCur = $event->whereMonth('start_date', $thisMonth);

        $thisMonthDone = $eventCur->where('status', 'DONE')->count();
        $thisMonthTarget = $thisYear;
        $pastMonthDone = $eventPast->where('status', 'DONE')->count();
        $pastMonthTarget = $thisYear;

        $soon = Event::orderBy('start_date', 'DESC')->take(7)->get()->toArray();
        $eventAll = Event::all(); // Jangan dihapus
        // END YTD

        $target = $event->count();
        $done = $event->where('status', 'DONE')->count();

        // $done = Event::where('status', 'DONE')->count();
        // $target = Event::where('status', 'PENDING')->count();

        $category = ['URGENT', 'IMPORTANT', 'MEDIUM', 'LOW'];
        $categoryAll = [];
        foreach ($category as $list) {
            $var = strtolower($list);
            $event = Event::whereRaw('YEAR(start_date) in (' . $selectedYear . ')');
            
            if (count($arrayMonth) > 0) {
                $event = $event->whereRaw('MONTH(start_date) in (' . $month . ')');
            }

            if (count($arrayCompanyId) > 0) {
                $event = $event->whereHas('section', function ($q) use ($arrayCompanyId) {
                    $q->whereHas('department', function ($q) use ($arrayCompanyId) {
                        $q->whereHas('company', function ($q) use ($arrayCompanyId) {
                            $q->whereIn('id', $arrayCompanyId);
                        });
                    });
                });
            }

            $event = $event->whereHas('category', function ($q) use ($list) {
                $q->where('name', 'like', '%' . $list . '%');
            })->count();

            ${$var} =  $event;

            $categoryAll[] = [
                'name' => ucfirst(strtolower($list)),
                'value' => $event
            ];
        }

        $event = Event::whereNotNull('id');
        if (count($arrayCompanyId) > 0) {
            $event = $event->whereHas('section', function ($q) use ($arrayCompanyId) {
                $q->whereHas('department', function ($q) use ($arrayCompanyId) {
                    $q->whereHas('company', function ($q) use ($arrayCompanyId) {
                        $q->whereIn('id', $arrayCompanyId);
                    });
                });
            });
        }

        $event = $event->whereRaw('YEAR(start_date) in (' . $selectedYear . ')');
        $done = $event->where('status', 'DONE')->count();
        $target = $event->count();
        $done_past = $event->where('status', 'DONE')->count();
        $target_past = $event->count();

        $dataMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $m = $thisYear . '-' . $i . '-1';
            $monthName = date('M', strtotime($m));

            $event = Event::whereNotNull('id');
            if (count($arrayCompanyId) > 0) {
                $event = $event->whereHas('section', function ($q) use ($arrayCompanyId) {
                    $q->whereHas('department', function ($q) use ($arrayCompanyId) {
                        $q->whereHas('company', function ($q) use ($arrayCompanyId) {
                            $q->whereIn('id', $arrayCompanyId);
                        });
                    });
                });
            }

            $event = $event->whereRaw('YEAR(start_date) in (' . $selectedYear . ')')
                ->whereMonth('start_date', $i);

            $event =  $event->selectRaw("
                    coe_events.*,
                    DATE_FORMAT(start_date, '%M %d %Y' ) as date
            ");

            $dataMonth[$monthName] = [
                'year' => $selectedYear,
                'month' => $i,
                'date' => $m,
                'target' => 0,
                'actual' => $event->count(),
                'data' => $event->get()
            ];
        }

        //filter by month
        if (count($arrayMonth) > 0) {
            $dataMonth = collect($dataMonth)->whereIn('month', $arrayMonth);
            $dataMonth->all();
        }

        return response()->json([
            'count_annual' => $count_annual,

            'count_ytd' => [
                'ytd' => $count_annual, //$target ? (($done / $target) * 100) : 0,
                'ytd_target' => $target_past ? (($done_past / $target_past) * 100) : 0,
            ],

            'count_annual_completion' => [
                'complete' => [
                    'target' => $thisYearDonePercent ? 100 - $thisYearDonePercent : 0,
                    'actual' => $thisYearDonePercent ? 100 - (100 - $thisYearDonePercent) : 0,
                ],
                'ongoing' => [
                    'target' => $thisYearDonePercent ? 100 - (100 - $thisYearDonePercent) : 0,
                    'actual' => $thisYearDonePercent ? 100 - $thisYearDonePercent : 0,
                ]
            ],

            'count_by_category' => $categoryAll,

            'count_monthly' => [
                'this_month_done' => $thisMonthDone,
                'this_month_target' => $thisMonthTarget,
                'this_month_mark' => $thisMonthDone > $pastMonthDone ? 'up' : 'down',
                'this_month_percent' => $thisMonthDone && $thisYearCount ?  round($thisMonthDone / $thisYearCount * 100, 0) : 0,

                'past_month_done' => $pastMonthDone,
                'past_month_target' => $pastMonthTarget,
                'past_month_mark' => $thisMonthDone > $pastMonthDone ? 'down' : 'up',
                'past_month_percent' => $pastMonthDone && $thisYearCount ?  round($pastMonthDone / $thisYearCount * 100, 0) : 0,
            ],

            'count_yearly' => [
                'this_year_done' => $done,
                'this_year_target' => $target,
                'this_year_mark' => $done > $done_past ? 'up' : 'down',
                'this_year_percent' =>  $done && $thisYearCount ?  round($done / $thisYearCount * 100, 0) : 0,

                'past_year_done' => $done_past,
                'past_year_target' => $target_past,
                'past_year_mark' => $done > $done_past ? 'down' : 'up',
                'past_year_percent' =>  $done_past && $lastYearCount ?  round($done_past / $lastYearCount * 100, 0) : 0
            ],

            'progress' => ['actual' => 0, 'target' => 0],
            'completion_by_month' => $dataMonth,

            'soon_event' => $soon,
        ], 200);
    }

    public function getYtd(Request $r)
    {
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $month = ($r->month) ? $r->month : $thisMonth;
        $selectedYear = ($r->year) ? $r->year : $thisYear;
        $companyId = ($r->company) ? $r->company : null;

        if (strpos($companyId, ',')) {
            $event = Event::whereHas('section', function ($q) use ($companyId) {
                $q->whereHas('department', function ($q) use ($companyId) {
                    $q->whereHas('company', function ($q) use ($companyId) {
                        $ids = explode(',', $companyId);
                        $q->whereIn('id', $ids);
                    });
                });
            });
        } else {
            if ($companyId) {
                $event = Event::whereHas('section', function ($q) use ($companyId) {
                    $q->whereHas('department', function ($q) use ($companyId) {
                        $q->whereHas('company', function ($q) use ($companyId) {
                            $q->where('id', $companyId);
                        });
                    });
                });
            } else {
                $event = Event::select();
            }
        }

        if (strpos($month, ',')) {
            $event->whereRaw('MONTH(start_date) in (' . $month . ')');
        } else {
            // Sekarang default this month
            $event->whereMonth('start_date', $month);
        }

        if (strpos($selectedYear, ',')) {
            $event->whereRaw('YEAR(start_date) in (' . $selectedYear . ')');
        } else {
            $event->whereYear('start_date', $selectedYear);
        }

        $eventAll = Event::all();

        return response()->json([
            'count_ytd' => $event->count(),
            'count_target' => $eventAll->count(),
        ], 200);
    }

    public function getAnnualCount()
    {
        $count = Event::count();

        return response()->json([
            'count_annual' => $count,
        ], 200);
    }

    public function getAnnualCompletion()
    {
        $done = Event::where('status', 'DONE')->count();
        $target = Event::count();

        return response()->json([
            'count_done' => $done,
            'count_target' => $target,
        ], 200);
    }

    public function getAnnualOnGoing()
    {
        $done = Event::where('status', 'DONE')->count();
        $target = Event::where('status', 'PENDING')->count();

        return response()->json([
            'count_done' => $done,
            'count_target' => $target,
        ], 200);
    }

    public function getBycategory()
    {
        $urgent = Event::whereHas('category', function ($q) {
            $q->where('name', 'URGENT');
        })->count();

        $important = Event::whereHas('category', function ($q) {
            $q->where('name', 'IMPORTANT');
        })->count();

        $medium = Event::whereHas('category', function ($q) {
            $q->where('name', 'MEDIUM');
        })->count();

        $low = Event::whereHas('category', function ($q) {
            $q->where('name', 'LOW');
        })->count();

        return response()->json([
            'count_urgent' => $urgent,
            'count_important' => $important,
            'count_medium' => $medium,
            'count_low' => $low,
        ], 200);
    }

    public function getThisMonth()
    {
        $done = Event::whereMonth('start_date', '7')
            ->where('status', 'DONE')->count();
        $target = Event::count();

        $done_past = Event::whereMonth('start_date', '7')
            ->where('status', 'DONE')->count();
        $target_past = Event::count();

        return response()->json([
            'count_done_this_month' => $done,
            'count_target_this_month' => $target,
            'count_done_past_month' => $done_past,
            'count_target_past_month' => $target_past,
        ], 200);
    }

    // MOBILE
    public function getMonthlyListsCount(Request $r)
    {
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $month = ($r->month) ? $r->month : $thisMonth;
        $year = ($r->year) ? $r->year : $thisYear;

        $event = Event::select(['start_date as date', DB::raw('count(*) AS count')])->groupBy('start_date');

        if (strpos($month, ',')) {
            $event->whereRaw('MONTH(start_date) in (' . $month . ')');
        } else {
            $event->whereMonth('start_date', $month);
        }

        if (strpos($year, ',')) {
            $event->whereRaw('YEAR(start_date) in (' . $year . ')');
        } else {
            $event->whereYear('start_date', $year);
        }

        return response()->json($event->get(), 200);
    }

    public function getEventDayLists(Request $r)
    {
        $thisDay = Carbon::now()->format('d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $day = ($r->day) ? $r->day : $thisDay;
        $month = ($r->month) ? $r->month : $thisMonth;
        $year = ($r->year) ? $r->year : $thisYear;

        $event = Event::select([
            'id', 'title', 'frequency', 'start_date', 'end_date',
        ]);

        if (strpos($day, ',')) {
            $event->whereRaw('DAY(start_date) in (' . $day . ')');
        } else {
            $event->whereDay('start_date', $day);
        }

        if (strpos($month, ',')) {
            $event->whereRaw('MONTH(start_date) in (' . $month . ')');
        } else {
            $event->whereMonth('start_date', $month);
        }

        if (strpos($year, ',')) {
            $event->whereRaw('YEAR(start_date) in (' . $year . ')');
        } else {
            $event->whereYear('start_date', $year);
        }

        return response()->json($event->get(), 200);
    }

    public function getEventDetails($id)
    {
        $event = Event::select([
            'id', 'title', 'frequency', 'start_date', 'end_date', 'description', 'invited_emails', 'repeat', 'status',
        ])->find($id);

        return response()->json($event, 200);
    }
    // MOBILE

    public function getThisYear()
    {
        $done = Event::whereYear('start_date', '2023')
            ->where('status', 'DONE')->count();
        $target = Event::count();

        $done_past = Event::whereYear('start_date', '2023')
            ->where('status', 'DONE')->count();
        $target_past = Event::count();

        return response()->json([
            'count_done_this_year' => $done,
            'count_target_this_year' => $target,
            'count_done_past_year' => $done_past,
            'count_target_past_year' => $target_past,
        ], 200);
    }

    public function getCompletionByMonth()
    {
        $jan = Event::whereYear('start_date', '2023')
            ->where('status', 'DONE')->count();
        $feb = Event::count();

        $mar = Event::whereYear('start_date', '2023')
            ->where('status', 'DONE')->count();
        $apr = Event::count();
        $may = Event::count();
        $jun = Event::count();
        $jul = Event::count();
        $aug = Event::count();
        $sep = Event::count();
        $oct = Event::count();
        $nov = Event::count();
        $dec = Event::count();

        return response()->json([
            'jan' => ['target' => $jan, 'actual' => $jan],
            'feb' => ['target' => $feb, 'actual' => $feb],
            'mar' => ['target' => $mar, 'actual' => $mar],
            'apr' => ['target' => $apr, 'actual' => $apr],
            'may' => ['target' => $may, 'actual' => $may],
            'jun' => ['target' => $jun, 'actual' => $jun],
            'jul' => ['target' => $jul, 'actual' => $jul],
            'aug' => ['target' => $aug, 'actual' => $aug],
            'sep' => ['target' => $sep, 'actual' => $sep],
            'oct' => ['target' => $oct, 'actual' => $oct],
            'nov' => ['target' => $nov, 'actual' => $nov],
            'dec' => ['target' => $dec, 'actual' => $dec],
        ], 200);
    }

    public function index()
    {
        return view('coe::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('coe::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('coe::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('coe::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
