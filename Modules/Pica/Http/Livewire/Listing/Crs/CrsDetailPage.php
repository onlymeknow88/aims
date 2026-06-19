<?php

namespace Modules\Pica\Http\Livewire\Listing\Crs;

use Storage;
use Livewire\Component;
use App\Enums\PicaSource;
use Livewire\WithFileUploads;
use App\Enums\Pica\PicaStatus;
use Illuminate\Support\Facades\DB;
use Modules\Pica\Entities\PicaActivity;
use Modules\Pica\Entities\PicaDocument;
use Modules\Kplh\Entities\InspectionRisks;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Enums\FieldLeadership\FieldLeadershipType;
use Modules\Audit\Entities\AuditCriteriaNonConfirmance;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Modules\FieldLeadership\Entities\FieldLeadershipActivity;

class CrsDetailPage extends Component
{
    use WithFileUploads, LivewireAlert;

    public $pica;
    public $evidance;
    public $description;
    public $activityFile = [];

    public function mount($id)
    {
        $this->pica = PicaDocument::find($id);
    }

    public function getActivitiesProperty()
    {
        return PicaActivity::where('pica_id', $this->pica->id)->orderBy('created_at', 'desc')->get();
    }

    public function addActivityFile()
    {
        $this->activityFile[] = [
            'file' => $this->evidance[0],
            'name' => $this->evidance[0]->getClientOriginalName(),
            'size' => $this->changeByte($this->evidance[0]->getSize()),
            'extension' => $this->evidance[0]->getClientOriginalExtension(),
        ];
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'evidance') {
            $this->addActivityFile();
        }
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    protected function rules(): array
    {
        return [
            'description' => 'required',
        ];
    }

    public function saved($status)
    {
        $this->validate();

        DB::beginTransaction();

        $this->pica->update([
            'requested' => $status == 'return' ? PicaStatus::ReturnDocument : PicaStatus::RequestedCrs,
        ]);

        $activity = PicaActivity::create([
            'pica_id' => $this->pica->id,
            'description' => $this->description,
            'user_id' => auth()->user()->id ?? '-',
        ]);

        foreach ($this->activityFile as $key => $value) {
            $path = 'pica/activity/' . $this->pica->id;
            $tempPath = $value['file']->getRealPath();
            $blobResult = uploadToBlobStorage($value['name'], $tempPath, $path);

            $file = $activity->files()->create([
                'file' => $blobResult['fileBlobPathName'] ?? ($path . '/' . $value['name']),
                'type_file' => $value['file']->getClientOriginalExtension(),
                'size' => $this->changeByte($value['file']->getSize()),
                'blob_url' => $blobResult['fileBlobUrl'] ?? null,
                'blob_response' => isset($blobResult['blobResponse']) ? json_encode($blobResult['blobResponse']) : null,
            ]);
        }

        // $this->field->update([
        //     'status' => $status == 'return' ?  FieldLeadershipType::Open : FieldLeadershipType::OnReviewPica,
        // ]);

        DB::commit();

        $this->flash('success', 'Data berhasil di simpan!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        return redirect()->route('pica::listing.review-crs.index');
    }

    public function action()
    {
        DB::beginTransaction();

        $activity = PicaActivity::create([
            'pica_id' => $this->pica->id,
            'description' => 'Case Closed',
            'user_id' => auth()->user()->id ?? '-',
        ]);

        $this->pica->update([
            'status' => PicaStatus::Closed,
        ]);

        if ($this->pica->source == PicaSource::FieldLeadership && !empty($this->pica->pica)) {
            $risk = FieldLeadershipRisk::find($this->pica->pica->source_id);

            $risk->update([
                'status' => FieldLeadershipType::Close,
            ]);

            if ($risk->fieldLeadership->risks->count() == $risk->fieldLeadership->risks->where('status', FieldLeadershipType::Close)->count()) {
                $risk->fieldLeadership->update([
                    'status' => FieldLeadershipType::Close,
                ]);
            }
        }

        if ($this->pica->source == PicaSource::InspeksiKPLH && !empty($this->pica->pica)) {
            $risk = InspectionRisks::find($this->pica->pica->source_id);

            $risk->update([
                'status' => 'Close',
            ]);

            if ($risk->kplh_data->label->count() == $risk->kplh_data->label->where('pica_status', 'Close')->count()) {
                $risk->kplh_data->update([
                    'pica_status' => 'Close',
                ]);
            }
        }

        if ($this->pica->source == PicaSource::Audit && !empty($this->pica->pica)) {
            $audit = AuditCriteriaNonConfirmance::find($this->pica->pica->source_id);

            $audit->update([
                'status' => 'Close',
            ]);
        }

        DB::commit();

        $this->flash('success', 'Data berhasil di simpan!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        return redirect()->route('pica::listing.review-crs.index');
    }

    public function render()
    {
        return view('pica::livewire.listing.crs.crs-detail-page')->extends('pica::layouts.no-header');
    }
}
