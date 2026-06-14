<?php

namespace Modules\Kplh\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Pica\Entities\Pica;
use Modules\Pica\Entities\PicaDocument;
use Modules\Pica\Entities\PicaFile;

class InspectionRisks extends Model
{
    use HasUuids;

    protected $table = 'kplh_inspection_risks';

    protected $guarded = [];

    public function kplh_data()
    {
        return $this->belongsTo(InspectionData::class, 'kplh_data_id');
    }

    public function pica()
    {
        return $this->belongsTo(PicaDocument::class, 'pica_id');
    }

    public function picaFiles()
    {
        return $this->hasMany(PicaFile::class, 'pica_id');
    }

    // public function picaable()
    // {
    //     return $this->morphOne(Pica::class, 'picaable');
    // }
}
