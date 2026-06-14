<?php

namespace Modules\FieldLeadership\Transformers\MainDashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class MainDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        dd($this->data);
        return parent::toArray($request);
    }
}
