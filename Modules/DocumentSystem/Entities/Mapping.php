<?php

namespace Modules\DocumentSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mapping extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'document_system_mappings';

    public function category(): BelongsTo
    {
        return $this->belongsTo(ModuleCategory::class, 'category_id');
    }

    public function formattedName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['index'] . '. ' . $attributes['name']
        );
    }

    public static function store($request)
    {
        $model = new Mapping();
        $model->category_id = $request['category_id'];
        $model->name = $request['name'];
        $model->index = implode('_', explode(' ', $request['mapping_index']));
        $model->save();
    }

    public static function updateData($request, $id)
    {
        $model = Mapping::find($id);
        $model->category_id = $request['category_id'];
        $model->name = $request['name'];
        $model->index = implode('_', explode(' ', $request['mapping_index']));
        $model->save();
    }
}
