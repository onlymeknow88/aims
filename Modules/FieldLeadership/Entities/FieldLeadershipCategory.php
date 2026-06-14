<?php

namespace Modules\FieldLeadership\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class FieldLeadershipCategory extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'name' => 10,
        ],
    ];
}
