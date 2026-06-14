<?php

namespace App\Models\MainDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class RunningDate extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = "running_date";
    protected $fillable = [
        'day',
        'month',
        'month_name',
        'year',
    ];
}
