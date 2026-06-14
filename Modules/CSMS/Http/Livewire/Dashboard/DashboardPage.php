<?php

namespace Modules\CSMS\Http\Livewire\Dashboard;

use App\Enums\CSMS\CsmsStatus;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Modules\CSMS\Entities\Bidding;
use Modules\CSMS\Entities\CsmsChecklist;
use Modules\CSMS\Entities\CsmsPjo;
use App\Enums\CSMS\RiskCategory;

class DashboardPage extends Component
{
    public $dataCsms = [];
    public $months;
    public $years;
    public $companies;


    public function mount()
    {
        //filter
        $thisYear = date('Y');
        $lastYear = $thisYear - 1;

        $thisMonth = date('m');
        $lastMonth = Carbon::now()->subMonth(1)->format('m');
        $lastMonthYear = Carbon::now()->subMonth(1)->format('Y');

        $month = ($this->months) ? $this->months : null;
        $arrayMonth = $month ? explode(",", $month) : [];

        $year = ($this->years) ? $this->years : $thisYear;
        $arrayYear = explode(",", $year);

        $companyId = ($this->companies) ? $this->companies : null;
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

        // Graph Donut
        $valid =  Bidding::whereRaw('YEAR(created_at) in (' . $year . ')')
            ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
            ->where('status', CsmsStatus::Approved) //valid = Approved
            ->count();


        $expires =  Bidding::whereRaw('YEAR(created_at) in (' . $year . ')')
            ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal, CsmsStatus::Inactive])
            ->where('status', CsmsStatus::Inactive) //valid = Inactive
            ->count();

        $biddingAll = $valid + $expires;
        $valid_percent = $valid && $biddingAll ? round(($valid / $biddingAll * 100), 0) : 0;
        $expires_percent = $expires && $biddingAll ? round(($expires / $biddingAll * 100), 0) : 0;

        $progress = [
            'pra_kualifikasi_valid' => [
                'name' => '',
                'target' => $valid_percent ? 100 - $valid_percent : 0,
                'actual' => $valid_percent
            ],
        ];

        // Graph Bar 1
        $evaluatedPJO = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));

                $pjo_evaluated = CsmsPjo::whereYear('created_at', $yearList)
                    ->where('status', CsmsStatus::OnReviewKTT)
                    ->where('requested', CsmsStatus::RequestedKTT)
                    ->whereMonth('created_at', $i)
                    ->count();

                $pjo_not_evaluated = CsmsPjo::whereYear('created_at', $yearList)
                    ->where('status', CsmsStatus::OnReviewEvaluator)
                    ->where('requested', CsmsStatus::RequestedEvaluator)
                    ->whereMonth('created_at', $i)
                    ->count();

                $evaluatedPJO[] = [
                    'month' => $month_name,
                    'label' => 'Evaluated',
                    'label2' => 'Not Evaluated',
                    'count' => $pjo_evaluated,
                    'count2' => $pjo_not_evaluated
                ];
                $i++;
            } while ($i <= 12);
        }
        //filter by month
        if (count($arrayMonth) > 0) {
            $evaluatedPJO = collect($evaluatedPJO)->whereIn('month', $arrayMonth);
            $evaluatedPJO->all();
        }

        // Graph Bar 2
        $approvedKTT = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));

                $ktt_approved = CsmsPjo::whereYear('created_at', $yearList)
                    ->where('status', CsmsStatus::Approved)
                    ->where('requested', CsmsStatus::Approved)
                    ->whereMonth('created_at', $i)
                    ->count();

                $ktt_not_approved = CsmsPjo::whereYear('created_at', $yearList)
                    ->where('status', CsmsStatus::OnReviewKTT)
                    ->where('requested', CsmsStatus::RequestedKTT)
                    ->whereMonth('created_at', $i)
                    ->count();

                $approvedKTT[] = [
                    'month' => $month_name,
                    'label' => 'Approved',
                    'label2' => 'Not Approved',
                    'count' => $ktt_approved,
                    'count2' => $ktt_not_approved
                ];
                $i++;
            } while ($i <= 12);
        }
        //filter by month
        if (count($arrayMonth) > 0) {
            $approvedKTT = collect($approvedKTT)->whereIn('month', $arrayMonth);
            $approvedKTT->all();
        }

        // Graph Bar 3
        $postBidding = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));

                $post_bidding_approved = Bidding::whereYear('created_at', $yearList)
                    ->where('criteria', CsmsStatus::PostBidding)
                    ->where('status', CsmsStatus::Approved)
                    ->where('requested', CsmsStatus::Approved)
                    ->whereMonth('created_at', $i)
                    ->count();

                $post_bidding_ongoing = Bidding::whereYear('created_at', $yearList)
                    ->where('criteria', CsmsStatus::PostBidding)
                    ->whereIn('requested', [CsmsStatus::RequestedOHS, CsmsStatus::RequestedDHOHS, CsmsStatus::RequestedEvaluator])
                    ->whereMonth('created_at', $i)
                    ->count();

                $postBidding[] = [
                    'month' => $month_name,
                    'label' => 'Approved',
                    'label2' => 'Not Approved',
                    'count' => $post_bidding_approved,
                    'count2' => $post_bidding_ongoing
                ];
                $i++;
            } while ($i <= 12);
        }
        //filter by month
        if (count($arrayMonth) > 0) {
            $postBidding = collect($postBidding)->whereIn('month', $arrayMonth);
            $postBidding->all();
        }

        // Graph Bar 4
        $renewal = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));

                $renewal_approved = Bidding::whereYear('created_at', $yearList)
                    ->where('criteria', CsmsStatus::Renewal)
                    ->where('status', CsmsStatus::Approved)
                    ->where('requested', CsmsStatus::Approved)
                    ->whereMonth('created_at', $i)
                    ->count();

                $renewal_ongoing = Bidding::whereYear('created_at', $yearList)
                    ->where('criteria', CsmsStatus::Renewal)
                    ->whereIn('requested', [CsmsStatus::RequestedOHS, CsmsStatus::RequestedDHOHS, CsmsStatus::RequestedEvaluator])
                    ->whereMonth('created_at', $i)
                    ->count();

                $renewal[] = [
                    'month' => $month_name,
                    'label' => 'Approved',
                    'label2' => 'Not Approved',
                    'count' => $renewal_approved,
                    'count2' => $renewal_ongoing
                ];
                $i++;
            } while ($i <= 12);
        }
        //filter by month
        if (count($arrayMonth) > 0) {
            $renewal = collect($renewal)->whereIn('month', $arrayMonth);
            $renewal->all();
        }

        // haha
        // Graph Bar 6
        $biddingValid = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));

                // biddingValid
                $permit_valid = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                    ->where('status', CsmsStatus::Approved)
                    ->whereMonth('created_at', $i)
                    ->count();

                $permit_expired = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal, CsmsStatus::Inactive])
                    ->where('status', CsmsStatus::Inactive)
                    ->whereMonth('created_at', $i)
                    ->count();

                $biddingValid[] = [
                    'month' => $month_name,
                    'label' => 'Izin Valid',
                    'label2' => 'Izin Expired',
                    'count' => $permit_valid,
                    'count2' => $permit_expired
                ];

                $i++;
            } while ($i <= 12);
        }
        //filter by month
        if (count($arrayMonth) > 0) {
            $biddingValid = collect($biddingValid)->whereIn('month', $arrayMonth);
            $biddingValid->all();
        }

        // Graph Bar 7
        $riskLevel = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));

                // riskLevel
                $risk_low = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                    ->where('risk_category', RiskCategory::Rendah)
                    ->where('status', CsmsStatus::Approved)
                    ->whereMonth('created_at', $i)
                    ->count();

                $risk_mid = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                    ->where('risk_category', RiskCategory::Menengah)
                    ->where('status', CsmsStatus::Approved)
                    ->whereMonth('created_at', $i)
                    ->count();

                $risk_high = Bidding::whereYear('created_at', $yearList)
                        ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                        ->where('risk_category', RiskCategory::Tinggi)
                        ->where('status', CsmsStatus::Approved)
                        ->whereMonth('created_at', $i)
                        ->count();

                $riskLevel[] = [
                    'month' => $month_name,
                    'label' => 'Rendah',
                    'label2' => 'Menengah',
                    'label3' => 'Tinggi',
                    'count' => $risk_low,
                    'count2' => $risk_mid,
                    'count3' => $risk_high
                ];

                $i++;
            } while ($i <= 12);
        }
        //filter by month
        if (count($arrayMonth) > 0) {
            $riskLevel = collect($riskLevel)->whereIn('month', $arrayMonth);
            $riskLevel->all();
        }

        // Graph Bar 8
        $picaCount = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));

                // picaCount
                $picaOpen = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                    ->where('requested', CsmsStatus::Approved)
                    ->where('status', CsmsStatus::Open)
                    ->whereMonth('created_at', $i)
                    ->count();

                $picaOutStanding = CsmsPjo::whereYear('created_at', $yearList)
                    ->where('status', CsmsStatus::OnReviewEvaluator)
                    ->where('requested', CsmsStatus::RequestedEvaluator)
                    ->whereMonth('created_at', $i)
                    ->count();

                $picaClosed = CsmsPjo::whereYear('created_at', $yearList)
                    ->where('status', CsmsStatus::OnReviewEvaluator)
                    ->where('requested', CsmsStatus::RequestedEvaluator)
                    ->whereMonth('created_at', $i)
                    ->count();

                $picaCount[] = [
                    'month' => $month_name,
                    'label' => 'Open',
                    'label2' => 'Out Standing',
                    'label3' => 'Closed',
                    'count' => $picaOpen,
                    'count2' => $picaOutStanding,
                    'count3' => $picaClosed
                ];

                $i++;
            } while ($i <= 12);
        }
        //filter by month
        if (count($arrayMonth) > 0) {
            $picaCount = collect($picaCount)->whereIn('month', $arrayMonth);
            $picaCount->all();
        }

        // Graph Bar 9
        $contractorClasification = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));

                // contractorClasification
                $contractorMain = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                    ->where('requested', CsmsStatus::Approved)
                    ->where('status', CsmsStatus::Approved)
                    ->where('classification', CsmsStatus::KontraktorUtama)
                    ->whereMonth('created_at', $i)
                    ->count();

                $contractorDirect = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                    // ->where('requested', CsmsStatus::Approved)
                    // ->where('status', CsmsStatus::Approved)
                    ->where('classification', CsmsStatus::KontraktorLangsung)
                    ->whereMonth('created_at', $i)
                    ->count();

                $contractorSingle = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                    ->where('requested', CsmsStatus::Approved)
                    ->where('status', CsmsStatus::Approved)
                    ->where('classification', CsmsStatus::SubkontraktorTunggal)
                    ->whereMonth('created_at', $i)
                    ->count();

                $contractorJoint = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                    ->where('requested', CsmsStatus::Approved)
                    ->where('status', CsmsStatus::Approved)
                    ->where('classification', CsmsStatus::KontraktorBersama)
                    ->whereMonth('created_at', $i)
                    ->count();

                $contractorClasification[] = [
                        'month' => $month_name,
                        'label' => 'Kontraktor Utama',
                        'label2' => 'Kontraktor Langsung',
                        'label3' => 'Kontraktor Tunggal',
                        'label4' => 'Kontraktor Bersama',
                        'count' => $contractorMain,
                        'count2' => $contractorDirect,
                        'count3' => $contractorSingle,
                        'count4' => $contractorJoint
                    ];

                $i++;
            } while ($i <= 12);
        }
        //filter by month
        if (count($arrayMonth) > 0) {
            $contractorClasification = collect($contractorClasification)->whereIn('month', $arrayMonth);
            $contractorClasification->all();
        }

        // Graph Bar 10
        $spvStats = [];
        foreach ($arrayYear as $yearList) {
            $i = 1;
            do {
                $date = '1-' . $i . '-' . $yearList;
                $month_name = date('M',  strtotime($date));

                // biddingValid
                $spvStatistics = Bidding::whereYear('created_at', $yearList)
                    ->whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
                    ->where('status', CsmsStatus::Approved)
                    ->whereMonth('created_at', $i)
                    ->get();

                    if ($spvStatistics) {
                        $pops = [];
                        $poms = [];
                        $pous = [];
                        foreach ($spvStatistics as $key => $value) {
                            $pops[] = json_decode($value->questionnaire)->number_of_spv_pop;
                            $poms[] = json_decode($value->questionnaire)->number_of_spv_pom;
                            $pous[] = json_decode($value->questionnaire)->number_of_spv_pou;
                        }
                        $pop = array_sum($pops);
                        $pom = array_sum($poms);
                        $pou = array_sum($pous);
                    } else {
                        $pop = 0;
                        $pom = 0;
                        $pou = 0;
                    }

                $spvStats[] = [
                    'month' => $month_name,
                    'label' => 'POP',
                    'label2' => 'POM',
                    'label3' => 'POU',
                    'count' => $pop,
                    'count2' => $pom,
                    'count3' => $pou
                ];

                $i++;
            } while ($i <= 12);
        }

        //filter by month
        if (count($arrayMonth) > 0) {
            $spvStats = collect($spvStats)->whereIn('month', $arrayMonth);
            $spvStats->all();
        }

        $this->dataCsms = [
            'yearly' => $yearly,
            'detail' => $detail,
            'monthly' => $monthly,
            'category' => $categories,
            'progress' => $progress,
            'evaluatedPJO' => $evaluatedPJO,
            'approvedKTT' => $approvedKTT,
            'postBidding' => $postBidding,
            'renewal' => $renewal,

            'biddingValid' => $biddingValid,
            'riskLevel' => $riskLevel,
            'picaCount' => $picaCount,
            'contractorClasification' => $contractorClasification,
            'spvStats' => $spvStats,
        ];
    }

    public function render()
    {
        return view('csms::livewire.dashboard.dashboard-page')->layout('csms::layouts.app');
    }
}
