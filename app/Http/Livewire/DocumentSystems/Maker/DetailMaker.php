<?php

namespace App\Http\Livewire\DocumentSystems\Maker;

use App\Models\DocumentSystem\ActivityAttachment;
use App\Models\DocumentSystem\Attachment;
use App\Models\DocumentSystem\Document;
use App\Services\DocumentSystemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DetailMaker extends Component
{
    use WithFileUploads;

    public $id_maker;
    public $tmp = [];
    public $saveFileUrl;
    public $currentUrlType;

    // models
    public $revision_reason;
    public $revision_proof = [];
    public $file_revision;

    public function mount($id, $type)
    {
        $this->id_maker = $id;
        $this->currentUrlType = $type;
        $this->saveFileUrl = route('maker.revision.upload-file', $this->id_maker);
    }

    public function render()
    {
        $service = new DocumentSystemService();

        $detail = $service->detail($this->id_maker);
        $attachments = $detail['attachments'];
        $activities = $detail['activities'];
        $detail = $detail['detail'];

        $image_media = [];
        $file_media = [];
        if (count($activities) > 0) {
            foreach ($activities as $activity) {
                $act_media = $activity->attachments;
                foreach ($act_media as $media) {
                    if (
                        $media->file_type == 'jpg' ||
                        $media->file_type == 'png'
                    ) {
                        $image_media[$activity->id][] = [
                            'size' => $media->size,
                            'path' => $media->path,
                            'preview' => $media->path,
                            'name' => $media->name,
                            'ext_icon' => null,
                            'id' => $media->id,
                        ];
                    }

                    if (
                        $media->file_type == 'pdf' ||
                        $media->file_type == 'xlsx' ||
                        $media->file_type == 'xlx' ||
                        $media->file_type == 'docx' ||
                        $media->file_type == 'doc'
                    ) {
                        $file_media[$activity->id][] = [
                            'size' => $media->file_size,
                            'path' => $media->path,
                            'preview' => $media->path,
                            'name' => $media->name,
                            'ext_icon' => $service->define_file_icon($media->file_type),
                            'id' => $media->id,
                        ];
                    }
                }
            }
        }

        if ($this->currentUrlType == 'obsolate') {
            $back_url = route('document-systems.obsolate');
        } else if ($this->currentUrlType == 'active-document') {
            $back_url = route('maker');
        } else if ($this->currentUrlType == 'draft') {
            $back_url = route('document-systems.draft');
        }

        return view('livewire.document-systems.maker.detail-maker', compact('detail','attachments', 'activities', 'image_media', 'file_media', 'back_url'))
            ->extends('layouts.no-header');
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
    public function uploadTmpFile(Request $request)
    {
        $service = new DocumentSystemService();
        $upload = $service->temporary_upload($request);

        return response()->json($upload);
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

            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Success',
                'icon' => 'success',
                'text' => trans('global.success_return_document'),
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

        session()->flush('success', trans('global.success_process_rooting_approval'));
        return redirect()->route('maker');
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

            session()->flush('success', trans('global.success_approved_document'));
            return redirect()->route('maker');
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->dispatchBrowserEvent('swal', [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => env('APP_ENV') == 'local' ? $th->getMessage() . ' ' . $th->getLine() : 'Failed to update document',
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
        $data = Attachment::select('file_name', 'document_id')
            ->find($id);
        $path = asset('storage/document_systems/' . $data->document_id . '/' . $data->file_name);
        returN $this->dispatchBrowserEvent('detail-media', $path);
    }

    /**
     * Function to show popup confirmation via javascript
     */
    public function confirmRooting($type)
    {
        return $this->dispatchBrowserEvent('confirm-rooting-approval', $type);
    }

    /**
     * Function to show popup confirmation via javascript before update document
     */
    public function confirmUpdateDocument()
    {
        return $this->dispatchBrowserEvent('confirm-update-document');
    }

    /**
     * Function to create a new document from expire document
     */
    public function updateDocument()
    {
        try {
            $service = new DocumentSystemService();
            $new_doc = $service->replicate($this->id_maker);

            session()->flash('success', trans('global.success_update_document'));
            return redirect()->route('edit-maker', $new_doc->id);
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
}
