<?php

namespace Modules\KO\Http\Livewire\Ko;

use App\Enums\CompanyType;
use App\Enums\KO\KoStatus;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Component;
use Modules\KO\Entities\KoProposal;
use Modules\KO\Entities\KoSpipCategory;
use Modules\KO\Entities\KoSpipType;
use Modules\KO\Entities\KoSpipUnit;
use Modules\KO\Entities\KoUnit;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateProposal extends Component
{
    use LivewireAlert;

    public $ccows = [];
    public $departments = [];
    public $spip_categories = [];
    public $spip_types = [];
    public $spip_units = [];
    public $units = [];
    public $companies = [];
    public $pjo = [];

    public string $ccow_id = "";
    public string $area = "";
    public string $spip_category_id = "";
    public string $spip_type_id = "";
    public string $spip_unit_id = "";
    public string $unit_id = "";
    public string $identity_number = "";
    public string $brand = "";
    public string $serial_number = "";
    public string $production_year = "";
    public string $company_id = "";
    public $department_id = null;
    public string $other_department = "";
    public string $applicant_email = "";
    public string $pjo_id = "";

    protected $rules = [
        'ccow_id' => 'required|exists:companies,id',
        'area' => 'required|max:191',
        'unit_id' => 'required|exists:ko_units,id',
        'company_id' => 'required|exists:companies,id',
        //'department_id' => 'required|exists:departments,id',
        'applicant_email' => 'required|max:191',
        'pjo_id' => 'required|max:191',
    ];

    public function mount(): void
    {
        $this->ccows = Company::where('type', CompanyType::Internal()->value)->get();
        $this->spip_categories = KoSpipCategory::all();
        $this->companies = Company::all();
        $this->pjo = User::all();
    }

    public function hydrate(): void
    {
        $this->emit('select2');
    }

    public function updatedSpipCategoryId()
    {
        $this->spip_types = KoSpipType::where('ko_spip_category_id', $this->spip_category_id)->get();
    }

    public function updatedSpipTypeId()
    {
        $this->spip_units = KoSpipUnit::where('ko_spip_type_id', $this->spip_type_id)->get();
    }

    public function updatedSpipUnitId()
    {
        $this->units = KoUnit::where('is_revoked', 0)->where('ko_spip_unit_id', $this->spip_unit_id)->get();
    }

    public function updatedUnitId()
    {
        $unit = KoUnit::find($this->unit_id);
        $this->identity_number = $unit?->identity_number ?? '-';
        $this->brand = $unit?->koBrand?->name ?? '';
        $this->serial_number = $unit?->serial_number ?? '';
        $this->production_year = $unit?->production_year ?? '';
    }

    public function updatedCompanyId()
    {
        $this->departments = Department::where('company_id', $this->company_id)->get();
    }

    public function generateNumber($code)
    {
        $existCode = KoProposal::where('number', 'like', '%'.$code.'%')->latest()->first();

        if ($existCode) {
            $number = substr($existCode->number, 4);
            $number = str_pad($number + 1, 3, '0', STR_PAD_LEFT);
            $number = $code . '-' . $number;
        } else {
            $number = $code . '-001';
        }

        return $number;
    }

    public function store(): bool|RedirectResponse|Redirector
    {
        $this->validate();
        try {
            DB::beginTransaction();

            if ($this->area == 'Lampunut') {
                $code = 'LMP';
            } elseif ($this->area == 'Haju') {
                $code = 'HJU';
            } elseif ($this->area == 'Tuhup') {
                $code = 'THP';
            } else {
                $code = '';
            }

            $number = $this->generateNumber($code);
            $unit = KoUnit::find($this->unit_id);

            $proposal = KoProposal::create([
                'number' => $number,
                'ccow_id' => $this->ccow_id,
                'area' => $this->area,
                'ko_unit_id' => $this->unit_id,
                'company_id' => $this->company_id,
                'department_id' => $this->department_id == 'other' ? null : $this->department_id,
                'other_department' => $this->other_department,
                'applicant_email' => $this->applicant_email,
                'commissioning_period' => $unit->commissioning_count + 1,
                'pjo_id' => $this->pjo_id,
                'status' => KoStatus::Draft()->value
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('ko::ko.add.attachment', $proposal->id);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function render(): Factory|View|Application
    {
        return view('ko::livewire.ko.create-proposal')->extends('ko::layouts.no-header');
    }
}
