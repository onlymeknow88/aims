<?php

namespace Modules\Kplh\Http\Livewire\PJA;

use App\Models\User;
use DB;
use Auth;
use Carbon\Carbon;
use App\Enums\Pica\PicaStatus;
use Illuminate\Support\Facades\Storage;
use Modules\Pica\Entities\PicaDocument;
use App\Enums\PicaSource;
use Livewire\Component;
use Modules\Kplh\Entities\KplhLabel;
use Modules\Kplh\Entities\InspectionData;
use Modules\Kplh\Entities\InspectionRisks;

class DetailApproval extends Component
{
    public $label_id;

    public function mount($id)
    {
        $this->staff = User::find(auth()->user()->id);
        // $this->staff = Employee::where('user_id', auth()->user()->id)->first();
        $this->data = KplhLabel::with('inspection_data', 'inspection_officers')->find($id);
        $this->label_id = $id;

        $this->questions = json_decode(file_get_contents("" . public_path() . "/modules/kplh/question.json"), true);
    }

    public function downloadFile($criteria, $file)
    {
        $check = Storage::disk('local')->exists('/kplh/' . $criteria . '/' . $file);

        if ($check) {
            $file = "" . storage_path('app/kplh/' . $criteria . '/') . "" . $file . "";
            return response()->file($file);
        } else {
            return abort(404);
        }
    }

    public function checkFile($file)
    {
        // $file = storage_path($file);
        $file = Storage::disk('private')->get($file);

        return response()->file($file);
    }

    public function approve()
    {
        DB::beginTransaction();
        $this->data->status = 'approved';
        $this->data->save();

        $picas = false;
        foreach ($this->data->inspection_data as $InspectionData) {

            if ($this->data->inspect_criteria == 'food-hygiene') {
                $InspectionDataValue = $InspectionData->value;
            } elseif ($InspectionData->k3_value_3) {
                $InspectionDataValue = $InspectionData->k3_value_2;
            } else {
                $InspectionDataValue = $InspectionData->k3_value;
            }

            if (isset($InspectionDataValue)) {

                $InspectionData->label_id = $this->data->id;

                if ($this->data->inspect_criteria == 'food-hygiene') {
                    if ($InspectionDataValue < 10) {
                        $pica = $this->toPica($this->data, $InspectionData, $InspectionDataValue);
                        $picas = true;
                    }
                }

                if ($this->data->inspect_criteria == 'workplace' || $this->data->inspect_criteria == 'area-maintank' || $this->data->inspect_criteria == 'area-jetty') {
                    if ($InspectionDataValue == 'Tidak') {
                        $pica = $this->toPica($this->data, $InspectionData, $InspectionDataValue);
                        $picas = true;
                    }
                }

                if ($this->data->inspect_criteria == 'k3-apar' || $this->data->inspect_criteria == 'k3-apab' || $this->data->inspect_criteria == 'k3-hydrant' || $this->data->inspect_criteria == 'k3-hose-rail' || $this->data->inspect_criteria == 'k3-eye-wash') {
                    if ($InspectionDataValue == 'Tidak Standard' || $InspectionDataValue == 'Tidak Ada' || $InspectionDataValue == 'Warna Demarkasi Pudar' || $InspectionDataValue == 'Perlu Penggantian' || $InspectionDataValue == 'Terdapat Penghalang') {
                        $pica = $this->toPica($this->data, $InspectionData, $InspectionDataValue);
                        $picas = true;
                    }
                }

                // END PICA
            }
        }

        if ($picas) {
            $this->data->pica_status = PicaStatus::Open;
            $this->data->save();
        }
        // dd($this->data);
        // dd('stop');
        DB::commit();

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data Inspeksi berhasil disetujui',
        ]);
        redirect()->route('kplh::approval');
    }


    private function toPica($label_store, $InspectionData, $InspectionDataValue)
    {
        // $this->validate([
        //     '' . $InspectionData->criteria . '_file' => 'required',
        //     '' . $InspectionData->criteria . '_note' => 'required',
        // ]);

        $riskCondition = $InspectionData->risks()->create([
            'kplh_data_id' => $InspectionData->id,
            'risk_value' => $InspectionDataValue,
            'risk_condition' => $InspectionData->note,
            'status' => PicaStatus::Open,
        ]);

        $picaDocument = $riskCondition->pica()->create([
            'identity_id' => $this->generateIdentityId($InspectionData->created_at), // new field for pica document

            'source' => PicaSource::InspeksiKPLH, // buat enum
            'type' => $label_store->inspect_criteria,
            'ccow_id' => $label_store->ccow_id,
            'company_id' => $label_store->company_id,
            'section_id' => $label_store->section_id,
            'pja_id' => $label_store->pja_id,
            'pjo_id' => $label_store->ktt_id,

            'auditor' => auth()->user()->name,
            'requested' => PicaStatus::NewRequest, // new field for pica document
            'published' => PicaStatus::Publish, // new field for pica document
            'status' => PicaStatus::Open,
        ]);

        $picaDocument->pica()->create([
            'source' => 'Inspeksi KPLH',
            'source_id' => $riskCondition->id,
            'picaable_id' => $picaDocument->id,
            'picaable_type' => InspectionRisks::class,
        ]);

        if (isset($InspectionData->file)) {
            $picaDocument->picaFiles()->create([
                'file' => $InspectionData->file,
                'size' => null,
                'type' => null,
            ]);
        }

        // create pica activity
        $picaDocument->activities()->create([
            'description' => 'New Request',
            'user_id' => auth()->user()->id,
        ]);

        return $picaDocument;
    }

    public function generateIdentityId($date)
    {
        $count = PicaDocument::count();
        $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $date = Carbon::parse($date)->format('mY');

        $result = 'IN' . $date . '-IN' . $formattedNumber;

        while (PicaDocument::where('identity_id', $result)->exists()) {
            $count++;
            $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
            $result = 'IN' . $date . '-IN' . $formattedNumber;
        }

        return $result;
    }

    public function unapprove()
    {
        DB::beginTransaction();
        $this->data->status = 'unapproved';
        $this->data->save();
        DB::commit();

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data Inspeksi berhasil ditolak',
        ]);

        redirect()->route('kplh::approval');
    }

    public function render()
    {
        return view('kplh::livewire.p-j-a.detail-approval')->extends('kplh::layouts.no-header');
    }
}
