<?php

namespace Modules\FieldLeadership\Transformers\Listing;

use App\Enums\FieldLeadership\FieldLeadershipType;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class FieldLeadershipListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request): array
    {
        $members = new Collection();
        $positives = new Collection();
        $risks = new Collection();

        foreach ($this->members as $member) {
            $members->push([
                'type' => $member->type ?? null,
                'employee_id' => $member->employee->id ?? null,
                'name' => $member->employee->name ?? null,
            ]);
        }

        foreach ($this->positives as $positive) {
            $positives->push([
                'description' => $positive->description ?? null,
            ]);
        }

        foreach ($this->risks as $risk) {

            $files = new Collection();
            $files_ca = new Collection();

            foreach ($risk->files->where('type', FieldLeadershipType::RiskFinding) as $file) {
                $files->push([
                    'path' => route('field-leadership::files.preview', ['id' => $file->id]),
                    'size' => $file->size,
                ]);
            }

            foreach ($risk->files->where('type', FieldLeadershipType::CorrectiveAction)  as $file) {
                $files_ca->push([
                    'path' => route('field-leadership::files.preview', ['id' => $file->id]),
                    'size' => $file->size,
                ]);
            }

            $risks->push([
                'description' => $risk->risk_condition ?? null,
                'category_id' => $risk->category->id ?? null,
                'category' => $risk->category->name ?? null,
                'potency_id' => $risk->potency->id ?? null,
                'potency' => $risk->potency->name ?? null,
                'type_id' => $risk->type->id ?? null,
                'type' => $risk->type->code  . '. ' . $risk->type->name ?? null,
                'action' => $risk->repair_action ?? null,
                'date' => $risk->due_date == '0000-00-00' ? '-' :  $risk->due_date,
                'type_action' => $risk->type_action ?? null,
                'supervisor' => $risk->supervisor ?? null,
                'repaired' => $risk->repair_action ? true : false,
                'files' => $files,
                'files_ca' => $files_ca,
            ]);
        }

        return [
            'id' => $this->id,
            'number' => $this->number,
            'date' => $this->date,
            'ccow_id' => $this->ccow->id,
            'ccow' => $this->ccow->company_name,
            'company_id' => $this->company->id,
            'company' => $this->company->company_name,
            'detail_company' => $this->detail_company,
            'department_id' => $this->department->id,
            'department' => $this->department->name,
            'section_id' => $this->section->id,
            'section' => $this->section->name,
            'area_location_id' => $this->areaLocation->id,
            'location' => $this->areaLocation->name,
            'detail_location' => $this->detail_location,
            'personil_on_review' => $this->personil_on_review,
            'personil_on_review_name' => $this->personil_on_review_name,
            'pja_id' => $this->pja_id ?? null,
            'pja' => $this->pja->user->name ?? null,
            'pjo_id' => $this->pjo_id ?? null,
            'pjo' => $this->pjo->user->name ?? null,
            'type' => $this->type,
            'job' => $this->job,
            'members' => $members,
            'visit_time' => $this->visit_time,
            'non_compliance_root' => $this->non_compliance_root,
            'positive_condition' => $positives,
            'risk_condition' => $risks,
            'status' => $this->status,
            'published' => $this->published,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
