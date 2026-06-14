<?php

namespace App\Models\IbprBowty;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperIbprMasterHirarki
 */
class IbprMasterHirarki extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'ibpr_master_hirarki';

}
