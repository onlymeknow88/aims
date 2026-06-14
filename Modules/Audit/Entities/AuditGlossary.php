<?php

namespace Modules\Audit\Entities;


use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AuditGlossary extends Model
{
    use HasUuids;
    protected $guarded = [];

    
}
