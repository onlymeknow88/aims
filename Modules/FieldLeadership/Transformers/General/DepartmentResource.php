<?php

namespace Modules\FieldLeadership\Transformers\General;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'company_name' => $this->company->company_name,
            'code' => $this->code,
            'document_code' => $this->document_code,
            'name' => $this->name,
        ];
    }
}
