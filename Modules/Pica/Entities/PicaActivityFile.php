<?php

namespace Modules\Pica\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PicaActivityFile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['pica_activity_id', 'file', 'type_file', 'size'];

    public function activity()
    {
        return $this->belongsTo(PicaActivity::class, 'pica_activity_id');
    }
}
