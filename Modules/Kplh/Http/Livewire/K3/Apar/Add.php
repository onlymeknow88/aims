<?php

namespace Modules\Kplh\Http\Livewire\K3\Apar;

use App\Enums\CompanyType;
use App\Enums\PicaSource;
use App\Mail\kplh\RequestApprovalPJA;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;
use Modules\Kplh\Entities\InspectionData;
use Modules\Kplh\Entities\InspectionRisks;
use Modules\Kplh\Entities\KplhLabel;
use Modules\Kplh\Entities\KplhLabelIO;

class Add extends Component
{
    use WithFileUploads;

    public $mode, $date, $ccow, $ccow_id, $companyId, $departmentId, $sectionId, $area_location_id, $detail_location, $kttId, $pjaId;
    public $inspectionOfficer = [];
    public $companyType = null;

    public $tool_type, $tool_id, $tool_date;
    public $isi_apar, $isi_apar_file, $isi_apar_note, $gol_apar, $gol_apar_file, $gol_apar_note;
    public $kapasitas_apar, $kapasitas_apar_file, $kapasitas_apar_note;
    public $tuas_apar, $tuas_apar_2, $tuas_apar_file, $tuas_apar_note;
    public $handle_apar, $handle_apar_2, $handle_apar_file, $handle_apar_note;
    public $pressure_gauge, $pressure_gauge_2, $pressure_gauge_file, $pressure_gauge_note;
    public $pin_apar, $pin_apar_2, $pin_apar_file, $pin_apar_note;
    public $hose_apar, $hose_apar_2, $hose_apar_file, $hose_apar_note;
    public $nozzle_apar, $nozzle_apar_2, $nozzle_apar_file, $nozzle_apar_note;
    public $kondisi_tabung, $kondisi_tabung_2, $kondisi_tabung_file, $kondisi_tabung_note;
    public $cat_tabung, $cat_tabung_2, $cat_tabung_file, $cat_tabung_note;
    public $powder, $powder_2, $powder_file, $powder_note;
    public $kip, $kip_2, $kip_file, $kip_note;
    public $bracket, $bracket_2, $bracket_file, $bracket_note;
    public $label_penanda, $label_penanda_file, $label_penanda_note;
    public $demarkasi, $demarkasi_file, $demarkasi_note;
    public $kain_pelindung, $kain_pelindung_file, $kain_pelindung_note;
    public $kondisi_kain, $kondisi_kain_file, $kondisi_kain_note;
    public $penempatan, $penempatan_2, $penempatan_file, $penempatan_note;

    public $summary;

    protected $messages = [
        'date.required' => 'Tanggal inspeksi harus diisi',
        'ccow_id.required' => 'Harus pilih salah satu CCOW',
        'companyId.required' => 'Harus pilih salah satu perusahaan',
        'departmentId.required' => 'Harus pilih salah satu departemen',
        'area_location_id.required' => 'Harus pilih salah satu lokasi',
        'kttId.required' => 'Harus pilih salah satu KTT',
        'pjaId.required' => 'Harus pilih salah satu PJA',
        'inspectionOfficer.required' => 'Petugas Inspeksi Wajib diisi',
    ];

    public function mount()
    {
    }

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

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'ccow_id') {
            $this->ccow = Company::find($value);
            // $this->kttId = $this->ccow->user_id;

            $this->employees = Employee::where(function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->whereHas('department', function ($query) {
                        $query->where('company_id', $this->ccow_id);
                    });
                });
            })->get();
        }

        if ($propertyName == 'companyId') {
            $this->company = Company::find($value);
            $this->kttId = $this->company->user_id;
        }
    }

    public function getCompaniesProperty()
    {
        return Company::all();
    }

    public function getDepartmentsProperty()
    {
        return Department::where('company_id', $this->ccow_id)->get();
    }

    public function updateddepartmentId()
    {
        $this->sections = Section::where('department_id', $this->departmentId)->get();
    }

    public function getSectionsProperty()
    {
        return Section::where('department_id', $this->departmentId)->get();
    }

    public function getAreaLocationsProperty()
    {
        return AreaLocation::where('section_id', $this->sectionId)->get();
    }

    public function getAreaManagersProperty()
    {
        return AreaManager::where('section_id', $this->sectionId)->get();
    }

    public function addInspectionOfficer($employee_id)
    {
        if (in_array($employee_id, $this->inspectionOfficer)) {
            $this->alert('warning', 'Petugas sudah dipilih.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
            $this->emit('clearInspectionOfficerInput');
        } else {
            $this->inspectionOfficer[] = $employee_id;
            $this->emit('clearInspectionOfficerInput');
        }
    }

    public function getEmployeesProperty()
    {
        return Employee::get();
    }

    public function save()
    {
        try {
            $this->validate([
                'date' => 'required',
                'ccow_id' => 'required',
                'companyId' => 'required',
                'departmentId' => 'required',
                'area_location_id' => 'required',
                'detail_location' => 'required',
                'kttId' => 'required',
                'pjaId' => 'required',
                'inspectionOfficer' => 'required',
            ]);

            if ($this->mode == 'draft') {
                $status = 'draft';
            } elseif ($this->mode == 'save') {
                $this->validate([
                    'tool_id' => 'required',
                    'tool_date' => 'required',

                    'isi_apar' => 'required',
                    'gol_apar' => 'required',
                    'kapasitas_apar' => 'required',
                    'tuas_apar' => 'required',
                    'handle_apar' => 'required',
                    'pressure_gauge' => 'required',
                    'pin_apar' => 'required',
                    'hose_apar' => 'required',
                    'nozzle_apar' => 'required',
                    'kondisi_tabung' => 'required',
                    'cat_tabung' => 'required',
                    'powder' => 'required',
                    'kip' => 'required',
                    'bracket' => 'required',
                    'label_penanda' => 'required',
                    'demarkasi' => 'required',
                    'kain_pelindung' => 'required',
                    'kondisi_kain' => 'required',
                    'penempatan' => 'required',
                ]);
                $status = 'active';
            }

            DB::beginTransaction();

            $count_label = KplhLabel::withTrashed()->count();
            $date = Carbon::parse($this->date);

            $inspect_id = 'INSP-ALK3-' . $date->format('dmY') . '-' . (sprintf("%06d", ($count_label + 1))) . '';

            $labeldata = [
                'company_id' => $this->companyId,
                'department_id' => $this->departmentId,
                'section_id' => $this->sectionId,
                'maker_id' => Auth::user()->id,
                'inspect_id' => $inspect_id,
                'inspect_criteria' => 'k3-apar',
                'ccow_id' => $this->ccow_id,
                'date' => $date,
                'area_location_id' => $this->area_location_id,
                'location_detail' => $this->detail_location,
                'ktt_id' => $this->kttId,
                'pja_id' => $this->pjaId,
                'status' => $status,
                'summary' => $this->summary,

                'tool_id' => $this->tool_id,
                'tool_date' => $this->tool_date,
            ];

            $label_store = KplhLabel::create($labeldata);

            if (!empty($this->inspectionOfficer)) {
                foreach ($this->inspectionOfficer as $io) {
                    $labeliodata = [
                        'label_id' => $label_store->id,
                        'employee_id' => $io,
                    ];
                    $label_io_store = KplhLabelIO::create($labeliodata);
                }
            } else {
                $inspectionOfficer = null;
            }

            $InspectionDatas = [
                [
                    'criteria' => 'isi_apar',
                    'k3_value' => $this->isi_apar,
                    'note' => $this->isi_apar_note,
                ],
                [
                    'criteria' => 'gol_apar',
                    'k3_value' => $this->gol_apar,
                    'note' => $this->gol_apar_note,
                ],
                [
                    'criteria' => 'kapasitas_apar',
                    'k3_value' => $this->kapasitas_apar,
                    'note' => $this->kapasitas_apar_note,
                ],
                [
                    'criteria' => 'tuas_apar',
                    'k3_value' => $this->tuas_apar,
                    'k3_value_2' => $this->tuas_apar_2,
                    'note' => $this->tuas_apar_note,
                ],
                [
                    'criteria' => 'handle_apar',
                    'k3_value' => $this->handle_apar,
                    'k3_value_2' => $this->handle_apar_2,
                    'note' => $this->handle_apar_note,
                ],
                [
                    'criteria' => 'pressure_gauge',
                    'k3_value' => $this->pressure_gauge,
                    'k3_value_2' => $this->pressure_gauge_2,
                    'note' => $this->pressure_gauge_note,
                ],
                [
                    'criteria' => 'pin_apar',
                    'k3_value' => $this->pin_apar,
                    'k3_value_2' => $this->pin_apar_2,
                    'note' => $this->pin_apar_note,
                ],
                [
                    'criteria' => 'hose_apar',
                    'k3_value' => $this->hose_apar,
                    'k3_value_2' => $this->hose_apar_2,
                    'note' => $this->hose_apar_note,
                ],
                [
                    'criteria' => 'nozzle_apar',
                    'k3_value' => $this->nozzle_apar,
                    'k3_value_2' => $this->nozzle_apar_2,
                    'note' => $this->nozzle_apar_note,
                ],
                [
                    'criteria' => 'kondisi_tabung',
                    'k3_value' => $this->kondisi_tabung,
                    'k3_value_2' => $this->kondisi_tabung_2,
                    'note' => $this->kondisi_tabung_note,
                ],
                [
                    'criteria' => 'cat_tabung',
                    'k3_value' => $this->cat_tabung,
                    'k3_value_2' => $this->cat_tabung_2,
                    'note' => $this->cat_tabung_note,
                ],
                [
                    'criteria' => 'powder',
                    'k3_value' => $this->powder,
                    'k3_value_2' => $this->powder_2,
                    'note' => $this->powder_note,
                ],
                [
                    'criteria' => 'kip',
                    'k3_value' => $this->kip,
                    'k3_value_2' => $this->kip_2,
                    'note' => $this->kip_note,
                ],
                [
                    'criteria' => 'bracket',
                    'k3_value' => $this->bracket,
                    'k3_value_2' => $this->bracket_2,
                    'note' => $this->bracket_note,
                ],
                [
                    'criteria' => 'label_penanda',
                    'k3_value' => $this->label_penanda,
                    'note' => $this->label_penanda_note,
                ],
                [
                    'criteria' => 'demarkasi',
                    'k3_value' => $this->demarkasi,
                    'note' => $this->demarkasi_note,
                ],
                [
                    'criteria' => 'kain_pelindung',
                    'k3_value' => $this->kain_pelindung,
                    'note' => $this->kain_pelindung_note,
                ],
                [
                    'criteria' => 'kondisi_kain',
                    'k3_value' => $this->kondisi_kain,
                    'note' => $this->kondisi_kain_note,
                ],
                [
                    'criteria' => 'penempatan',
                    'k3_value' => $this->penempatan,
                    'k3_value_2' => $this->penempatan_2,
                    'note' => $this->penempatan_note,
                ],
            ];

            $i = -1;
            foreach ($InspectionDatas as $InspectionData) {
                $i++;
                if (isset($InspectionData['k3_value'])) {

                    $InspectionData['label_id'] = $label_store->id;

                    if ($this->{$InspectionData['criteria'] . '_file'} && !is_string($this->{$InspectionData['criteria'] . '_file'})) {
                        $filetype = pathinfo($this->{$InspectionData['criteria'] . '_file'}->path(), PATHINFO_EXTENSION);
                        $file_name = "" . $label_store->id . "-" . $InspectionData['criteria'] . "_file.$filetype";
                        $this->{$InspectionData['criteria'] . '_file'}->storeAs('kplh/k3', $file_name, ['disk' => 'local']);
                        $InspectionData['file'] = $file_name;
                    } else {
                        $InspectionData['file'] = null;
                    }

                    $kplh_data = InspectionData::create($InspectionData);

                    // PICA
                    if ($status != 'draft' && ($InspectionData['k3_value'] == 'Tidak Standard' || $InspectionData['k3_value'] == 'Tidak Ada' || $InspectionData['k3_value'] == 'Warna Demarkasi Pudar' || $InspectionData['k3_value'] == 'Perlu Penggantian' || $InspectionData['k3_value'] == 'Terdapat Penghalang')) {
                        $this->validate([
                            '' . $kplh_data->criteria . '_file' => 'required',
                            '' . $kplh_data->criteria . '_note' => 'required',
                        ]);

                        // $riskCondition = $kplh_data->risks()->create([
                        //     'kplh_data_id' => $kplh_data->id,
                        //     'risk_k3_value' => $kplh_data->k3_value,
                        //     'risk_condition' => $kplh_data->note,
                        // ]);

                        // $picaDocument = $riskCondition->pica()->create([
                        //     'source' => PicaSource::InspeksiKPLH,
                        //     'type' => 'k3-apar',
                        //     'ccow_id' => $this->ccow_id,
                        //     'company_id' => $this->companyId,
                        //     'section_id' => $this->sectionId,
                        //     'pja_id' => $this->pjaId,
                        //     'pjo_id' => $this->kttId,
                        // ]);

                        // $picaDocument->pica()->create([
                        //     'source' => 'Inspeksi KPLH',
                        //     'source_id' => $riskCondition->id,
                        //     'picaable_id' => $picaDocument->id,
                        //     'picaable_type' => InspectionRisks::class,
                        // ]);

                        // if (isset($kplh_data->file)) {
                        //     $picaDocument->picaFiles()->create([
                        //         'file' => $kplh_data->file,
                        //         'size' => null,
                        //         'type' => null,
                        //     ]);
                        // }
                    }
                    // END PICA

                }
            }

            if ($this->mode == 'save') {
                $sendmail = Mail::to($label_store->pja->user->email)->send(new RequestApprovalPJA($label_store));
            }

            DB::commit();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data Inspeksi berhasil di simpan',
            ]);

            session()->flash('msg', __('Data Inspeksi Tersimpan'));
            session()->flash('alert', 'success');
            redirect()->route('kplh::lists');

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('kplh::livewire.k3.apar.add')->extends('kplh::layouts.no-header');
    }
}
