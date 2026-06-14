<?php

namespace Modules\DocumentSystem\Http\Livewire\Dashboard;

use App\Models\Department;
use Carbon\Carbon;
use Livewire\Component;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\JsaDocument;
use Modules\DocumentSystem\Entities\PtwDocument;

class Dashboard extends Component
{
    public $months = [];
    public $total_document;
    public $total_jsa;
    public $total_ptw;
    public $allChart = [];

    public function mount()
    {

        $departments = Department::all();
        $data_total = [];
        $data_active = [];
        $data_expired = [];

        foreach ($departments as $department) {
            $documentsTotal = Document::where('department_id', $department->id)
                ->get()
                ->groupBy(function ($bulan) {
                    return Carbon::parse($bulan->doc_created)->format('m'); // grouping by months
                });

            $documentsActive = Document::where('department_id', $department->id)
                ->where('status', Document::ACTIVE)
                ->get()
                ->groupBy(function ($bulan) {
                    return Carbon::parse($bulan->doc_created)->format('m'); // grouping by months
                });


            $documentsExpired = Document::where('department_id', $department->id)
                ->where('status', Document::EXPIRED)
                ->get()
                ->groupBy(function ($bulan) {
                    return Carbon::parse($bulan->doc_created)->format('m'); // grouping by months
                });


            for ($i = 1; $i <= 12; $i++) {
                $month = Carbon::create(null, $i, 1)->format('M');
                $year = Carbon::now()->format('Y');
                $monthYear = Carbon::now()->format('Y') . '-' . Carbon::create(null, $i, 1)->format('m');
                $label = $month;
                $this->months[] = $label;

                foreach ($documentsTotal as $key => $value) {
                    if ((int)$key == $i) {
                        $data_total[(int)$key] = $value->count() ?? 0;
                    } else {
                        $data_total[(int)$key] = 0;
                    }
                }
                $totalData[$month] = $data_total[$i] ?? 0;

                foreach ($documentsActive as $key => $value) {
                    if ((int)$key == $i) {
                        $data_active[(int)$key] = $value->count() ?? 0;
                    } else {
                        $data_active[(int)$key] = 0;
                    }
                }
                $totalActive[$month] = $data_active[$i] ?? 0;

                foreach ($documentsExpired as $key => $value) {
                    if ((int)$key == $i) {
                        $data_expired[(int)$key] = $value->count() ?? 0;
                    } else {
                        $data_expired[(int)$key] = 0;
                    }
                }
                $totalExpired[$month] = $data_expired[$i] ?? 0;
            }

            // $this->total_document[$department->name] = $totalData;
            // $this->total_jsa[$department->name] = $totalActive;
            // $this->total_ptw[$department->name] = $totalExpired;

            $this->allChart[$department->id] = [
                'department'    => $department->name,
                'department_company' => $department->company->document_code,
                'total'         => $totalData,
                'active'        => $totalActive,
                'expired'       => $totalExpired
            ];
        }
        // dd($this->allChart);
    }

    public function render()
    {
        return view('documentsystem::livewire.dashboard.dashboard')
            ->layout('documentsystem::layouts.app');
    }
}
