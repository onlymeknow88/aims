<?php

namespace Modules\KPP\Entities;

use App\Models\Company;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KppObedienceRequest extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function rule()
    {
        return $this->belongsTo(KppRule::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
