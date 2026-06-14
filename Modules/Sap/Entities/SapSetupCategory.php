<?php

namespace Modules\Sap\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class SapSetupCategory extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "sap_setup_category";
    protected $fillable = [
        'user_id',
        'slug',
        'name',
        'description',
        'available'
    ];

    public function setupList()
    {
        return $this->hasMany(SapSetup::class, 'category_id', 'id');
    }

    public function setup()
    {
        return $this->hasOne(SapSetup::class, 'category_id', 'id');
    }
}
