<?php

namespace App\Models\IbprBowty;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperIbprTeam
 */
class IbprTeam extends Model
{
    use HasUuids;
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
