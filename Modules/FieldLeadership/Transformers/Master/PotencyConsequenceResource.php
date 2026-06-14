<?php

namespace Modules\FieldLeadership\Transformers\Master;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PotencyConsequenceResource extends JsonResource
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
            'code'  => $this->code,
            'name' => $this->name,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-Y H:i:s'),
        ];
    }
}
