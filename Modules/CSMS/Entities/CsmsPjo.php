<?php

namespace Modules\CSMS\Entities;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CsmsPjo extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'company_id',
        'criteria',
        'ccow_id',
        'submission',
        'number_pjo',
        'name',
        'date_of_birth',
        'phone',
        'email',
        'date_submission',
        'date_approved',
        'comment',
        'status',
        'published',
        'requested',
        'created_by',
    ];

    public function company()
    {
        return $this->belongsTo(Bidding::class, 'company_id');
    }

    public function ccow()
    {
        return $this->belongsTo(Company::class, 'ccow_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function files()
    {
        return $this->hasMany(CsmsPjoFile::class, 'pjo_id');
    }
}
