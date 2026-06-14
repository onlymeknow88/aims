<?php

namespace Modules\DocumentSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = 'document_system_modules';

    public function categories(): HasMany
    {
        return $this->hasMany(ModuleCategory::class, 'module_id', 'id');
    }

    public function formattedName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['name']
        );
    }

    public static function store($request)
    {
        $model = new Module();
        $model->name = $request['name'];
        $model->index = implode('_', explode(' ', $request['module_index']));
        $model->save();
    }

    public static function updateData($request, $id)
    {
        $model = Module::find($id);
        $model->name = $request['name'];
        $model->index = implode('_', explode(' ', $request['module_index']));
        $model->save();
    }
}
