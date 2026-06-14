<?php

namespace Modules\KO\Http\Controllers\Api;

use App\Enums\KO\IssueReportStatus;
use App\Enums\KO\KoStatus;
use App\Mail\KO\ProposalUpdated;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\KO\Entities\KoCommissioning;
use Modules\KO\Entities\KoCommissioningField;
use Modules\KO\Entities\KoCommissioningHeader;
use Modules\KO\Entities\KoCommissioningItem;
use Modules\KO\Entities\KoIssueReport;
use Modules\KO\Entities\KoProposal;
use Validator;

class CommissioningController extends Controller
{
    public function commissioningList()
    {
        $commissionings = KoProposal::where('status', KoStatus::Commissioning()->value)->get();

        $data = [];
        $i = -1;
        foreach ($commissionings as $commissioning) {
            $i++;

            $form = KoCommissioningHeader::query()
                ->where('ko_spip_unit_id', $commissioning->koUnit->koSpipUnit->id)
                ->with('koCommisioningFields')
                ->get();

            $data[$i] = [
                'id' => $commissioning->id,
                'ccow' => $commissioning->ccow->company_name,
                'company' => $commissioning->company->company_name,
                'area' => $commissioning->area,
                'spip_desc' => $commissioning->koUnit->koSpipUnit->name,
                'call_sign' => $commissioning->koUnit->call_sign,
                'status' => $commissioning->status,
                'number' => $commissioning->number,
                'serial_number' => $commissioning->koUnit->serial_number,
                'brand' => $commissioning->koUnit->koBrand->name ?? '',
                'model_unit' => $commissioning->koUnit->model_unit,
                'production_year' => $commissioning->koUnit->production_year,
                'period' => $commissioning->koUnit->commisioning_count + 1,
                'internal_komisioning_schedule' => $commissioning->internal_komisioning_schedule,
                'is_submitted' => 0,
                'form' => $form
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function uploadFiles(Request $request)
    {
        $data = [];
        foreach ($request['attachments'] as $key => $attachment) {
            $path = 'ko/commissioning-attachment';
            $full_path = Storage::disk('public')->put($path, $attachment);
            $image = [
                'attachment' => $full_path,
                'size' => $this->changeByte($attachment->getSize()),
                'name' => $attachment->getClientOriginalName(),
                'type' => $attachment->getClientOriginalExtension()
            ];

            $data[$key] = $image;
        }

        return $data;
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public function commissioningStore(Request $request)
    {
        if (!$request->data) {
            return null;
        }

        try {
            DB::beginTransaction();

            foreach ($request->data as $key => $proposal) {
                if ($proposal['is_submitted'] == 1) {
                    $koProposal = KoProposal::find($proposal['id']);

                    $koCommissioning = KoCommissioning::create([
                        'ko_proposal_id' => $proposal['id'],
                        'date' => Carbon::parse($proposal['date'])->format('Y-m-d'),
                        'commissioning_completion_date' => Carbon::parse($proposal['commissioning_completion_date'])->format('Y-m-d'),
                        'smu_odo_meter' => $proposal['smu_odo_meter'],
                        'engine_status' => $proposal['engine_status'],
                        'expired_date' => Carbon::parse($proposal['expired_date'])->format('Y-m-d'),
                        'status' => '',
                        'created_by' => $proposal['created_by'],
                    ]);

                    $proposalStatus = KoStatus::CommissionerCommissioningVerification()->value;

                    foreach($proposal['form'] as $header)
                    {
                        foreach($header['ko_commisioning_fields'] as $field) {
                            $commissioningField = KoCommissioningField::find($field['id']);

                            $commissioningItem = KoCommissioningItem::create([
                                'ko_commissioning_id' => $koCommissioning->id,
                                'ko_commissioning_field_id' => $field['id'],
                                'condition' => $field['condition'],
                                'note' => $field['note'] ?? null,
                                //'attachment' => $attachment ?? null,
                            ]);

                            if ($field['condition'] == 'Gagal') {
                                $issueReport = KoIssueReport::create([
                                    'ko_proposal_id' => $proposal['id'],
                                    'ko_unit_id' => $koProposal->ko_unit_id,
                                    'ko_commissioning_field_id' => $field['id'],
                                    'note' => $field['note'] ?? null,
                                    //'attachment' => $attachment ?? null,
                                    'hazard_code' => $field['hazard_code'],
                                    'status' => IssueReportStatus::Open()->value
                                ]);

                                if (isset($field['attachments'])) {
                                    foreach ($field['attachments'] as $key => $attachment) {
                                        $issueReport->attachments()->create([
                                            'attachment' => $attachment['attachment'],
                                            'size' => $attachment['size'],
                                            'name' => $attachment['name'],
                                            'type' => $attachment['name']
                                        ]);
                                    }
                                }

                                $proposalStatus = KoStatus::Issue()->value;
                            }
                        }
                    }

                    $interval = $koProposal->koUnit->koSpipUnit->koSpipType->koSpipCategory->internal_interval_year;

                    $koProposal->update([
                        'status' => $proposalStatus,
                        'next_commissioning' => Carbon::now()->addYears($interval)->format('Y-m-d')
                    ]);

                    $koProposal->koUnit->update([
                        'commissioning_count' => $koProposal->koUnit->commissioning_count + 1
                    ]);

                    //Mail::to($this->ko_proposal->pjo->email)->send(new ProposalUpdated($this->ko_proposal));
                }
            }

            DB::commit();

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Internal Server Error',
                'detail' => $th->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Success'
        ], 201);
    }
}
