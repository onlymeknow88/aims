<?php

namespace Modules\FieldLeadership\Transformers\General;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaManagerResource extends JsonResource
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
            'name' => $this->user?->employee?->name ?? $this->user?->name,
            'section' => $this->section?->name,
            'is_active' => $this->is_active == 1 ? 'Active' : 'Inactive'
        ];
    }
}
