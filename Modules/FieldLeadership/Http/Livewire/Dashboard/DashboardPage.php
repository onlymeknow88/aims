<?php

namespace Modules\FieldLeadership\Http\Livewire\Dashboard;

use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Illuminate\Http\Request;

class DashboardPage extends Component
{
    public $year;
    public $months;
    public $ccow;
    public $company;
    public $detail_company;
    public $department;
    public $section;
    public $location;
    public $type_pto;
    public $type_ttt;
    public $type_hr;
    public $category;
    public $potency;
    public $kta_tta;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount(Request $request)
    {
        $this->year = $request->year ?? Carbon::now()->format('Y');

        if ($request->has('year')) {
            $this->year = $request->year;
        }

        /* Begin::CCOW */
        $ccow = FieldLeadership::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->groupBy('ccow_id')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_ccow = [];
        /* End::CCOW */

        /* Begin::Company */
        $company = FieldLeadership::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->groupBy('company_id')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_company = [];
        /* End::Company */

        /* Begin::Detail Company */
        $detail_company = FieldLeadership::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->groupBy('detail_company')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_detail_company = [];
        /* End::Detail Company */

        /* Begin::Department */
        $department = FieldLeadership::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->groupBy('department_id')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_department = [];
        /* End::Department */

        /* Begin::Section */
        $section = FieldLeadership::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->groupBy('section_id')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_section = [];
        /* End::Section */

        /* Begin::Area Location */
        $location = FieldLeadership::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->groupBy('area_location_id')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_location = [];
        /* End::Area Location */

        /* Begin::Type Field Leadership */
        /* Begin::Planned Task Observation */
        $pto = FieldLeadership::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->where('type', 'Planned Task Observation')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_pto = [];
        /* End::Planned Task Observation */

        /* Begin::Take Time Talk */
        $ttt = FieldLeadership::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->where('type', 'Take Time Talk')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_ttt = [];
        /* End::Take Time Talk */

        /* Begin::Hazard Report */
        $hr = FieldLeadership::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->where('type', 'Hazard Report')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_hr = [];
        /* End::Hazard Report */
        /* End::Type Field Leadership */

        /* Begin::Category */
        $category = FieldLeadershipRisk::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->groupBy('category_id')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_category = [];
        /* End::Category */

        /* Begin::Potency */
        $potency = FieldLeadershipRisk::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->groupBy('potency_id')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_potency = [];
        /* End::Potency */

        /* Begin::Jenis KTA/TTA */
        $kta_tta = FieldLeadershipRisk::when($this->year, function ($query) {
            $query->where('created_at', 'like', '%' . $this->year . '%');
        })
            ->groupBy('type_id')
            ->get()
            ->groupBy(function ($bulan) {
                return Carbon::parse($bulan->created_at)->format('m'); // grouping by months
            });
        $total_kta_tta = [];
        /* End::Jenis KTA/TTA */

        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create(null, $i, 1)->format('M');
            $year = Carbon::now()->format('Y');
            $monthYear = Carbon::now()->format('Y') . '-' . Carbon::create(null, $i, 1)->format('m');
            $label = $month;
            $this->months[] = $label;

            /* Begin::CCOW */
            foreach ($ccow as $key => $value) {
                $total_ccow[(int)$key] = $value->count() ?? 0;
            }
            $this->ccow[$month] = $total_ccow[$i] ?? 0;
            /* End::CCOW */

            /* Begin::Company */
            foreach ($company as $key => $value) {
                $total_company[(int)$key] = $value->count() ?? 0;
            }
            $this->company[$month] = $total_company[$i] ?? 0;
            /* End::Company */

            /* Begin::Detail Company */
            foreach ($detail_company as $key => $value) {
                $total_detail_company[(int)$key] = $value->count() ?? 0;
            }
            $this->detail_company[$month] = $total_detail_company[$i] ?? 0;
            /* End::Detail Company */

            /* Begin::Department */
            foreach ($department as $key => $value) {
                $total_department[(int)$key] = $value->count() ?? 0;
            }
            $this->department[$month] = $total_department[$i] ?? 0;
            /* End::Department */

            /* Begin::Section */
            foreach ($section as $key => $value) {
                $total_section[(int)$key] = $value->count() ?? 0;
            }
            $this->section[$month] = $total_section[$i] ?? 0;
            /* End::Section */

            /* Begin::Area Location */
            foreach ($location as $key => $value) {
                $total_location[(int)$key] = $value->count() ?? 0;
            }
            $this->location[$month] = $total_location[$i] ?? 0;
            /* End::Area Location */

            /* Begin::Type Field Leadership */
            /* Begin::Planned Task Observation */
            foreach ($pto as $key => $value) {
                $total_pto[(int)$key] = $value->count() ?? 0;
            }
            $this->type_pto[$month] = $total_pto[$i] ?? 0;
            /* End::Planned Task Observation */

            /* Begin::Take Time Talk */
            foreach ($ttt as $key => $value) {
                $total_ttt[(int)$key] = $value->count() ?? 0;
            }
            $this->type_ttt[$month] = $total_ttt[$i] ?? 0;
            /* End::Take Time Talk */

            /* Begin::Hazard Report */
            foreach ($hr as $key => $value) {
                $total_hr[(int)$key] = $value->count() ?? 0;
            }
            $this->type_hr[$month] = $total_hr[$i] ?? 0;
            /* End::Hazard Report */
            /* End::Type Field Leadership */

            /* Begin::Category */
            foreach ($category as $key => $value) {
                $total_category[(int)$key] = $value->count() ?? 0;
            }
            $this->category[$month] = $total_category[$i] ?? 0;
            /* End::Category */

            /* Begin::Potency */
            foreach ($potency as $key => $value) {
                $total_potency[(int)$key] = $value->count() ?? 0;
            }
            $this->potency[$month] = $total_potency[$i] ?? 0;
            /* End::Potency */

            /* Begin::Jenis KTA/TTA */
            foreach ($kta_tta as $key => $value) {
                $total_kta_tta[(int)$key] = $value->count() ?? 0;
            }
            $this->kta_tta[$month] = $total_kta_tta[$i] ?? 0;
            /* End::Jenis KTA/TTA */
        }
    }

    public function updatedYear()
    {
        $this->getCcowsProperty();
    }

    public function render()
    {
        return view('fieldleadership::livewire.dashboard.dashboard-page')
            ->layout('fieldleadership::layouts.app');
    }
}
