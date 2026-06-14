<?php

namespace Modules\DocumentSystem\Http\Livewire\Ptw;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Jobs\ActiveDocumentJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Modules\DocumentSystem\Services\JsaService;
use Modules\DocumentSystem\Services\PtwService;
use Modules\DocumentSystem\Entities\PtwDocument;
use Modules\DocumentSystem\Entities\ActivityAttachment;
use Modules\DocumentSystem\Entities\PtwDocumentAttachment;
use Modules\DocumentSystem\Services\DocumentSystemService;

class Detail extends Component
{
    use WithFileUploads, LivewireAlert;

    public $id_maker;
    public $tmp = [];
    public $saveFileUrl;
    public $currentUrlType;
    public $detailActivity = null;

    // models
    public $revision_reason;
    public $new_detail_location;
    public $revision_proof = [];
    public $file_revision;

    protected $listeners = ['submitDocument', 'submitRootingApproval', 'updateDocument', 'submitChangeStatus'];

    public function mount($id, $type)
    {
        $this->id_maker = $id;
        $this->currentUrlType = $type;
        $this->saveFileUrl = route('document-systems::maker.revision.upload-file', $this->id_maker);
    }

    public function render()
    {
        $service = new PtwService();

        $detail = $service->detail($this->id_maker);
        $attachments = $detail['attachments'];
        $activities = $detail['activities'];
        $detail = $detail['detail'];

        $image_media = [];
        $file_media = [];
        if (count($activities) > 0) {
            foreach ($activities as $activity) {
                $act_media = $activity->attachments;
            }
        }

        if ($this->currentUrlType == 'obsolate') {
            $back_url = route('document-systems::jsa.obsolate');
        } else if ($this->currentUrlType == 'active-document') {
            $back_url = route('document-systems::ptw.active');
        } else if ($this->currentUrlType == 'draft') {
            $back_url = route('document-systems::jsa.draft');
        }

        return view('documentsystem::livewire.ptw.detail', compact('detail', 'attachments', 'activities', 'image_media', 'file_media', 'back_url'))
            ->extends('documentsystem::layouts.no-header');
    }

    /**
     * Function to stored selected image to public variable
     */
    public function createdFiles($files)
    {
        if (!$files['error']) {
            $current = $this->tmp;
            array_push($current, $files['data']);
            $this->tmp = $current;
        } else {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => 'Failed to upload file'
            ]);
        }
    }

    /**
     * Function to save temporary file
     */
    public function saveFile(Request $request)
    {
        $service = new JsaService();
        $upload = $service->temporary_upload($request);

        return response()->json($upload);
    }

    /**
     * Function to save temporary file
     */
    public function uploadTmpFile(Request $request)
    {
        $service = new JsaService();
        $upload = $service->temporary_upload($request);

        return response()->json($upload);
    }

    /**
     * Function delete proof image
     */
    public function deleteProof($name)
    {
        $tmp = collect($this->tmp)->filter(function ($item) use ($name) {
            return $item['name'] != $name;
        })->values()->toArray();
        $this->tmp = $tmp;

        if (File::exists(public_path('storage/tmp/document_systems/' . $name))) {
            File::delete(public_path('storage/tmp/document_systems/' . $name));
        }
    }

    /**
     * Function to remove attachment in renew document action
     * @param $filename
     * @param $id_media
     * @return void
     */
    public function removeFile($filename, $id_media = null)
    {

        $current = $this->tmp;
        $names = collect($current)->pluck('name')->all();
        if (in_array($filename, $names)) {
            if (File::exists(public_path('storage/tmp/jsa/' . $filename))) {
                File::delete(public_path('storage/tmp/jsa/' . $filename));

                $new = collect($current)->filter(function ($item) use ($filename) {
                    return $item['name'] != $filename;
                })->all();

                $this->tmp = $new;
            }

            if ($id_media) {
                $new = collect($current)->filter(function ($item) use ($filename) {
                    return $item['name'] != $filename;
                })->all();

                $this->tmp = $new;
            }
        }
    }

    /**
     * Function to submit revision action
     */
    public function return()
    {
        if (count($this->tmp) > 0) {
            $this->revision_proof = $this->tmp;
        }
        $this->validate([
            'revision_reason' => 'required',
            'revision_proof' => 'required',
        ], [
            '*.required' => 'The :attribute field is required',
        ]);

        DB::beginTransaction();
        try {
            $payload = [
                'reason' => $this->revision_reason,
                'proofs' => $this->revision_proof,
                'id' => $this->id_maker,
            ];
            $service = new DocumentSystemService();
            $upload = $service->return($payload);
            DB::commit();
            $this->dispatchBrowserEvent('close-modal-revision');

            return $this->flash('success', trans('global.success_return_document'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => env('APP_ENV') == 'local' ? $th->getMessage() : trans('global.failed_return_document'),
            ]);
        }
    }

    /**
     * Function to submit document to rooting approval
     */
    public function submitRootingApproval()
    {
        $service = new DocumentSystemService();
        $service->submit_rooting_approval($this->id_maker);

        $this->flash('success', trans('global.success_process_rooting_approval'), [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        return redirect()->route('document-systems::maker');
    }

    /**
     * Function to approve final document
     */
    public function submitDocument()
    {
        DB::beginTransaction();
        try {
            $service = new DocumentSystemService();
            $service->submit_document($this->id_maker);
            DB::commit();
            ActiveDocumentJob::dispatch($this->id_maker);

            $this->flash('success', trans('global.success_approved_document'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('document-systems::maker');
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->dispatchBrowserEvent('swal', [
                'icon' => 'error',
                'title' => 'Failed',
                // 'text' => env('APP_ENV') == 'local' ? $th->getMessage() . ' ' . $th->getLine() : 'Failed to update document',
                'text' => $th->getMessage() . ' ' . $th->getLine() . 'Failed to update document',
            ]);
        }
    }

    /**
     * Function to show detail media
     */
    public function detailItem($id)
    {
        $data = ActivityAttachment::with([
            'activity:id,document_id',
            'activity.document:id'
        ])->find($id);

        $path =  asset('storage/document_systems/' . $data->activity->document->id . '/revision/' . $data->name);
        return $this->dispatchBrowserEvent('detail-media', $path);
    }

    /**
     * Function to show detail attachments
     */
    public function detailAttachment($id)
    {
        $data = PtwDocumentAttachment::select('file_name', 'document_id')
            ->find($id);
        $path = asset('storage/ptw/' . $data->document_id . '/' . $data->file_name);
        return $this->dispatchBrowserEvent('detail-media', $path);
    }

    /**
     * Function to show popup confirmation via javascript
     */
    public function confirmRooting($type)
    {
        if ($type == 'final') {
            $textConfirm = trans('global.confirm_finalize_document');
        } else {
            $textConfirm = trans('global.confirm_rooting_approval');
        }

        $this->alert('question', 'Are You Sure ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'confirmButtonColor' => '#00552F',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#d33',
            'timer' => 30000,
            'toast' => true,
            'timerProgressBar' => true,
            'position' => 'center',
            'text' => $textConfirm,
            'onConfirmed' => $type == 'final' ? 'submitDocument' : 'submitRootingApproval',
        ]);
        // return $this->dispatchBrowserEvent('confirm-rooting-approval', $type);
    }

    /**
     * Function to show popup confirmation via javascript before update document
     */
    public function confirmUpdateDocument()
    {
        $this->alert('question', 'Are You Sure ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'confirmButtonColor' => '#00552F',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#d33',
            'timer' => 30000,
            'toast' => true,
            'timerProgressBar' => true,
            'position' => 'center',
            'text' => 'Documents will be renewed',
            'onConfirmed' => 'updateDocument',
        ]);
        // return $this->dispatchBrowserEvent('confirm-update-document');
    }

    /**
     * Function to show popup confirmation via javascript to update attachment and detail location
     * @return void
     */
    public function confirmRenewDocument()
    {
        return $this->dispatchBrowserEvent('modal-renew-document');
    }

    /**
     * Function to create a new document
     * @return void
     */
    public function confirmCreateNew()
    {
        $service = new JsaService();
        $service->create_new_document($this->id_maker);

        $this->flash('success', 'Success create a new JSA Document', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        return redirect()->route('document-systems::jsa.draft');
    }

    /**
     * Function to create a new document from expire document
     */
    public function updateDocument()
    {
        try {
            $service = new DocumentSystemService();
            $new_doc = $service->replicate($this->id_maker);

            $this->flash('success', trans('global.success_update_document'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('document-systems::edit-maker', $new_doc->id);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Function to reset all revision form
     */
    public function resetFormRevision()
    {
        $this->tmp = [];
        $this->revision_proof = [];
        $this->revision_reason = '';

        // reset error bag
        $this->resetErrorBag();
    }

    /**
     * Function to show popup revision reason
     * @param string id
     */
    public function revision($id)
    {
    }

    /**
     * Function to show detail acticity
     */
    public function detailActivity($activity)
    {
        $attachments = $activity['attachments'];
        if (count($attachments) > 0) {
            $service = new DocumentSystemService();
            $attachments = collect($attachments)->map(function ($item) use ($service) {
                if (
                    $item['file_type'] == 'png' ||
                    $item['file_type'] == 'jpg' ||
                    $item['file_type'] == 'jpeg' ||
                    $item['file_type'] == 'webp'
                ) {
                    $item['group'] = 'image';
                } else {
                    $item['group'] = 'file';
                }
                $item['icon_preview'] = $service->define_file_icon($item['file_type']);
                return $item;
            })->groupBy('group')->all();
            $activity['attachments'] = $attachments;
        }
        $this->detailActivity = $activity;
        // dd($activity);
        $this->dispatchBrowserEvent('open-modal-activity');
    }

    public function renew()
    {
        DB::beginTransaction();
        try {
            $payload = [
                'id' => $this->id_maker,
                'tmp' => $this->tmp,
                'location' => $this->new_detail_location,
            ];
            $service = new JsaService();
            $service->renew_document($payload);
            DB::commit();

            $this->flash('success', 'Success to create new JSA Document', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('document-systems::jsa.draft');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function changeStatus($status)
    {
        if ($status == PtwDocument::ACTIVE) {
            $text = 'Are you sure to Active this document?';
        } else {
            $text = 'Are you sure to Deactive this document?';
        }

        $this->alert('question', 'Are You Sure ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'confirmButtonColor' => '#00552F',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#d33',
            'timer' => 30000,
            'toast' => true,
            'timerProgressBar' => true,
            'position' => 'center',
            'text' => $text,
            'onConfirmed' => 'submitChangeStatus',
            'inputAttributes' => [
                'value' => $status
            ],
        ]);

        // $this->dispatchBrowserEvent('confirm-change-status', ['text' => $text, 'status' => $status]);
    }

    /**
     * Function to change ptw document status
     * @param $status int
     * @param PtwService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitChangeStatus($status, PtwService $service)
    {
        $status = $status['data']['inputAttributes']['value'];

        $service->changeStatus([
            'id' => $this->id_maker,
            'status' => $status,
            'doc_created' => Carbon::now(),
            'inactive_at' => Carbon::now(),
        ]);

        $this->flash('success', 'Success change status document', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        return redirect()->route('document-systems::ptw.active');
    }
}
