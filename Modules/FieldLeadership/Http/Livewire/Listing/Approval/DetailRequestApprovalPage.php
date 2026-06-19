<?php

namespace Modules\FieldLeadership\Http\Livewire\Listing\Approval;

use Carbon\Carbon;
use Livewire\Component;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Enums\Pica\PicaStatus;
use App\Enums\PicaSource;
use App\Mail\FieldLeadership\ClosedDocument;
use App\Mail\FieldLeadership\ReturnDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Modules\FieldLeadership\Entities\FieldLeadershipMember;
use Modules\FieldLeadership\Entities\FieldLeadershipActivity;
use Modules\FieldLeadership\Entities\FieldLeadershipPositive;
use Modules\FieldLeadership\Entities\FieldLeadershipQuestionPto;
use Livewire\WithFileUploads;
use Mail;
use Modules\Pica\Entities\PicaDocument;
use Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DetailRequestApprovalPage extends Component
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
                'status' => FieldLeadershipType::Close,
                'requested' => FieldLeadershipType::Approved
            ]);

            FieldLeadershipActivity::create([
                'fl_id' => $this->field->id,
                'description' => 'Field Leadership Case Closed',
                'user_id' => Auth::user()->employee?->id,
            ]);

            DB::commit();

            // Mail::to($this->field->createdBy->user->email)->send(new ClosedDocument($this->field));

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('field-leadership::listing.request-review-reviewer.index');
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
                    'identity_id' => $this->generateIdentityId($this->field->created_at), // new field for pica document
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
                    'auditor' => auth()->user()->name,
                    'non_compliance' => null,
                    'non_compliance_root_cause' => $this->field->non_compliance_root,
                    'corrective_action' => $value['action'],
                    'target_settlement_date' => Carbon::parse($value['due_date'])->format('Y-m-d'),
                    'settlement_date' => Carbon::parse($value['due_date'])->format('Y-m-d'),
                    'remarks' => null,
                    'requested' => PicaStatus::NewRequest, // new field for pica document
                    'published' => PicaStatus::Publish, // new field for pica document
                    'status' => $this->field->status,
                ]);

                // create pica morph
                $picaDocument->pica()->create([
                    'source' => PicaSource::FieldLeadership,
                    'source_id' => $value->id,
                    'picaable_id' => $picaDocument->id,
                    'picaable_type' => FieldLeadershipRisk::class,
                ]);

                // create pica file from module
                foreach ($value->files as $key => $file) {
                    $picaDocument->picaFiles()->create([
                        'file' => $file->file,
                        'size' => $file->size,
                        'type' => FieldLeadershipType::RiskFinding
                    ]);
                }

                // create pica activity
                $picaDocument->activities()->create([
                    'description' => 'New Request',
                    'user_id' => Auth::user()->id,
                ]);


                // Mail::to($this->field->pja->user->email)->send(new ReturnDocument($this->field));
            }


            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('field-leadership::listing.active.detail', $this->field->id);
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);
        }
    }

    public function generateIdentityId($date)
    {
        $count = PicaDocument::count();
        $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $date = Carbon::parse($date)->format('mY');

        $result = 'FL' . $date . '-FL' . $formattedNumber;

        while (PicaDocument::where('identity_id', $result)->exists()) {
            $count++;
            $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
            $result = 'FL' . $date . '-FL' . $formattedNumber;
        }

        return $result;
    }

    public function render()
    {
        return view('fieldleadership::livewire.listing.approval.detail-review-page')->extends('fieldleadership::layouts.no-header');
    }
}
