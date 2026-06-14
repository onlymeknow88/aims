<?php

namespace Modules\CSMS\Entities;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CsmsMemoKtt extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'memo_number',
        'title',
        'ccow_id',
        'ktt_id',
        'date',
        'date_inactive',
        'description',
        'status',
    ];

    public function ccow()
    {
        return $this->belongsTo(Company::class);
    }

    public function files()
    {
        return $this->hasMany(CsmsMemoKttFile::class);
    }

    public function ktt()
    {
        return $this->belongsTo(User::class);
    }
}
