<?php

namespace Modules\Pica\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PicaFile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'pica_id',
        'file',
        'type',
        'size',
        'blob_url',
        'blob_response',
    ];

    public function pica()
    {
        return $this->belongsTo(PicaDocument::class, 'pica_id');
    }
}
