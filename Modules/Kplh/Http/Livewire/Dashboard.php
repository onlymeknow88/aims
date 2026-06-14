<?php

namespace Modules\Kplh\Http\Livewire;

use App\Enums\CompanyType;
use App\Models\Company;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $label1;
    public $data1;

    public $label2;
    public $data2;
    public $label3;
    public $data3;
    public $label4;
    public $data4;
    public $label5;
    public $data5;

    public $data6;

    public $search, $sortSelected = [], $sortFieldSelected, $filter_date_start, $filter_date_end, $optCcow, $filter_ccow, $optDepartment, $selected_department = '';

    public function mount()
    {
        $this->optCcow = Company::get();
        $this->optDepartment = Department::whereHas('company', function ($query) {
            $query->where('type', CompanyType::Internal);
        })->get();

        $this->generateData1();
        $this->generateData2();
        $this->generateData3();
        $this->filter_date_start = Carbon::now()->format('F d, Y');
    }

    public function searchUpdated($search)
    {
        $this->search = $search;
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'filter_date_end') {
            if ($value) {
                $this->generateData3();
                $this->emit('updateChart3', [
                    'data3' => $this->data3,
                    'label3' => $this->label3,
                    'title' => 'Status Inspeksi KPLH | ' . Carbon::parse($this->filter_date_start)->format('d/m/Y') . ' - ' . Carbon::parse($this->filter_date_end)->format('d/m/Y') . ' ' . $this->selected_department . '',
                ]);
            }
        }

        if ($propertyName == 'filter_date_start') {
            if ($this->filter_date_end) {
                $this->generateData3();
                $this->emit('updateChart3', [
                    'data3' => $this->data3,
                    'label3' => $this->label3,
                    'title' => 'Status Inspeksi KPLH | ' . Carbon::parse($this->filter_date_start)->format('d/m/Y') . ' - ' . Carbon::parse($this->filter_date_end)->format('d/m/Y') . ' ' . $this->selected_department . '',
                ]);
            }
        }
    }

    public function generateData1()
    {
        $data1 = DB::select('select c.company_name, count(k.id) as amount
                                from companies c
                                left join kplh_label k on k.ccow_id = c.id and  k.status = "approved"
                                group by c.company_name');
        $resultsArray = json_decode(json_encode($data1), true);

        $this->label1 = array_map(function ($item) {
            return "'" . $item["company_name"] . "'";
        }, $resultsArray);

        $this->data1 = array_map(function ($item) {
            return $item["amount"];
        }, $resultsArray);

    }

    public function generateData2()
    {

        $data1 = DB::select('select u.name, count(k.id) as amount
                                from area_managers am
                                left join users u on u.id = am.user_id
                                left join kplh_label k on k.pja_id = am.id and k.status = "approved"
                                group by u.name');
        $resultsArray = json_decode(json_encode($data1), true);

        $this->label2 = array_map(function ($item) {
            return "'" . $item["name"] . "'";
        }, $resultsArray);

        $this->data2 = array_map(function ($item) {
            return $item["amount"];
        }, $resultsArray);

    }

    public function generateData3()
    {
        if ($this->filter_date_start && $this->filter_date_end) {
            $filter = "AND k2.date BETWEEN '" . Carbon::parse($this->filter_date_start)->format('Y-m-d') . "' AND '" . Carbon::parse($this->filter_date_end)->format('Y-m-d') . "'";
        } else {
            $filter = "";
        }

        if ($this->sortSelected) {
            if (array_key_exists('department_id', $this->sortSelected)) {
                $sort_department_id = "AND k2.department_id IN ('" . implode("', '", $this->sortSelected['department_id']) . "')";

                $dept = Department::whereIn('id', $this->sortSelected['department_id'])->get()->pluck('name')->implode(', ');

                $this->selected_department = '| Departemen : ' . $dept;
            } else {
                $sort_department_id = "";
            }
            $sort = $sort_department_id;
        } else {
            $sort = "";
        }

        $data1 = DB::SELECT("SELECT DISTINCT k.status, (SELECT count(k2.id) FROM kplh_label k2 WHERE k2.status = k.status $sort $filter) as amount
                                FROM kplh_label k
                                WHERE k.deleted_at IS NULL");

        $resultsArray = json_decode(json_encode($data1), true);

        if ($this->filter_date_start && $this->filter_date_end || $this->sortSelected) {
            $this->label3 = array_map(function ($item) {
                if ($item["status"] == 'approved') {
                    return "Disetujui";
                } elseif ($item["status"] == 'active') {
                    return "Dalam Pengajuan";
                } elseif ($item["status"] == 'draft') {
                    return "Draft";
                } else {
                    return "'" . $item["status"] . "'";
                }
            }, $resultsArray);
        } else {
            $this->label3 = array_map(function ($item) {
                if ($item["status"] == 'approved') {
                    return "'Disetujui'";
                } elseif ($item["status"] == 'active') {
                    return "'Dalam Pengajuan'";
                } elseif ($item["status"] == 'draft') {
                    return "'Draft'";
                } else {
                    return "'" . $item["status"] . "'";
                }
            }, $resultsArray);
        }

        $this->data3 = array_map(function ($item) {
            return $item["amount"];
        }, $resultsArray);
    }

    public function sortCheck($field, $value)
    {
        $this->sortFieldSelected = $field;

        if (!empty($this->sortSelected[$this->sortFieldSelected])) {
            if (in_array($value, $this->sortSelected[$this->sortFieldSelected])) {
                $key = array_search($value, $this->sortSelected[$this->sortFieldSelected]);

                unset($this->sortSelected[$this->sortFieldSelected][$key]);
                if (empty($this->sortSelected[$this->sortFieldSelected])) {
                    unset($this->sortSelected[$this->sortFieldSelected]);
                }
            } else {
                $this->sortSelected[$this->sortFieldSelected][] = $value;
            }
        } else {
            $this->sortSelected[$this->sortFieldSelected][] = $value;
        }

        if ($field == 'department_id') {

            $this->generateData3();

            if ($this->filter_date_end) {
                $title =  'Status Inspeksi KPLH | ' . Carbon::parse($this->filter_date_start)->format('d/m/Y') . ' - ' . Carbon::parse($this->filter_date_end)->format('d/m/Y') . ' ' . $this->selected_department . '';
            } else {
                $title =  'Status Inspeksi KPLH | ' . $this->selected_department . '';
            }

            $this->emit('updateChart3', [
                'data3' => $this->data3,
                'label3' => $this->label3,
                'title' => $title,
            ]);
        }

    }

    public function render()
    {
        return view('kplh::livewire.dashboard')->layout('kplh::layouts.app');
    }
}
