<?php

namespace Modules\FieldLeadership\Http\Controllers\Listing\Document;

use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipActivity;
use Modules\FieldLeadership\Entities\FieldLeadershipMember;
use Modules\FieldLeadership\Entities\FieldLeadershipPositive;
use Modules\FieldLeadership\Entities\FieldLeadershipQuestionPto;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Modules\FieldLeadership\Jobs\NewDocumentMailJob;
use Modules\FieldLeadership\Transformers\Listing\FieldLeadershipDetailResource;
use Modules\FieldLeadership\Transformers\Listing\FieldLeadershipListResource;

class DocumentController extends Controller
{

    public function getFieldLeadership(Request $request): AnonymousResourceCollection
    {
        $fieldLeadership = FieldLeadership::when(!empty($request->type), function ($q) use ($request) {
            $q->where('type', $request->type);
        })
            ->where('created_by', auth()->user()->employee?->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return FieldLeadershipListResource::collection($fieldLeadership);
    }

    public function store(Request $request): FieldLeadershipDetailResource
    {
        $request->validate([
            'date' => 'required',
            'ccow_id' => 'required',
            'company_id' => 'required',
            'detail_company' => 'required',
            'department_id' => 'required',
            'section_id' => 'required',
            'area_location_id' => 'required',
            'detail_location' => 'nullable',
            'personil_on_review' => 'required',
            'personil_on_review_name' => 'nullable',
            'pja_id' => 'required',
            'pjo_id' => 'nullable',
            'type' => 'required',
            'job' => 'required',
            'visit_time' => 'nullable',
            'non_compliance_root' => 'nullable',
            'member.*.type' => 'nullable',
            'member.*.employee_id' => 'nullable',
            'positive_condition.*.description' => 'nullable',
            'risk_condition.*.description' => 'nullable',
            'risk_condition.*.category' => 'nullable',
            'risk_condition.*.type' => 'nullable',
            'risk_condition.*.level' => 'nullable',
            'risk_condition.*.action' => 'nullable',
            'risk_condition.*.due_date' => 'nullable',
            'risk_condition.*.type_action' => 'nullable',
            'risk_condition.*.supervisor' => 'nullable',
            'risk_condition.*.repaired' => 'nullable',
            'risk_condition.*.files.*.file' => 'nullable',
            'risk_condition.*.files_ca.*.file' => 'nullable',
        ]);

        DB::beginTransaction();

        $fl_last = FieldLeadership::latest()->first();

        if ($fl_last == null) {
            $count = [0, 0, 0, 0];
        } else {
            $count = explode('-', $fl_last->number);
        }

        $company = Company::find($request->input('company_id'));
        $date = Carbon::today()->format('dmY');

        $fieldLeadership = FieldLeadership::create([
            'number' => $this->generateNumber($company->document_code),
            'date' => Carbon::parse($request->input('date'))->format('Y-m-d'),
            'ccow_id' => $request->input('ccow_id'),
            'company_id' => $request->input('company_id'),
            'detail_company' => $request->input('detail_company'),
            'department_id' => $request->input('department_id'),
            'section_id' => $request->input('section_id'),
            'area_location_id' => $request->input('area_location_id'),
            'detail_location' => $request->input('detail_location'),
            'personil_on_review' => $request->input('personil_on_review'),
            'personil_on_review_name' => $request->input('personil_on_review_name'),
            'pja_id' => $request->input('pja_id'),
            'pjo_id' => $request->input('pjo_id'),
            'type' => $request->input('type'),
            'job' => $request->input('job'),
            'visit_time' => $request->input('visit_time'),
            'non_compliance_root' => $request->input('non_compliance_root'),
            'published' => $request->input('published'),
            'status' => $request->input('type') != 'Hazard Report' ? FieldLeadershipType::Open : FieldLeadershipType::Close,
            'requested' => $request->input('type') != 'Hazard Report' ? FieldLeadershipType::RequestedPja : FieldLeadershipType::Rejected,
            'created_by' => Auth::user()->employee?->id ?? '-',
        ]);

        if ($request->input('type') == 'Planned Task Observation') {
            $fieldLeadership->questions()->create([
                'question' => $request->input('question1'),
                'answer' => $request->input('answer1'),
                'description' => $request->input('description1'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question2'),
                'answer' => $request->input('answer2'),
                'description' => $request->input('description2'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question3'),
                'answer' => '-',
                'description' => $request->input('description3'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question4'),
                'answer' => $request->input('answer4'),
                'description' => $request->input('description4'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question5'),
                'answer' => $request->input('answer5'),
                'description' => $request->input('description5'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question6'),
                'answer' => $request->input('answer6'),
                'description' => $request->input('description6'),
            ]);
        }

        foreach ($request->input('member') as $key => $value) {
            $fieldLeadership->members()->create([
                'type' => $value['type'],
                'employee_id' => $value['employee_id'],
            ]);
        }

        if ($request->input('type') != 'Hazard Report') {
            foreach ($request->input('positive_condition') as $key => $value) {
                $fieldLeadership->positives()->create([
                    'description' => $value['description'],
                ]);
            }
        }


        foreach ($request->input('risk_condition') as $key => $value) {
            if ($value['repaired'] == true) {
                $request->validate([
                    'risk_condition.' . $key . '.type_action' => 'required',
                    'risk_condition.' . $key . '.supervisor' => 'required',
                    'risk_condition.' . $key . '.action' => 'required',
                    'risk_condition.' . $key . '.due_date' => 'required',
                ]);
            }

            $riskCondition = $fieldLeadership->risks()->create([
                'risk_condition' => $value['description'],
                'category_id' => $value['category'],
                'type_id' => $value['type'],
                'potency_id' => $value['level'],
                'repair_action' => $value['repaired'] == true ? $value['action'] : null,
                'due_date' => !isset($value['due_date']) ? '0000-00-00' : Carbon::parse($value['due_date'])->format('Y-m-d'),
                'type_action' => $value['repaired'] == true ? $value['type_action'] : null,
                'supervisor' => $value['repaired'] == true ? $value['supervisor'] : null,
                'status' => $request->input('type') != 'Hazard Report' ? FieldLeadershipType::Open : FieldLeadershipType::Close,
            ]);

            if ($value['files'] != null) {
                foreach ($value['files'] as $key => $file) {
                    $tempPath = Storage::disk('public')->path($file['path']);
                    $directPath = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
                    $filename = basename($file['path']);
                    $blobResult = uploadToBlobStorage($filename, $tempPath, $directPath);
                    $relative_path = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id . '/' . $filename;

                    $riskCondition->files()->create([
                        'file' => $relative_path,
                        'blob_url' => $blobResult['fileBlobUrl'] ?? null,
                        'blob_response' => isset($blobResult['blobResponse']) ? json_encode($blobResult['blobResponse']) : null,
                        'size' => $file['file_size'],
                        'type' => FieldLeadershipType::RiskFinding
                    ]);

                    if (Storage::disk('public')->exists($file['path'])) {
                        Storage::disk('public')->delete($file['path']);
                    }
                }
            }

            if ($value['repaired'] == true) {
                $request->validate([
                    'risk_condition.' . $key . '.files_ca' => 'required',
                ]);
                if ($value['files_ca'] != null) {
                    foreach ($value['files_ca'] as $key => $file) {
                        $tempPath = Storage::disk('public')->path($file['path']);
                        $directPath = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
                        $filename = basename($file['path']);
                        $blobResult = uploadToBlobStorage($filename, $tempPath, $directPath);
                        $relative_path = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id . '/' . $filename;

                        $riskCondition->files()->create([
                            'file' => $relative_path,
                            'blob_url' => $blobResult['fileBlobUrl'] ?? null,
                            'blob_response' => isset($blobResult['blobResponse']) ? json_encode($blobResult['blobResponse']) : null,
                            'size' => $file['file_size'],
                            'type' => FieldLeadershipType::CorrectiveAction
                        ]);

                        if (Storage::disk('public')->exists($file['path'])) {
                            Storage::disk('public')->delete($file['path']);
                        }
                    }
                }
            }
        }

        FieldLeadershipActivity::create([
            'fl_id' => $fieldLeadership->id,
            'description' => 'Create Field Leadership',
            'user_id' => Auth::user()->id ?? '-',
        ]);

        DB::commit();

        // $data_mail = [
        //     'name' => $fieldLeadership->pja->user->name,
        //     'email' => $fieldLeadership->pja->user->email,
        // ];
        // NewDocumentMailJob::dispatch($data_mail);

        return new FieldLeadershipDetailResource($fieldLeadership);
    }

    public function detailFieldLeadership(FieldLeadership $fieldLeadership): FieldLeadershipDetailResource
    {
        return new FieldLeadershipDetailResource($fieldLeadership);
    }

    public function questionPto(): JsonResponse
    {
        $data = [
            [
                'number' => "question1",
                'option' => true,
                'question' => 'Apakah risiko yang ada di area Anda yang dapat membahayakan nyawa Anda?'
            ],
            [
                'number' => "question2",
                'option' => true,
                'question' => 'Apakah tersedia pengendalian penting tersedia untuk melindungi Anda?'
            ],
            [
                'number' => "question3",
                'option' => false,
                'question' => 'Bagaimana Anda mengetahui pengendalian penting tersebut efektif?'
            ],
            [
                'number' => "question4",
                'option' => true,
                'question' => 'Apakah semua langkah kerja di dalam SOP/INK/JSA telah berkesesuaian dengan pekerjaan yang dilakukan?'
            ],
            [
                'number' => "question5",
                'option' => true,
                'question' => 'Pekerja memahami SOP/INK/JSA tersebut?'
            ],
            [
                'number' => "question6",
                'option' => true,
                'question' => 'Apakah ada opportunity untuk proses SOP/INK/JSA yang lebih efisien, produktif dan aman?'
            ]
        ];

        return response()->json([
            'data' => $data
        ]);
    }

    public function typeAction(): JsonResponse
    {
        $data = [
            [
                'type' => "Eliminasi",
            ],
            [
                'type' => "Substitusi",
            ],
            [
                'type' => "Teknik Rekayasa",
            ],
            [
                'type' => "Administrasi",
            ],
            [
                'type' => "Alat Pelindung Diri",
            ],
        ];

        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $id): FieldLeadershipDetailResource
    {
        $request->validate([
            'date' => 'required',
            'ccow_id' => 'required',
            'company_id' => 'required',
            'detail_company' => 'required',
            'department_id' => 'required',
            'section_id' => 'required',
            'area_location_id' => 'required',
            'detail_location' => 'nullable',
            'personil_on_review' => 'required',
            'personil_on_review_name' => 'nullable',
            'pja_id' => 'required',
            'pjo_id' => 'nullable',
            'type' => 'required',
            'job' => 'required',
            'visit_time' => 'nullable',
            'non_compliance_root' => 'nullable',
            'member.*.type' => 'nullable',
            'member.*.employee_id' => 'nullable',
            'positive_condition.*.description' => 'nullable',
            'risk_condition.*.description' => 'nullable',
            'risk_condition.*.category' => 'nullable',
            'risk_condition.*.type' => 'nullable',
            'risk_condition.*.level' => 'nullable',
            'risk_condition.*.action' => 'nullable',
            'risk_condition.*.due_date' => 'nullable',
            'risk_condition.*.type_action' => 'nullable',
            'risk_condition.*.supervisor' => 'nullable',
            'risk_condition.*.files.*.file' => 'nullable',
            'risk_condition.*.files_ca.*.file' => 'nullable',
        ]);

        DB::beginTransaction();

        $fieldLeadership = FieldLeadership::find($id);

        $fieldLeadership->update([
            'date' => Carbon::parse($request->input('date'))->format('Y-m-d'),
            'ccow_id' => $request->input('ccow_id'),
            'company_id' => $request->input('company_id'),
            'detail_company' => $request->input('detail_company'),
            'department_id' => $request->input('department_id'),
            'section_id' => $request->input('section_id'),
            'area_location_id' => $request->input('area_location_id'),
            'detail_location' => $request->input('detail_location'),
            'personil_on_review' => $request->input('personil_on_review'),
            'personil_on_review_name' => $request->input('personil_on_review_name'),
            'pja_id' => $request->input('pja_id'),
            'pjo_id' => $request->input('pjo_id'),
            'type' => $request->input('type'),
            'job' => $request->input('job'),
            'visit_time' => $request->input('visit_time'),
            'non_compliance_root' => $request->input('non_compliance_root'),
            'published' => $request->input('published'),
            'status' => $request->input('type') != 'Hazard Report' ? FieldLeadershipType::Open : FieldLeadershipType::Close,
            'requested' => $request->input('type') != 'Hazard Report' ? FieldLeadershipType::RequestedPja : FieldLeadershipType::Rejected,
        ]);

        if ($request->input('type') == 'Planned Task Observation') {
            FieldLeadershipQuestionPto::where('fl_id', $fieldLeadership->id)->delete();
            $fieldLeadership->questions()->create([
                'question' => $request->input('question1'),
                'answer' => $request->input('answer1'),
                'description' => $request->input('description1'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question2'),
                'answer' => $request->input('answer2'),
                'description' => $request->input('description2'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question3'),
                'answer' => '-',
                'description' => $request->input('description3'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question4'),
                'answer' => $request->input('answer4'),
                'description' => $request->input('description4'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question5'),
                'answer' => $request->input('answer5'),
                'description' => $request->input('description5'),
            ]);

            $fieldLeadership->questions()->create([
                'question' => $request->input('question6'),
                'answer' => $request->input('answer6'),
                'description' => $request->input('description6'),
            ]);
        }

        if ($request->input('member')) {
            FieldLeadershipMember::where('fl_id', $fieldLeadership->id)->delete();
            foreach ($request->input('member') as $key => $value) {
                $fieldLeadership->members()->create([
                    'type' => $value['type'],
                    'employee_id' => $value['employee_id'],
                ]);
            }
        }

        if ($request->input('type') != 'Hazard Report') {
            if ($request->input('positive_condition')) {
                FieldLeadershipPositive::where('fl_id', $fieldLeadership->id)->delete();
                foreach ($request->input('positive_condition') as $key => $value) {
                    $fieldLeadership->positives()->create([
                        'description' => $value['description'],
                    ]);
                }
            }
        }

        if ($request->input('risk_condition')) {
            $risk = FieldLeadershipRisk::where('fl_id', $fieldLeadership->id)->get();
            $existingFilesMap = [];
            foreach ($risk as $r) {
                foreach ($r->files as $f) {
                    $existingFilesMap[$f->file] = [
                        'blob_url' => $f->blob_url,
                        'blob_response' => $f->blob_response,
                    ];
                }
            }

            foreach ($risk as $key => $value) {
                if (!empty($value->files)) {
                    Storage::disk('public')->deleteDirectory('field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $value->id);
                    $value->files()->delete();
                }

                if (!empty($value)) {
                    $value->delete();
                }
            }

            foreach ($request->input('risk_condition') as $key => $value) {
                if ($value['repaired'] == true) {
                    $request->validate([
                        'risk_condition.' . $key . '.type_action' => 'required',
                        'risk_condition.' . $key . '.supervisor' => 'required',
                        'risk_condition.' . $key . '.action' => 'required',
                        'risk_condition.' . $key . '.due_date' => 'required',
                    ]);
                }

                $riskCondition = $fieldLeadership->risks()->create([
                    'risk_condition' => $value['description'],
                    'category_id' => $value['category'],
                    'type_id' => $value['type'],
                    'potency_id' => $value['level'],
                    'repair_action' => $value['repaired'] == true ? $value['action'] : null,
                    'due_date' => !isset($value['due_date']) ? '0000-00-00' : Carbon::parse($value['due_date'])->format('Y-m-d'),
                    'type_action' => $value['repaired'] == true ? $value['type_action'] : null,
                    'supervisor' => $value['repaired'] == true ? $value['supervisor'] : null,
                    'status' => $request->input('type') != 'Hazard Report' ? FieldLeadershipType::Open : FieldLeadershipType::Close,
                ]);

                if ($value['files'] != null) {
                    foreach ($value['files'] as $key => $file) {
                        if (strpos($file['path'], 'temp-field-leadership') === false) {
                            $relative_path = $file['path'];
                            $blob_url = $existingFilesMap[$relative_path]['blob_url'] ?? null;
                            $blob_response = $existingFilesMap[$relative_path]['blob_response'] ?? null;
                        } else {
                            $tempPath = Storage::disk('public')->path($file['path']);
                            $directPath = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
                            $filename = basename($file['path']);
                            $blobResult = uploadToBlobStorage($filename, $tempPath, $directPath);
                            $relative_path = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id . '/' . $filename;
                            $blob_url = $blobResult['fileBlobUrl'] ?? null;
                            $blob_response = isset($blobResult['blobResponse']) ? json_encode($blobResult['blobResponse']) : null;

                            if (Storage::disk('public')->exists($file['path'])) {
                                Storage::disk('public')->delete($file['path']);
                            }
                        }

                        $riskCondition->files()->create([
                            'file' => $relative_path,
                            'blob_url' => $blob_url,
                            'blob_response' => $blob_response,
                            'size' => $file['file_size'],
                            'type' => FieldLeadershipType::RiskFinding
                        ]);
                    }
                }

                if ($value['repaired'] == true) {
                    $request->validate([
                        'risk_condition.' . $key . '.files_ca' => 'required',
                    ]);
                    if ($value['files_ca'] != null) {
                        foreach ($value['files_ca'] as $key => $file) {
                            if (strpos($file['path'], 'temp-field-leadership') === false) {
                                $relative_path = $file['path'];
                                $blob_url = $existingFilesMap[$relative_path]['blob_url'] ?? null;
                                $blob_response = $existingFilesMap[$relative_path]['blob_response'] ?? null;
                            } else {
                                $tempPath = Storage::disk('public')->path($file['path']);
                                $directPath = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
                                $filename = basename($file['path']);
                                $blobResult = uploadToBlobStorage($filename, $tempPath, $directPath);
                                $relative_path = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id . '/' . $filename;
                                $blob_url = $blobResult['fileBlobUrl'] ?? null;
                                $blob_response = isset($blobResult['blobResponse']) ? json_encode($blobResult['blobResponse']) : null;

                                if (Storage::disk('public')->exists($file['path'])) {
                                    Storage::disk('public')->delete($file['path']);
                                }
                            }

                            $riskCondition->files()->create([
                                'file' => $relative_path,
                                'blob_url' => $blob_url,
                                'blob_response' => $blob_response,
                                'size' => $file['file_size'],
                                'type' => FieldLeadershipType::CorrectiveAction
                            ]);
                        }
                    }
                }
            }
        }

        FieldLeadershipActivity::create([
            'fl_id' => $fieldLeadership->id,
            'description' => 'Update Field Leadership',
            'user_id' => Auth::user()->id,
        ]);

        DB::commit();

        return new FieldLeadershipDetailResource($fieldLeadership);
    }

    public function generateNumber($document_code)
    {
        $count = FieldLeadership::count();
        $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $date = Carbon::today()->format('dmY');

        $result = 'FL-' . $document_code . '-' . $date . '-' . $formattedNumber;

        while (FieldLeadership::where('number', $result)->exists()) {
            $count++;
            $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
            $result = 'FL-' . $document_code . '-' . $date . '-' . $formattedNumber;
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
