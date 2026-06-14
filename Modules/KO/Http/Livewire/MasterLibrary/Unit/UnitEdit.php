<?php

namespace Modules\KO\Http\Livewire\MasterLibrary\Unit;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Modules\KO\Entities\KoBrand;
use Modules\KO\Entities\KoSpipCategory;
use Modules\KO\Entities\KoSpipType;
use Modules\KO\Entities\KoSpipUnit;
use Modules\KO\Entities\KoUnit;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UnitEdit extends Component
{
    use LivewireAlert;
    
    public $ko_unit = [];
    public $ko_spip_categories = [];
    public $ko_spip_types = [];
    public $ko_spip_units = [];
    public $ko_brands = [];

    public string $ko_spip_category_id = "";
    public string $ko_spip_type_id = "";
    public string $ko_spip_unit_id = "";
    public string $call_sign = "";
    public string $identity_number = "";
    public string $ko_brand_id = "";
    public string $serial_number = "";
    public string $model_unit = "";
    public string $production_year = "";

    public function rules() {
        $rules = [
            'ko_spip_unit_id' => 'required|exists:ko_spip_units,id',
            'call_sign' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ko_units', 'call_sign')
                    ->where(function ($query) {
                        $query->whereNot('call_sign', $this->ko_unit->call_sign);
                    })
                    ->where(function ($query) {
                        $query->where('is_revoked', 0);
                    }),
            ],
            //'identity_number' => 'required|max:191',
            'ko_brand_id' => 'required|max:191',
            'serial_number' => 'required|max:191',
            'production_year' => 'required|max:191',
        ];

        return $rules;
    }

    public function mount($id): void
    {
        $this->ko_unit = KoUnit::findOrFail($id);
        $this->ko_spip_categories = KoSpipCategory::all();
        $this->ko_spip_types = KoSpipType::where('ko_spip_category_id', $this->ko_unit->koSpipUnit->koSpipType->ko_spip_category_id)->get();
        $this->ko_spip_units = KoSpipUnit::where('ko_spip_type_id', $this->ko_unit->koSpipUnit->ko_spip_type_id)->get();

        $this->ko_brands = KoBrand::where('ko_spip_category_id', $this->ko_unit->koSpipUnit->koSpipType->ko_spip_category_id)->get();

        $this->ko_spip_category_id = $this->ko_unit->koSpipUnit->koSpipType->ko_spip_category_id;
        $this->ko_spip_type_id = $this->ko_unit->koSpipUnit->ko_spip_type_id;
        $this->ko_spip_unit_id = $this->ko_unit->ko_spip_unit_id;
        $this->call_sign = $this->ko_unit->call_sign;
        $this->identity_number = $this->ko_unit->identity_number;
        $this->ko_brand_id = $this->ko_unit->ko_brand_id;
        $this->serial_number = $this->ko_unit->serial_number;
        $this->model_unit = $this->ko_unit->model_unit;
        $this->production_year = $this->ko_unit->production_year;
    }

    public function hydrate(): void
    {
        $this->emit('select2');
    }

    public function updatedKoSpipCategoryId()
    {
        $this->ko_spip_types = KoSpipType::where('ko_spip_category_id', $this->ko_spip_category_id)->get();
        $this->ko_brands = KoBrand::where('ko_spip_category_id', $this->ko_spip_category_id)->get();
    }

    public function updatedKoSpipTypeId()
    {
        $this->ko_spip_units = KoSpipUnit::where('ko_spip_type_id', $this->ko_spip_type_id)->get();
    }

    public function store(): bool|RedirectResponse|Redirector
    {
        $this->validate();
        try {
            DB::beginTransaction();

            $this->ko_unit->update([
                'ko_spip_unit_id' => $this->ko_spip_unit_id,
                'call_sign' => $this->call_sign,
                'identity_number' => $this->identity_number,
                'ko_brand_id' => $this->ko_brand_id,
                'serial_number' => $this->serial_number,
                'production_year' => $this->production_year,
                'model_unit' => $this->model_unit
            ]);

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('ko::master-library.unit.index');
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
        return view('ko::livewire.master-library.unit.unit-edit')->extends('ko::layouts.no-header');
    }
}
