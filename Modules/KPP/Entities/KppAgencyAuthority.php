<?php

namespace Modules\KPP\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KppAgencyAuthority extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];
}
