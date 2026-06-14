<?php

namespace App\Models\IbprBowty;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class IadlTeam extends Model
{
    use HasUuids;
    protected $guarded = [];
    protected $table = 'iadl_teams';

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
