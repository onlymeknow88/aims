<?php

namespace Modules\KPP\Transformers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $types = new Collection();
        foreach ($this['types'] as $type) {
            $types->push([
                'name' => $type->name ?? null,
                'value' => $type->compliance ?? null,
            ]);
        }

        return [
            'categories' => $types,
            'percentage' => $this['percentage'],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->withoutWrapping();
    }
}
