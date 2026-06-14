<?php

namespace Modules\Coe\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids;

    protected $table = 'coe_categories';

    protected $guarded = [];

    public function events()
    {
        return $this->hasMany(Event::class, 'category_id');
    }
}
