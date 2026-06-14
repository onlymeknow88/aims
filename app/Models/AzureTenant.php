<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AzureTenant extends Model
{
    protected $fillable = [
        'name', 'tenant_id', 'client_id',
        'client_secret', 'redirect_uri',
        'allowed_domains', 'is_active',
    ];

    protected $hidden = ['client_secret'];

    protected $casts = [
        'allowed_domains' => 'array',
        'is_active'       => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
