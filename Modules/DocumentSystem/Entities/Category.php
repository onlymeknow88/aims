<?php

namespace Modules\DocumentSystem\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids;

    protected $fillable = [
        'module_id',
        'name',
    ];

    protected $table = 'document_system_categories';

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function mappings()
    {
        return $this->hasMany(Mapping::class, 'category_id');
    }

    public function formattedName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['name']
        );
    }

    public static function all_related_data()
    {
        return Category::select('id', 'name', 'module_id')
            ->with('module:id,name')
            ->get();
    }

    public static function store($request)
    {
        $model = new Category();
        $model->module_id = $request['module_id'];
        $model->name = $request['name'];
        $model->index = implode('_', explode(' ', $request['category_index']));
        $model->save();
    }

    public static function updateData($request, $id)
    {
        $model = Category::find($id);
        $model->module_id = $request['module_id'];
        $model->name = $request['name'];
        $model->index = implode('_', explode(' ', $request['category_index']));
        $model->save();
    }
}
