<?php

namespace Modules\CSMS\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CsmsMemoKttFile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'csms_memo_ktt_id',
        'file',
        'size'
    ];

    public function memoKtt()
    {
        return $this->belongsTo(CsmsMemoKtt::class);
    }
}
