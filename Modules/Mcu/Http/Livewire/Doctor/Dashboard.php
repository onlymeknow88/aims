<?php

namespace Modules\Mcu\Http\Livewire\Doctor;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Mcu\Entities\MedicalHistory;

class Dashboard extends Component
{
    public function mount()
    {
        $statDaily = DB::table('mcu_medical_history as mcu')
            ->select('mcu.medical_type', DB::Raw('DATE(mcu.created_at) day'), DB::Raw('count(*) as day_count'))
            ->where('doctor_status_review', '!=', 'draft')
            ->groupBy('medical_type', 'day')
            ->orderBy('mcu.created_at')
            ->limit(12)
            ->get()->toArray();

        $day = [];
        $annual = [];
        $pe = [];
        foreach ($statDaily as $std) {
            if ($std->medical_type == 'periodic') {
                $day[] = Carbon::createFromFormat('Y-m-d', $std->day)->format('d/m');
                $annual[] = $std->day_count;
            } else {
                $pe[] = $std->day_count;
            }
        }

        $day = array_map(function ($day) {
            return $day;
        }, $day);
        $annual = array_map(function ($annual) {
            return $annual;
        }, $annual);
        $pe = array_map(function ($pe) {
            return $pe;
        }, $pe);


        $this->dailyCart = [
            'idChart' => 'dailyCart',
            'labels' => $day,
            'datasets' => [
                [
                    'label' => 'Annual',
                    'backgroundColor' => '#118ab2',
                    // 'hoverBackgroundColor' => '#D9DC30',
                    'data' => $annual,
                ],
                [
                    'label' => 'Pre Employment',
                    'backgroundColor' => '#06d6a0',
                    // 'hoverBackgroundColor' => '#D9DC30',
                    'data' => $pe,
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#000',
                'beginAtZero' => true,
            ],
        ];

        $statMonthly = DB::table('mcu_medical_history as mcu')
            ->select('mcu.medical_type', DB::Raw('count(*) as month_count'), DB::raw('MONTH(created_at) month'))
            ->where('doctor_status_review', '!=', 'draft')
            ->whereYear('created_at', '=', date('Y'))
            ->groupBy('medical_type', 'month')
            ->orderBy('month')
            ->limit(12)
            ->get()->toArray();

        $month = [];
        $annual = [];
        $pe = [];
        foreach ($statMonthly as $stm) {
            if ($stm->medical_type == 'periodic') {
                $month[] = Carbon::createFromFormat('m', $stm->month)->format('M');
                $annual[] = $stm->month_count;
            } else {
                $pe[] = $stm->month_count;
            }
        }
        $month = array_map(function ($month) {
            return $month;
        }, $month);
        $annual = array_map(function ($annual) {
            return $annual;
        }, $annual);
        $pe = array_map(function ($pe) {
            return $pe;
        }, $pe);

        $this->annualCart = [
            'idChart' => 'chart2',
            'labels' => $month,
            'datasets' => [
                [
                    'label' => 'Annualy',
                    'backgroundColor' => '#118ab2',
                    // 'hoverBackgroundColor' => '#118ab2',
                    'data' => $annual,
                ],
                [
                    'label' => 'Pre Employment',
                    'backgroundColor' => '#06d6a0',
                    // 'hoverBackgroundColor' => '#D9DC30',
                    'data' => $pe,
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#000',
                'beginAtZero' => true,
            ],
        ];

        $outcomeFit = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('doctor_status_review', 'Fit')->whereYear('created_at', '=', date('Y'))->count();
        $outcomeFwr = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('doctor_status_review', 'Fit With Recomendation')->whereYear('created_at', '=', date('Y'))->count();
        $outcomeCu = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('doctor_status_review', 'Curently Unfit')->whereYear('created_at', '=', date('Y'))->count();
        $outcomeUnfit = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('doctor_status_review', 'Unfit')->whereYear('created_at', '=', date('Y'))->count();
        $this->outcomeCart = [
            'idChart' => 'outcomeCart',
            'labels' => ['Fit', 'Fit With Recomendation', 'Curently Unfit', 'Unfit'],
            'datasets' => [
                [
                    'label' => 'Performance',
                    // 'backgroundColor' => '#118ab2',
                    'backgroundColor' => ['#118ab2', '#06d6a0', '#ffd166', '#ef476f'],
                    // 'hoverBackgroundColor' => '#D9DC30',
                    'data' => [$outcomeFit, $outcomeFwr, $outcomeCu, $outcomeUnfit],
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#000',
                'beginAtZero' => true,
            ],
        ];

        $skkRelease = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('doctor_status_review', '!=', 'Curently Unfit')->whereNotNull('doctor_certificate_number')->whereYear('created_at', '=', date('Y'))->count();
        // $skkReleaseMonthly = MedicalHistory::whereNull('doctor_certificate_number')->whereYear('created_at', '=', date('Y'))->count();
        $skkHold = MedicalHistory::where('doctor_status_review', 'Curently Unfit')->whereYear('created_at', '=', date('Y'))->count();
        // $skkHoldMonthly = MedicalHistory::whereNull('doctor_certificate_number')->whereYear('created_at', '=', date('Y'))->count();
        $this->skkCart = [
            'idChart' => 'skkChart',
            'labels' => ['SKK Release', 'SKK Hold'],
            'datasets' => [
                [
                    'label' => 'Total',
                    'backgroundColor' => ['#06d6a0', '#ffd166'],
                    // 'backgroundColor' => '#118ab2',
                    // 'hoverBackgroundColor' => '#D9DC30',
                    'data' => [$skkRelease, $skkHold],
                ],
                // [
                //     'label' => 'Total',
                //     'backgroundColor' => '#D9DC30',
                //     'hoverBackgroundColor' => '#000',
                //     'data' => [$skkHold],
                // ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#000',
                'beginAtZero' => true,
            ],
        ];

        $bmiKurang = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('nutritional_status', 'Underweight')->whereYear('created_at', '=', date('Y'))->count();
        $bmiNormal = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('nutritional_status', 'Normal / Ideal')->whereYear('created_at', '=', date('Y'))->count();
        $bmiOver = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('nutritional_status', 'Overweight')->whereYear('created_at', '=', date('Y'))->count();
        $bmiOb1 = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('nutritional_status', 'Obesitas I')->whereYear('created_at', '=', date('Y'))->count();
        $bmiOb2 = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('nutritional_status', 'Obesitas II')->whereYear('created_at', '=', date('Y'))->count();
        // dd($bmiNormal);
        $this->imtChart = [
            'idChart' => 'imtChart',
            'width' => 300,
            'height' => 300,
            'labels' => ['Kurang', 'Ideal', 'Overweight', 'Obesitas 1', 'Obesitas 2'],
            'datasets' => [
                [
                    'label' => 'Total',
                    // 'data'  =>  [65, 59, 20, 81, 56],
                    'data' => [$bmiKurang ? $bmiKurang : 1, $bmiNormal ? $bmiNormal : 0, $bmiOver ? $bmiOver : 0, $bmiOb1 ? $bmiOb1 : 0, $bmiOb2 ? $bmiOb2 : 0],
                    'backgroundColor' => [
                        '#118ab2',
                        '#06d6a0',
                        '#ffd166',
                        '#ef476f',
                        '#073b4c',
                    ],
                ],
            ],
            'legend' => true,
            'labelX' => [
                'display' => true,
                'color' => 'rgba(0,0,0,0.8)',
                'beginAtZero' => true,
            ]
        ];

        $hipertensiNormal = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('blood_pressure_status', 'Normal')->whereYear('created_at', '=', date('Y'))->count();
        $hipertensiPre = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('blood_pressure_status', 'Pre - Hipertensi')->whereYear('created_at', '=', date('Y'))->count();
        $hipertensi1 = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('blood_pressure_status', 'Hipertensi Tingkat 1')->whereYear('created_at', '=', date('Y'))->count();
        $hipertensi2 = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('blood_pressure_status', 'Hipertensi Tingkat 2')->whereYear('created_at', '=', date('Y'))->count();
        $hipertensi3 = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('blood_pressure_status', 'Hipertensi Tingkat 3')->whereYear('created_at', '=', date('Y'))->count();

        $this->hipertensiChart = [
            'idChart' => 'hipertensiChart',
            'width' => 300,
            'height' => 300,
            'labels' => ['Normal', 'Pre - Hipertensi', 'Hipertensi Tingkat 1', 'Hipertensi Tingkat 2', 'Hipertensi Tingkat 3'],
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => [$hipertensiNormal, $hipertensiPre, $hipertensi1, $hipertensi2, $hipertensi3],
                    'backgroundColor' => [
                        '#06d6a0',
                        '#118ab2',
                        '#ffd166',
                        '#ef476f',
                        '#073b4c',
                    ],
                ],
            ],
            'legend' => true,
            'labelX' => [
                'display' => true,
                'color' => 'rgba(0,0,0,0.8)',
                'beginAtZero' => true,
            ],
        ];

        $framinghamRendah = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('frammingham_risk_level', 'Resiko Rendah')->whereYear('created_at', '=', date('Y'))->count();
        $framinghamSedang = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('frammingham_risk_level', 'Resiko Sedang')->whereYear('created_at', '=', date('Y'))->count();
        $framinghamTinggi = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('frammingham_risk_level', 'Resiko Tinggi')->whereYear('created_at', '=', date('Y'))->count();
        $framinghamSangat = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('frammingham_risk_level', 'Resiko Sangat Tinggi')->whereYear('created_at', '=', date('Y'))->count();

        $this->framinghamChart = [
            'idChart' => 'framinghamChart',
            'width' => 300,
            'height' => 300,
            'labels' => ['Rendah', 'Sedang', 'Tinggi', 'Sangat Tinggi'],
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => [$framinghamRendah, $framinghamSedang, $framinghamTinggi, $framinghamSangat],
                    'backgroundColor' => [
                        '#06d6a0',
                        '#ffd166',
                        '#ef476f',
                        '#073b4c',
                    ],
                ],
            ],
            'legend' => true,
            'labelX' => [
                'display' => false,
                'color' => 'rgba(0,0,0,0.8)',
                'beginAtZero' => true,
            ],
        ];

        $jcRendah = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('jakarta_cardiovascular_risk_level', 'Rendah')->whereYear('created_at', '=', date('Y'))->count();
        $jcSedang = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('jakarta_cardiovascular_risk_level', 'Sedang')->whereYear('created_at', '=', date('Y'))->count();
        $jcTinggi = MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('jakarta_cardiovascular_risk_level', 'Tinggi')->whereYear('created_at', '=', date('Y'))->count();
        // dd($jcSedang);
        $this->jcChart = [
            'idChart' => 'jcChart',
            'width' => 300,
            'height' => 300,
            'labels' => ['Rendah', 'Sedang', 'Tinggi'],
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => [$jcRendah, $jcSedang, $jcTinggi],
                    'backgroundColor' => [
                        '#06d6a0',
                        '#ffd166',
                        '#ef476f',
                    ],
                ],
            ],
            'legend' => true,
            'labelX' => [
                'display' => false,
                'color' => 'rgba(0,0,0,0.8)',
                'beginAtZero' => true,
            ],
        ];
    }

    public function render()
    {
        if (Auth::user()->hasPermissionTo('MCU - View Dashboard MCU')) {
            return view('mcu::livewire.doctor.dashboard')->layout('mcu::layouts.app');
        } else {
            return abort(404);
        }
    }
}
