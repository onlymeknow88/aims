<?php

namespace Modules\KO\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Nicolaslopezj\Searchable\SearchableTrait;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KoProposal extends Model
{
    use HasFactory, HasUuids, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'created_at' => 0,
            //
        ],
        'joins' => [
            //
        ]
    ];

    protected static function newFactory()
    {
        return \Modules\KO\Database\factories\KoProposalFactory::new();
    }

    public function getQrCode()
    {
        $monthsToAdd = $this->koUnit->koSpipUnit->koSpipType->koSpipCategory->internal_interval_year * 12 / 2;

        //$newDate = $originalDate->addMonths($monthsToAdd);

        return base64_encode(QrCode::format('svg')
            ->size(326)
            ->errorCorrection('H')
            ->generate(
'PERUSAHAAN: ' . ($this->company->company_name ?? '-') . '
NO POLISI: ' . ($this->koUnit->identity_number ?? '-') . '
CALL SIGN: ' . ($this->koUnit->call_sign ?? '-') . '
KATEGORI SPIP: ' . ($this->koUnit->koSpipUnit->koSpipType->koSpipCategory->name ?? '-') . '
KLASIFIKASI SPIP: ' . ($this->koUnit->koSpipUnit->name ?? '-') . '
BRAND: ' . ($this->koUnit->koBrand->name ?? '-') . '
COMMISIONER: ' . ($this->koCommissioning->created_by ?? '-') . '
TAHUN PEMBUATAN: ' . ($this->koUnit->production_year ?? '-') . '
KOMISIONING INTERNAL SELAMBATNYA PADA: ' . (Carbon::parse($this->next_commissioning)->subMonths($monthsToAdd)->format('Y-m-d') ?? '-') . '
MASA BERLAKU: ' . ($this->status == 'Completed' ? ($this->next_commissioning ?? '-') : '-') . '
MASA BERLAKU SEMENTARA: ' . ($this->status == 'Completed' ? '-' : ($this->temporary_validity_period ?? '-')) . '
PERIODE KOMISIONING KE-: ' . ($this->commissioning_period ?? '-')
            )
        );
    }

    public function ccow(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'ccow_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function pjo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pjo_id');
    }

    public function koUnit(): BelongsTo
    {
        return $this->belongsTo(KoUnit::class);
    }

    public function koAttachment(): HasOne
    {
        return $this->hasOne(KoAttachment::class);
    }

    public function koCommissioning(): HasOne
    {
        return $this->hasOne(KoCommissioning::class);
    }

    public function koIssueReports(): HasMany
    {
        return $this->hasMany(KoIssueReport::class);
    }

    public function koQrRequestFiles(): HasMany
    {
        return $this->hasMany(KoQrRequestFiles::class);
    }
}
