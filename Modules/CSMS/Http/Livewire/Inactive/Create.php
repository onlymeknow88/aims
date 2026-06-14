<?php

namespace Modules\CSMS\Http\Livewire\Inactive;

use App\Enums\CompanyType;
use App\Models\Company;
use App\Models\Employee;
use Auth;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;
use Modules\CSMS\Entities\CsmsMasterDataChecklist;

class Create extends Component
{
    use WithFileUploads;

    public $mode, $ccow, $ccow_id;
    public $inspectionOfficer = [];
    public $companyType = null;

    public $building_criteria_1_value;

    protected $messages = [
        'ccow_id.required' => 'Harus pilih salah satu CCOW',
    ];

    public function mount()
    { }

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('datetimepicker-input');
        $this->emit('form-check-input');
    }

    public function getCcowsProperty()
    {
        return Company::where('type', CompanyType::Internal)->get();
    }

    public function getChecklistCsmsProperty()
    {
        return CsmsMasterDataChecklist::where('point', 'POST KUALIFIKASI')->get();
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'ccow_id') {
            $this->ccow = Company::find($value);

            $this->employees = Employee::where(function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->whereHas('department', function ($query) {
                        $query->where('company_id', $this->ccow_id);
                    });
                });
            })->get();
        }
    }

    public function getCompaniesProperty()
    {
        return Company::all();
    }


    public function save()
    {
    }

    public function render()
    {
        return view('csms::livewire.inactive.create')->extends('csms::layouts.no-header');
    }
}
