<?php

namespace Modules\FieldLeadership\Transformers\General;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaLocationResource extends JsonResource
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
            'section' => $this->section->name,
            'name' => $this->name,
        ];
    }
}
