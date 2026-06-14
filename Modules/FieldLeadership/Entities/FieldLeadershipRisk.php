<?php

namespace Modules\FieldLeadership\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Pica\Entities\Pica;
use Modules\Pica\Entities\PicaDocument;
use Modules\Pica\Entities\PicaFile;

class FieldLeadershipRisk extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function fieldLeadership()
    {
        return $this->belongsTo(FieldLeadership::class, 'fl_id');
    }

    public function files()
    {
        return $this->hasMany(FieldLeadershipRiskFile::class, 'fl_risk_id');
    }

    public function category()
    {
        return $this->belongsTo(FieldLeadershipCategory::class, 'category_id');
    }

    public function type()
    {
        return $this->belongsTo(FieldLeadershipKtaAndTta::class, 'type_id');
    }

    public function potency()
    {
        return $this->belongsTo(FieldLeadershipPotencyAndConsequnce::class, 'potency_id');
    }

    public function pica()
    {
        return $this->belongsTo(PicaDocument::class, 'pica_id');
    }

    public function picaFiles()
    {
        return $this->hasMany(PicaFile::class, 'pica_id');
    }

    public function picaable()
    {
        return $this->morphOne(Pica::class, 'picaable');
    }
}
