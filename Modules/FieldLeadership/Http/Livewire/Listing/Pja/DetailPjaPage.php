<?php

namespace Modules\FieldLeadership\Http\Livewire\Listing\Pja;

use Carbon\Carbon;
use Livewire\Component;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Enums\PicaSource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Modules\FieldLeadership\Entities\FieldLeadershipMember;
use Modules\FieldLeadership\Entities\FieldLeadershipActivity;
use Modules\FieldLeadership\Entities\FieldLeadershipPositive;
use Modules\FieldLeadership\Entities\FieldLeadershipQuestionPto;
use Livewire\WithFileUploads;
use Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DetailPjaPage extends Component
{
    use WithFileUploads, LivewireAlert;

    public $field;
    public $evidance;
    public $description;
    public $activityFile = [];

    public function mount($id)
    {
        $this->field = FieldLeadership::find($id);
    }

    public function getActivitiesProperty()
    {
        return FieldLeadershipActivity::where('fl_id', $this->field->id)->orderBy('created_at', 'desc')->get();
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

    public function approved()
    {
        try {
            DB::beginTransaction();

            $this->field->update([
                'status' => FieldLeadershipType::OnReviewApproval,
                'requested' => FieldLeadershipType::RequestedApproval
            ]);

            FieldLeadershipActivity::create([
                'fl_id' => $this->field->id,
                'description' => 'Document reviewed and submitted to Approval by Reviewer/PJA ' . Auth::user()->name,
                'user_id' => Auth::user()->employee?->id ?? Auth::user()->id,
            ]);

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('field-leadership::listing.request-review-pja.index');
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);
        }
    }

    public function returnWithComment()
    {
        try {
            DB::beginTransaction();

            $activity = FieldLeadershipActivity::create([
                'fl_id' => $this->field->id,
                'description' => $this->description,
                'user_id' => auth()->user()->id ?? '-',
            ]);

            foreach ($this->activityFile as $key => $value) {
                $filename = $value['file']->getClientOriginalName();
                $filePathTemp = $value['file']->getRealPath();
                $directPath = 'field-leadership/' . $this->field->id . '/activity/' . $activity->id;

                $blobResult = uploadToBlobStorage($filename, $filePathTemp, $directPath);

                $path = $blobResult['fileBlobPathName'] ?? ('field-leadership/' . $this->field->id . '/activity/' . $activity->id . '/' . $filename);
                $blobUrl = $blobResult['fileBlobUrl'] ?? null;
                $blobResponse = $blobResult['blobResponse'] ? json_encode($blobResult['blobResponse']) : null;

                $file = $activity->files()->create([
                    'file' => $path,
                    'blob_url' => $blobUrl,
                    'blob_response' => $blobResponse,
                    'type_file' => $value['file']->getClientOriginalExtension(),
                    'size' => $this->changeByte($value['file']->getSize()),
                ]);
            }

            $this->field->update([
                'status' => FieldLeadershipType::Open,
                'requested' => FieldLeadershipType::Rejected
            ]);

            foreach ($this->field->risks as $key => $value) {
                $picaDocument = $value->pica()->create([
                    'source' => PicaSource::FieldLeadership,
                    'type' => $this->field->type,
                    'date' => Carbon::parse($this->field->date)->format('Y-m-d'),
                    'ccow_id' => $this->field->ccow_id,
                    'company_id' => $this->field->company_id,
                    'section_id' => $this->field->section_id,
                    'location_id' => $this->field->area_location_id,
                    'location_detail' => $this->field->detail_location,
                    'company_detail' => $this->field->detail_company,
                    'pja_id' => $this->field->pja_id,
                    'pjo_id' => $this->field->pjo_id,
                    'auditor' => null,
                    'non_compliance' => null,
                    'non_compliance_root_cause' => $this->field->non_compliance_root,
                    'corrective_action' => $value['action'],
                    'target_settlement_date' => Carbon::parse($value['due_date'])->format('Y-m-d'),
                    'settlement_date' => Carbon::parse($value['due_date'])->format('Y-m-d'),
                    'remarks' => null,
                    'status' => $this->field->status,
                ]);

                $picaDocument->pica()->create([
                    'source' => PicaSource::FieldLeadership,
                    'source_id' => $value->id,
                    'picaable_id' => $picaDocument->id,
                    'picaable_type' => FieldLeadershipRisk::class,
                ]);
            }


            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('field-leadership::listing.request-review-pja.index');
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);
        }
    }

    public function render()
    {
        return view('fieldleadership::livewire.listing.pja.detail-pja-page')->extends('fieldleadership::layouts.no-header');
    }
}
