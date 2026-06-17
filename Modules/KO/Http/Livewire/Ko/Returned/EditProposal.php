<?php

namespace Modules\KO\Http\Livewire\Ko\Returned;

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

class EditProposal extends Component
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

    public $proposal = [];

    public $ccow_id = "";
    public $area = "";
    public $spip_category_id = "";
    public $spip_type_id = "";
    public $spip_unit_id = "";
    public $unit_id = "";
    public $identity_number = "";
    public $brand = "";
    public $serial_number = "";
    public $production_year = "";
    public $company_id = "";
    public $department_id = null;
    public $other_department = "";
    public $applicant_email = "";
    public $pjo_id = "";

    protected $rules = [
        'ccow_id' => 'required|exists:companies,id',
        'area' => 'required|max:191',
        'unit_id' => 'required|exists:ko_units,id',
        'company_id' => 'required|exists:companies,id',
        //'department_id' => 'required|exists:departments,id',
        'applicant_email' => 'required|max:191',
        'pjo_id' => 'required|max:191',
    ];

    public function hydrate(): void
    {
        $this->emit('select2');
    }

    public function mount($id): void
    {
        $this->proposal = KoProposal::find($id);

        $this->ccows = Company::where('type', CompanyType::Internal()->value)->get();
        $this->spip_categories = KoSpipCategory::all();
        $this->spip_types = KoSpipType::where('ko_spip_category_id', $this->proposal->koUnit->koSpipUnit->koSpipType->ko_spip_category_id)->get();
        $this->spip_units = KoSpipUnit::where('ko_spip_type_id', $this->proposal->koUnit->koSpipUnit->ko_spip_type_id)->get();
        $this->units = KoUnit::where('ko_spip_unit_id', $this->proposal->koUnit->ko_spip_unit_id)->get();
        $this->companies = Company::all();
        $this->departments = Department::where('company_id', $this->proposal->company_id)->get();
        $this->pjo = User::all();

        $this->ccow_id = $this->proposal->ccow_id;
        $this->area = $this->proposal->area;
        $this->spip_category_id = $this->proposal->koUnit->koSpipUnit->koSpipType->ko_spip_category_id;
        $this->spip_type_id = $this->proposal->koUnit->koSpipUnit->ko_spip_type_id;
        $this->spip_unit_id = $this->proposal->koUnit->ko_spip_unit_id;
        $this->unit_id = $this->proposal->ko_unit_id;
        $this->identity_number = $this->proposal->koUnit->identity_number;
        $this->brand = $this->proposal->koUnit->koBrand->name;
        $this->serial_number = $this->proposal->koUnit->serial_number;
        $this->production_year = $this->proposal->koUnit->production_year;
        $this->company_id = $this->proposal->company_id;
        $this->department_id = $this->proposal->department_id ?? 'other';
        $this->other_department = $this->proposal->other_department;
        $this->applicant_email = $this->proposal->applicant_email;
        $this->pjo_id = $this->proposal->pjo_id;
    }

    public function updatedSpipCategoryId()
    {
        $this->spip_type_id = "";
        $this->spip_unit_id = "";
        $this->unit_id = "";
        $this->spip_types = KoSpipType::where('ko_spip_category_id', $this->spip_category_id)->get();
    }

    public function updatedSpipTypeId()
    {
        $this->spip_unit_id = "";
        $this->unit_id = "";
        $this->spip_units = KoSpipUnit::where('ko_spip_type_id', $this->spip_type_id)->get();
    }

    public function updatedSpipUnitId()
    {
        $this->unit_id = "";
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
        $this->department_id = '';
        $this->departments = Department::where('company_id', $this->company_id)->get();
    }

    public function generateNumber($code)
    {
        $existCode = KoProposal::where('number', 'like', '%'.$code.'%')->latest()->first();

        if ($this->proposal->number == $existCode->number) {
            return $this->proposal->number;
        }

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

            $this->proposal->update([
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
            return redirect()->route('ko::ko.draft.edit.attachment', $this->proposal->id);
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
        return view('ko::livewire.ko.returned.edit-proposal')->extends('ko::layouts.no-header');
    }
}
