<?php

namespace Modules\KPP\Entities;

use App\Enums\KPP\ExtractionStatus;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Nicolaslopezj\Searchable\SearchableTrait;

class KppExtraction extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'extractions.date' => 2,
            //
        ],
        'joins' => [
            //
        ]
    ];

    public function obedience()
    {
        return $this->belongsTo(KppObedience::class, 'obedience_id');
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function files(): HasMany
    {
        return $this->HasMany(KppExtractionFile::class, 'extraction_id');
    }

    public function article()
    {
        return $this->belongsTo(KppArticle::class, 'article_id');
    }

    public function scopeExceptDraft($query)
    {
        return $query->whereNot('status', ExtractionStatus::Draft()->value);
    }

    public function scopeOnlyChecking($query)
    {
        return $query->where('status', ExtractionStatus::Checking()->value);
    }

    public function scopeOnlyInReview($query)
    {
        return $query->where('status', ExtractionStatus::InReview()->value);
    }

    public function getCompanySummaryProperty($company_id)
    {
        $data = new Collection();
        $obedience_ids = KppObedience::where('company_id', $company_id)->pluck('id');

        $data->total_extraction = KppExtraction::whereIn('obedience_id', $obedience_ids)->count();
        $data->patuh = KppExtraction::whereIn('obedience_id', $obedience_ids)->where('status', 'Patuh')->count();
        $data->tidak_patuh = KppExtraction::whereIn('obedience_id', $obedience_ids)->where('status', 'Tidak Patuh')->count();
        $data->tidak_berlaku = KppExtraction::whereIn('obedience_id', $obedience_ids)->where('status', 'Tidak Berlaku')->count();
        $data->in_progress = KppExtraction::whereIn('obedience_id', $obedience_ids)->whereIn('status', ['Draft','Checking','In Review'])->get()->count();

        return $data;
    }
}
