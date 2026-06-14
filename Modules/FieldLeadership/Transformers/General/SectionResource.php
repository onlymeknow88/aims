<?php

namespace Modules\FieldLeadership\Transformers\General;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company_name' => $this->department->company->company_name,
            'department_name' => $this->department->name,
            'name' => $this->name,
        ];
    }
}
