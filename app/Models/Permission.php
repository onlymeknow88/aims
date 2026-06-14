<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as ModelsPermission;

/**
 * @mixin IdeHelperPermission
 */
class Permission extends ModelsPermission
{
    use HasUuids;
}
