<?php

namespace Modules\Kplh\Transformers\Listing;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class LabelResource extends JsonResource
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
        $risk_categories = new Collection();
        $risk_potencies = new Collection();
        $repair_actions = new Collection();
        $due_date = new Collection();

        foreach ($this->members as $member) {
            $members->push([
                'name' => $member->employee->name ?? null,
            ]);
        }

        foreach ($this->positives as $positive) {
            $positives->push([
                'description' => $positive->description ?? null,
            ]);
        }

        foreach ($this->risks as $risk) {
            $risks->push([
                'description' => $risk->risk_condition ?? null,
            ]);
            $risk_categories->push([
                'category' => $risk->category->name ?? null,
            ]);
            $risk_potencies->push([
                'potency' => $risk->potency->name ?? null,
            ]);
            $repair_actions->push([
                'action' => $risk->repair_action ?? null,
            ]);
            $due_date->push([
                'date' => $risk->due_date == '0000-00-00' ? '-' :  Carbon::parse($risk->due_date)->format('F d, Y'),
            ]);
        }

        return [
            'id' => $this->id,
            'date' => Carbon::parse($this->date)->format('F d, Y'),
            'ccow' => $this->ccow->company_name,
            'company' => $this->company->company_name,
            'detail_company' => $this->detail_company,
            'department' => $this->department->name,
            'section' => $this->section->name,
            'location' => $this->areaLocation->name,
            'detail_location' => $this->detail_location,
            'type' => $this->type,
            'pja' => $this->pja->user->name ?? null,
            'members' => $members,
            'positive_condition' => $positives,
            'risk_condition' => $risks,
            'repair_action' => $repair_actions,
            'due_date' => $due_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
