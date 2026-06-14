<?php

namespace App\Http\Livewire\Mcu\Doctor;

use App\Models\Mcu\MedicalHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{

    public function mount()
    {
        $statDaily = DB::table('mcu_medical_history as mcu')
            ->select('mcu.medical_type', DB::Raw('DATE(mcu.created_at) day'), DB::Raw('count(*) as day_count'))
            ->groupBy('medical_type', 'day')
            ->orderBy('mcu.created_at')
            ->limit(12)
            ->get()->toArray();

        $day = [];
        $annual = [];
        $pe = [];
        foreach ($statDaily as $std) {
            if ($std->medical_type == 'annual') {
                $day[] = Carbon::createFromFormat('Y-m-d', $std->day)->format('d/m');
                $annual[] = $std->day_count;
            } else {
                $pe[] = $std->day_count;
            }

        }
        $day = array_map(function ($day) {return $day;}, $day);
        $annual = array_map(function ($annual) {return $annual;}, $annual);
        $pe = array_map(function ($pe) {return $pe;}, $pe);

        $this->dailyCart = [
            'idChart' => 'dailyCart',
            'labels' => $day,
            'datasets' => [
                [
                    'label' => 'Annual',
                    'backgroundColor' => '#009D50',
                    'hoverBackgroundColor' => '#D9DC30',
                    'data' => $annual,
                ],
                [
                    'label' => 'Pre Employment',
                    'backgroundColor' => '#D9DC30',
                    'hoverBackgroundColor' => '#ffffff',
                    'data' => $pe,
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#ffffff',
                'beginAtZero' => true,
            ],
        ];

        $statMonthly = DB::table('mcu_medical_history as mcu')
            ->select('mcu.medical_type', DB::Raw('count(*) as month_count'), DB::raw('MONTH(created_at) month'))
            ->whereYear('created_at', '=', date('Y'))
            ->groupBy('medical_type', 'month')
            ->orderBy('month')
            ->limit(12)
            ->get()->toArray();

        $month = [];
        $annual = [];
        $pe = [];
        foreach ($statMonthly as $stm) {
            if ($stm->medical_type == 'annual') {
                $month[] = Carbon::createFromFormat('m', $stm->month)->format('M');
                $annual[] = $stm->month_count;
            } else {
                $pe[] = $stm->month_count;
            }

        }
        $month = array_map(function ($month) {return $month;}, $month);
        $annual = array_map(function ($annual) {return $annual;}, $annual);
        $pe = array_map(function ($pe) {return $pe;}, $pe);

        $this->annualCart = [
            'idChart' => 'chart2',
            'labels' => $month,
            'datasets' => [
                [
                    'label' => 'Annualy',
                    'backgroundColor' => '#009D50',
                    'hoverBackgroundColor' => '#ffffff',
                    'data' => $annual,
                ],
                [
                    'label' => 'Pre Employment',
                    'backgroundColor' => '#D9DC30',
                    'hoverBackgroundColor' => '#ffffff',
                    'data' => $pe,
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#ffffff',
                'beginAtZero' => true,
            ],
        ];

        $outcomeFit = MedicalHistory::where('doctor_status_review', 'Fit')->whereYear('created_at', '=', date('Y'))->count();
        $outcomeFwr = MedicalHistory::where('doctor_status_review', 'Fit With Recomendation')->whereYear('created_at', '=', date('Y'))->count();
        $outcomeCu = MedicalHistory::where('doctor_status_review', 'Curently Unfit')->whereYear('created_at', '=', date('Y'))->count();
        $outcomeUnfit = MedicalHistory::where('doctor_status_review', 'Unfit')->whereYear('created_at', '=', date('Y'))->count();
        $this->outcomeCart = [
            'idChart' => 'outcomeCart',
            'labels' => ['Fit', 'Fit With Recomendation', 'Curently Unfit', 'Unfit'],
            'datasets' => [
                [
                    'label' => 'Performance',
                    'backgroundColor' => '#009D50',
                    'hoverBackgroundColor' => '#D9DC30',
                    'data' => [$outcomeFit, $outcomeFwr, $outcomeCu, $outcomeUnfit],
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#ffffff',
                'beginAtZero' => true,
            ],
        ];

        $skkReleaseDaily = MedicalHistory::whereNotNull('doctor_certificate_number')->whereYear('created_at', '=', date('Y'))->count();
        $skkReleaseMonthly = MedicalHistory::whereNull('doctor_certificate_number')->whereYear('created_at', '=', date('Y'))->count();
        $skkHoldDaily = MedicalHistory::whereNotNull('doctor_certificate_number')->whereYear('created_at', '=', date('Y'))->count();
        $skkHoldMonthly = MedicalHistory::whereNull('doctor_certificate_number')->whereYear('created_at', '=', date('Y'))->count();
        $this->skkCart = [
            'idChart' => 'skkChart',
            'labels' => ['SKK Release', 'SKK Hold'],
            'datasets' => [
                [
                    'label' => 'Harian',
                    'backgroundColor' => '#009D50',
                    'hoverBackgroundColor' => '#ffffff',
                    'data' => [$skkReleaseDaily, $skkHoldDaily],
                ],
                [
                    'label' => 'Bulanan',
                    'backgroundColor' => '#D9DC30',
                    'hoverBackgroundColor' => '#ffffff',
                    'data' => [$skkReleaseMonthly, $skkHoldMonthly],
                ],
            ],
            'labelX' => [
                'display' => true,
                'color' => '#ffffff',
                'beginAtZero' => true,
            ],
        ];

        $bmiKurang = MedicalHistory::where('nutritional_status', 'Underweight')->whereYear('created_at', '=', date('Y'))->count();
        $bmiNormal = MedicalHistory::where('nutritional_status', 'Normal / Ideal')->whereYear('created_at', '=', date('Y'))->count();
        $bmiOver = MedicalHistory::where('nutritional_status', 'Overweight')->whereYear('created_at', '=', date('Y'))->count();
        $bmiOb1 = MedicalHistory::where('nutritional_status', 'Obesitas I')->whereYear('created_at', '=', date('Y'))->count();
        $bmiOb2 = MedicalHistory::where('nutritional_status', 'Obesitas II')->whereYear('created_at', '=', date('Y'))->count();

        $this->imtChart = [
            'idChart' => 'imtChart',
            'width' => 300,
            'height' => 300,
            'labels' => ['Kurang', 'Ideal', 'Overweight', 'Obesitas 1', 'Obesitas 2'],
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => [$bmiKurang, $bmiNormal, $bmiOver, $bmiOb1, $bmiOb2],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
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

        $hipertensiNormal = MedicalHistory::where('blood_pressure_status', 'Normal')->whereYear('created_at', '=', date('Y'))->count();
        $hipertensiPre = MedicalHistory::where('blood_pressure_status', 'Pre - Hipertensi')->whereYear('created_at', '=', date('Y'))->count();
        $hipertensi1 = MedicalHistory::where('blood_pressure_status', 'Hipertensi Tingkat 1')->whereYear('created_at', '=', date('Y'))->count();
        $hipertensi2 = MedicalHistory::where('blood_pressure_status', 'Hipertensi Tingkat 2')->whereYear('created_at', '=', date('Y'))->count();
        $hipertensi3 = MedicalHistory::where('blood_pressure_status', 'Hipertensi Tingkat 3')->whereYear('created_at', '=', date('Y'))->count();

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
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
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

        $framinghamRendah = MedicalHistory::where('frammingham_risk_level', 'Resiko Rendah')->whereYear('created_at', '=', date('Y'))->count();
        $framinghamSedang = MedicalHistory::where('frammingham_risk_level', 'Resiko Sedang')->whereYear('created_at', '=', date('Y'))->count();
        $framinghamTinggi = MedicalHistory::where('frammingham_risk_level', 'Resiko Tinggi')->whereYear('created_at', '=', date('Y'))->count();
        $framinghamSangat = MedicalHistory::where('frammingham_risk_level', 'Resiko Sangat Tinggi')->whereYear('created_at', '=', date('Y'))->count();

        $this->framinghamChart = [
            'idChart' => 'framinghamChart',
            'width' => 300,
            'height' => 300,
            'labels' => ['Rendah', 'Sedang', 'Tinggi', 'Sangat Tinggi'],
            'datasets' => [
                [
                    'label' => 'Level',
                    'data' => [$framinghamRendah, $framinghamSedang, $framinghamTinggi, $framinghamSangat],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 99, 132)',
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

        $jcRendah = MedicalHistory::where('jakarta_cardiovascular_risk_level', 'Rendah')->whereYear('created_at', '=', date('Y'))->count();
        $jcSedang = MedicalHistory::where('jakarta_cardiovascular_risk_level', 'Sedang')->whereYear('created_at', '=', date('Y'))->count();
        $jcTinggi = MedicalHistory::where('jakarta_cardiovascular_risk_level', 'Tinggi')->whereYear('created_at', '=', date('Y'))->count();
// dd($jcSedang);
        $this->jcChart = [
            'idChart' => 'jcChart',
            'width' => 300,
            'height' => 300,
            'labels' => ['Rendah', 'Sedang', 'Tinggi'],
            'datasets' => [
                [
                    'label' => 'Level',
                    'data' => [$jcRendah, $jcSedang, $jcTinggi],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
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
        return view('livewire.mcu.doctor.dashboard');
    }
}
