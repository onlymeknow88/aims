<?php

namespace Modules\KPP\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KppExtractionFile extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];
}
