<?php

namespace Modules\FieldLeadership\Transformers\General;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'company_name' => $this->department->company->company_name ?? null,
            'department_name' => $this->department->name ?? null,
            'name' => $this->name,
            'number' => $this->number,
            'id_number' => $this->id_number,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'blood_type' => $this->blood_type,
            'marital_status' => $this->marital_status,
            'employee_status' => $this->employee_status,
            'company' => $this->company,
            'department' => $this->department,
            'position' => $this->gendpositioner,
        ];
    }
}
