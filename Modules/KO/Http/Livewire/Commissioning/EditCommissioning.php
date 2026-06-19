<?php

namespace Modules\KO\Http\Livewire\Commissioning;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\KO\Entities\KoCommissioning;
use Modules\KO\Entities\KoCommissioningField;
use Modules\KO\Entities\KoCommissioningItem;
use Modules\KO\Entities\KoIssueReport;
use Modules\KO\Entities\KoIssueReportAttachment;
use Modules\KO\Entities\KoProposal;
use App\Enums\CompanyType;
use App\Enums\KO\KoStatus;
use App\Enums\KO\IssueReportStatus;
use Mail;
use App\Mail\KO\ProposalCompleted;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditCommissioning extends Component
{
    use WithFileUploads, LivewireAlert;

    public $ko_proposal = [];

    public $company;
    public $call_sign;
    public $serial_number;
    public $brand;
    public $model_unit;
    public $production_year;
    public $period;

    //form
    public $date;
    public $commissioning_completion_date;
    public $smu_odo_meter;
    public $engine_status;
    public $expired_date = null;
    public $created_by;

    public $commissionings = [];

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function mount($id): void
    {
        $this->ko_proposal = KoProposal::find($id);

        $this->company = $this->ko_proposal->ccow->company_name;
        $this->call_sign = $this->ko_proposal->koUnit->call_sign;
        $this->serial_number = $this->ko_proposal->koUnit->serial_number;
        $this->brand = $this->ko_proposal->koUnit->koBrand->name;
        $this->model_unit = $this->ko_proposal->koUnit->model_unit;
        $this->production_year = $this->ko_proposal->koUnit->production_year;
        $this->period = $this->ko_proposal->koUnit->commisioning_count + 1;

        //flled
        $this->date = $this->ko_proposal->koCommissioning->date;
        $this->commissioning_completion_date = $this->ko_proposal->koCommissioning->commissioning_completion_date;
        $this->smu_odo_meter = $this->ko_proposal->koCommissioning->smu_odo_meter;
        $this->engine_status = $this->ko_proposal->koCommissioning->engine_status;
        $this->expired_date = $this->ko_proposal->koCommissioning->expired_date;
        $this->created_by = $this->ko_proposal->koCommissioning->created_by;
    }

    public function hydrate(): void
    {
        $this->emit('select2');
    }

    public function updated($propertyName, $value)
    {
        $is_failed = false;
        foreach($this->commissionings as $key => $commissioning)
        {
            if ($commissioning['condition'] == 'Gagal') {
                $is_failed = true;
            }
        }

        if ($is_failed == true) {
            $this->is_failed_commissioning = true;
        } else {
            $this->is_failed_commissioning = false;
            $this->temporary_validity_period = null;
        }
    }

    public function store(): bool|RedirectResponse|Redirector
    {
        //$this->validate();
        try {
            DB::beginTransaction();
            //$this->ko_proposal->koCommissioning->koCommissioningItem->delete();
            $this->ko_proposal->koCommissioning->delete();

            $koCommissioning = KoCommissioning::create([
                'ko_proposal_id' => $this->ko_proposal->id,
                'date' => Carbon::parse($this->date)->format('Y-m-d'),
                'commissioning_completion_date' => Carbon::parse($this->commissioning_completion_date)->format('Y-m-d'),
                'smu_odo_meter' => $this->smu_odo_meter,
                'engine_status' => $this->engine_status,
                'expired_date' => Carbon::parse($this->expired_date)->format('Y-m-d'),
                'status' => '',
                'created_by' => $this->created_by,
            ]);

            $proposalStatus = KoStatus::CommissionerCommissioningVerification()->value;

            foreach($this->commissionings as $key => $commissioning)
            {
                $commissioningField = KoCommissioningField::find($key);

                $commissioningItem = KoCommissioningItem::create([
                    'ko_commissioning_id' => $koCommissioning->id,
                    'ko_commissioning_field_id' => $key,
                    'condition' => $commissioning['condition'],
                    'note' => $commissioning['note'] ?? null,
                    //'attachment' => $attachment ?? null,
                ]);

                if ($commissioning['condition'] == 'Gagal') {
                    $issueReport = KoIssueReport::create([
                        'ko_proposal_id' => $this->ko_proposal->id,
                        'ko_unit_id' => $this->ko_proposal->ko_unit_id,
                        'ko_commissioning_field_id' => $key,
                        'note' => $commissioning['note'] ?? null,
                        //'attachment' => $attachment ?? null,
                        'hazard_code' => $commissioningField->hazard_code,
                        'status' => IssueReportStatus::Open()->value
                    ]);

                    if (isset($commissioning['attachments'])) {
                        foreach ($commissioning['attachments'] as $key => $attachment) {
                            $filename = $attachment->getClientOriginalName();
                            $filePathTemp = $attachment->getRealPath();
                            $directPath = 'ko/commissioning-attachment/' . $this->ko_proposal->id;

                            $blobResult = uploadToBlobStorage($filename, $filePathTemp, $directPath);

                            $issueReport->attachments()->create([
                                'attachment' => $blobResult['fileBlobPathName'] ?? ('ko/commissioning-attachment/' . $this->ko_proposal->id . '/' . $filename),
                                'blob_url' => $blobResult['fileBlobUrl'] ?? null,
                                'blob_response' => $blobResult['blobResponse'] ? json_encode($blobResult['blobResponse']) : null,
                                'size' => $this->changeByte($attachment->getSize()),
                                'name' => $filename,
                                'type' => $attachment->getClientOriginalExtension()
                            ]);
                        }
                    }

                    $proposalStatus = KoStatus::Issue()->value;
                    $temporaryValidityPeriod = $this->temporary_validity_period;
                }
            }

            //if ($this->ko_proposal->company->type == CompanyType::Internal()->value) {
            $interval = $this->ko_proposal->koUnit->koSpipUnit->koSpipType->koSpipCategory->internal_interval_year;
            //} else {
                //$interval = $this->ko_proposal->koUnit->koSpipUnit->koSpipType->koSpipCategory->contractor_interval_year;
            //}

            $this->ko_proposal->update([
                'status' => $proposalStatus,
                'next_commissioning' => Carbon::now()->addYears($interval)->format('Y-m-d')
            ]);

            //$this->ko_proposal->koUnit->update([
            //    'commissioning_count' => $this->ko_proposal->koUnit->commissioning_count + 1
            //]);

            if ($this->ko_proposal == KoStatus::Completed()->value) {
                //Mail::to($this->ko_proposal->pjo->email)->send(new ProposalCompleted($this->ko_proposal));
            }

            DB::commit();

            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('ko::commissioning.returned');
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

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render(): Factory|View|Application
    {
        return view('ko::livewire.commissioning.create-commissioning')->extends('ko::layouts.no-header');
    }
}
