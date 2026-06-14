<?php

namespace App\Models\COE;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCategory
 */
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
