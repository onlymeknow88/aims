<?php

namespace Modules\CSMS\Entities;

use App\Models\Company;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CsmsLetter extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'letter_number',
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
        return $this->hasMany(CsmsLetterFile::class);
    }
}
