<?php

namespace Modules\Kplh\Http\Livewire\K3\Hydrant;

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

class Edit extends Component
{
    use WithFileUploads;

    public $mode, $date, $ccow, $ccow_id, $companyId, $departmentId, $sectionId, $area_location_id, $detail_location, $kttId, $pjaId;
    public $inspectionOfficer = [];
    public $companyType = null;

    public $tool_type, $tool_id, $tool_type_detail;
    public $ukuran_coupling, $ukuran_coupling_2, $ukuran_coupling_3, $ukuran_coupling_file, $ukuran_coupling_note, $outer_pilar, $outer_pilar_file, $outer_pilar_note;
    public $hose_hydrant, $hose_hydrant_2, $hose_hydrant_3, $hose_hydrant_file, $hose_hydrant_note;
    public $ukuran_hose, $ukuran_hose_file, $ukuran_hose_note;
    public $type_nozzle, $type_nozzle_2, $type_nozzle_3, $type_nozzle_file, $type_nozzle_note;
    public $box_hydrant, $box_hydrant_2, $box_hydrant_file, $box_hydrant_note;
    public $penempatan, $penempatan_file, $penempatan_note;
    public $kip, $kip_2, $kip_file, $kip_note;
    public $label_penanda, $label_penanda_file, $label_penanda_note;
    public $demarkasi, $demarkasi_file, $demarkasi_note;
    public $velve_pipa, $velve_pipa_2, $velve_pipa_file, $velve_pipa_note;

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

    public function mount($id)
    {
        $this->kplh = KplhLabel::find($id);

        $this->date = Carbon::parse($this->kplh->date)->format('F d, Y');
        $this->ccow_id = $this->kplh->ccow_id;
        $this->pjaId = $this->kplh->pja_id;
        $this->kttId = $this->kplh->ktt_id;
        $this->company = Company::find($this->kplh->company_id);
$this->companyId = $this->kplh->company_id;
        $this->ccow = Company::find($this->ccow_id);
        $this->departmentId = $this->kplh->department_id;
        $this->sectionId = $this->kplh->section_id;
        $this->area_location_id = $this->kplh->area_location_id;
        $this->detail_location = $this->kplh->location_detail;
        $this->summary = $this->kplh->summary;

        $this->tool_type = $this->kplh->tool_type;
        $this->tool_id = $this->kplh->tool_id;

        $inspectionOfficer = [];
        foreach ($this->kplh->inspection_officers as $io) {
            if ($io->label_id == $id) {
                $inspectionOfficer[] = $io->employee_id;
            }
        }

        $this->inspectionOfficer = $inspectionOfficer;

        foreach ($this->kplh->inspection_data as $ins) {
            if ($ins->criteria == 'ukuran_coupling') {
                $this->ukuran_coupling = $ins->k3_value;
                $this->ukuran_coupling_2 = $ins->k3_value_2;
                $this->ukuran_coupling_3 = $ins->k3_value_3;
                $this->ukuran_coupling_file = $ins->file;
                $this->ukuran_coupling_note = $ins->note;
            }
            if ($ins->criteria == 'outer_pilar') {
                $this->outer_pilar = $ins->k3_value;
                $this->outer_pilar_file = $ins->file;
                $this->outer_pilar_note = $ins->note;
            }
            if ($ins->criteria == 'hose_hydrant') {
                $this->hose_hydrant = $ins->k3_value;
                $this->hose_hydrant_2 = $ins->k3_value_2;
                $this->hose_hydrant_3 = $ins->k3_value_3;
                $this->hose_hydrant_file = $ins->file;
                $this->hose_hydrant_note = $ins->note;
            }
            if ($ins->criteria == 'ukuran_hose') {
                $this->ukuran_hose = $ins->k3_value;
                $this->ukuran_hose_file = $ins->file;
                $this->ukuran_hose_note = $ins->note;
            }
            if ($ins->criteria == 'type_nozzle') {
                $this->type_nozzle = $ins->k3_value;
                $this->type_nozzle_2 = $ins->k3_value_2;
                $this->type_nozzle_3 = $ins->k3_value_3;
                $this->type_nozzle_file = $ins->file;
                $this->type_nozzle_note = $ins->note;
            }
            if ($ins->criteria == 'box_hydrant') {
                $this->box_hydrant = $ins->k3_value;
                $this->box_hydrant_2 = $ins->k3_value_2;
                $this->box_hydrant_file = $ins->file;
                $this->box_hydrant_note = $ins->note;
            }
            if ($ins->criteria == 'penempatan') {
                $this->penempatan = $ins->k3_value;
                $this->penempatan_file = $ins->file;
                $this->penempatan_note = $ins->note;
            }
            if ($ins->criteria == 'kip') {
                $this->kip = $ins->k3_value;
                $this->kip_2 = $ins->k3_value_2;
                $this->kip_file = $ins->file;
                $this->kip_note = $ins->note;
            }
            if ($ins->criteria == 'label_penanda') {
                $this->label_penanda = $ins->k3_value;
                $this->label_penanda_file = $ins->file;
                $this->label_penanda_note = $ins->note;
            }
            if ($ins->criteria == 'demarkasi') {
                $this->demarkasi = $ins->k3_value;
                $this->demarkasi_file = $ins->file;
                $this->demarkasi_note = $ins->note;
            }
            if ($ins->criteria == 'velve_pipa') {
                $this->velve_pipa = $ins->k3_value;
                $this->velve_pipa_2 = $ins->k3_value_2;
                $this->velve_pipa_file = $ins->file;
                $this->velve_pipa_note = $ins->note;
            }
        }
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

    public function getEmployeesProperty()
    {
        return Employee::get();
    }

    public function setFileNull($criteriaFileName)
    {
        $this->{$criteriaFileName} = null;
    }

    public function cancelFileNull($criteriaName, $criteriaFileName)
    {
        foreach ($this->kplh->inspection_data as $inspection_data) {
            if ($inspection_data->criteria == $criteriaName) {
                $this->{$criteriaFileName} = $inspection_data->file;
            }
        }
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
                    'tool_type' => 'required',
                    'tool_id' => 'required',

                    'ukuran_coupling' => 'required',
                    'outer_pilar' => 'required',
                    'hose_hydrant' => 'required',
                    'ukuran_hose' => 'required',
                    'type_nozzle' => 'required',
                    'box_hydrant' => 'required',
                    'penempatan' => 'required',
                    'kip' => 'required',
                    'label_penanda' => 'required',
                    'demarkasi' => 'required',
                    'velve_pipa' => 'required',
                ]);
                $status = 'active';
            }

            DB::beginTransaction();

            $count_label = KplhLabel::withTrashed()->count();
            $date = Carbon::parse($this->date);

            $this->kplh->update([
                'maker_id' => Auth::user()->id,
                'date' => $date,
                'ccow_id' => $this->ccow_id,
                'company_id' => $this->companyId,
                'department_id' => $this->departmentId,
                'section_id' => $this->sectionId,
                'area_location_id' => $this->area_location_id,
                'location_detail' => $this->detail_location,
                'ktt_id' => $this->kttId,
                'pja_id' => $this->pjaId,
                'status' => $status,
                'summary' => $this->summary,

                'tool_type' => $this->tool_type,
                'tool_id' => $this->tool_id,
            ]);

            if (!empty($this->inspectionOfficer)) {
                $label_io = $this->kplh->inspection_officers;

                foreach ($label_io as $lio) {
                    $x = KplhLabelIO::find($lio->id)->delete();
                }

                foreach ($this->inspectionOfficer as $io) {
                    $labeliodata = [
                        'label_id' => $this->kplh->id,
                        'employee_id' => $io,
                    ];
                    $label_io_store = KplhLabelIO::create($labeliodata);
                }
            }

            $InspectionDatas = [
                [
                    'criteria' => 'ukuran_coupling',
                    'k3_value' => $this->ukuran_coupling,
                    'k3_value_2' => $this->ukuran_coupling_2,
                    'k3_value_3' => $this->ukuran_coupling_3,
                    'note' => $this->ukuran_coupling_note,
                ],
                [
                    'criteria' => 'outer_pilar',
                    'k3_value' => $this->outer_pilar,
                    'note' => $this->outer_pilar_note,
                ],
                [
                    'criteria' => 'hose_hydrant',
                    'k3_value' => $this->hose_hydrant,
                    'k3_value_2' => $this->hose_hydrant_2,
                    'k3_value_3' => $this->hose_hydrant_3,
                    'note' => $this->hose_hydrant_note,
                ],
                [
                    'criteria' => 'ukuran_hose',
                    'k3_value' => $this->ukuran_hose,
                    'note' => $this->ukuran_hose_note,
                ],
                [
                    'criteria' => 'type_nozzle',
                    'k3_value' => $this->type_nozzle,
                    'k3_value_2' => $this->type_nozzle_2,
                    'k3_value_3' => $this->type_nozzle_3,
                    'note' => $this->type_nozzle_note,
                ],
                [
                    'criteria' => 'box_hydrant',
                    'k3_value' => $this->box_hydrant,
                    'k3_value_2' => $this->box_hydrant_2,
                    'note' => $this->box_hydrant_note,
                ],
                [
                    'criteria' => 'penempatan',
                    'k3_value' => $this->penempatan,
                    'note' => $this->penempatan_note,
                ],
                [
                    'criteria' => 'kip',
                    'k3_value' => $this->kip,
                    'k3_value_2' => $this->kip_2,
                    'note' => $this->kip_note,
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
                    'criteria' => 'velve_pipa',
                    'k3_value' => $this->velve_pipa,
                    'k3_value_2' => $this->velve_pipa_2,
                    'note' => $this->velve_pipa_note,
                ],
            ];

            foreach ($InspectionDatas as $InspectionData) {
                if (isset($InspectionData['k3_value'])) {

                    $InspectionData['label_id'] = $this->kplh->id;

                    if ($this->{$InspectionData['criteria'] . '_file'} && ($this->{$InspectionData['criteria'] . '_file'} != '') && !is_string($this->{$InspectionData['criteria'] . '_file'})) {
                        $filetype = pathinfo($this->{$InspectionData['criteria'] . '_file'}->path(), PATHINFO_EXTENSION);
                        $file_name = "" . $this->kplh->id . "-" . $InspectionData['criteria'] . "_file.$filetype";
                        $this->{$InspectionData['criteria'] . '_file'}->storeAs('kplh/k3', $file_name, ['disk' => 'local']);
                        $InspectionData['file'] = $file_name;
                    } else {
                        $InspectionData['file'] = $this->{$InspectionData['criteria'] . '_file'};
                    }

                    $kplh_data = InspectionData::where('label_id', $this->kplh->id)->where('criteria', $InspectionData['criteria'])->first();

                    if ($kplh_data) {
                        $kplh_data->update($InspectionData);
                    } else {
                        $kplh_data = InspectionData::create($InspectionData);
                    }

                    // PICA
                    if ($status != 'draft') {
                        if (($InspectionData['k3_value'] == 'Tidak Standard' ||
                            $InspectionData['k3_value'] == 'Tidak Ada' ||
                            $InspectionData['k3_value'] == 'Warna Demarkasi Pudar' ||
                            $InspectionData['k3_value'] == 'Perlu Penggantian' ||
                            $InspectionData['k3_value'] == 'Terdapat Penghalang')) {
                            if (!$kplh_data->file) {
                                $this->validate([
                                    '' . $kplh_data->criteria . '_file' => 'required',
                                ]);
                            }

                            $this->validate([
                                '' . $kplh_data->criteria . '_note' => 'required',
                            ]);

                            // $riskCondition = $kplh_data->risks()->create([
                            //     'kplh_data_id' => $kplh_data->id,
                            //     'risk_k3_value' => $kplh_data->k3_value,
                            //     'risk_condition' => $kplh_data->note,
                            // ]);

                            // $picaDocument = $riskCondition->pica()->create([
                            //     'source' => PicaSource::InspeksiKPLH, // buat enum
                            //     'type' => 'k3-hydrant',
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
                        } elseif (in_array('k3_value_2', $InspectionData)) {
                            if ($InspectionData['k3_value_2'] == 'Tidak Standard') {

                                if (!$kplh_data->file) {
                                    $this->validate([
                                        '' . $kplh_data->criteria . '_file' => 'required',
                                    ]);
                                }

                                $this->validate([
                                    '' . $kplh_data->criteria . '_note' => 'required',
                                ]);

                                // $riskCondition = $kplh_data->risks()->create([
                                //     'kplh_data_id' => $kplh_data->id,
                                //     'risk_k3_value' => $kplh_data->k3_value_2,
                                //     'risk_condition' => $kplh_data->note,
                                // ]);

                                // $picaDocument = $riskCondition->pica()->create([
                                //     'source' => PicaSource::InspeksiKPLH, // buat enum
                                //     'type' => 'k3-hydrant',
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
                        }
                    }
                    // END PICA

                }
            }

            if ($this->mode == 'save') {
                $sendmail = Mail::to($this->kplh->pja->user->email)->send(new RequestApprovalPJA($this->kplh));
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
        return view('kplh::livewire.k3.hydrant.edit')->extends('kplh::layouts.no-header');
    }
}
