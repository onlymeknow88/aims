<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as ModelsRole;

/**
 * @mixin IdeHelperRole
 */
class Role extends ModelsRole
{

}
