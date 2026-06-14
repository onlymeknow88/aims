<?php

namespace Modules\FieldLeadership\Transformers\Master;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LimitParameterResource extends JsonResource
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
            'max_member' => $this->max_item_member,
            'max_positive' => $this->max_item_positive_condition,
            'max_risk' => $this->max_item_risk_condition,
            'max_corrective' => $this->max_item_corrective_action,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-Y H:i:s'),
        ];
    }
}
