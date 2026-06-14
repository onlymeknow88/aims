<?php declare(strict_types=1);

namespace Modules\Audit\Enums;

use BenSampo\Enum\Enum;


final class AuditSmk3Level extends Enum
{
    const TINGKAT_AWAL      = 1;
    const TINGKAT_TRANSISI  = 2;
    const TINGKAT_LANJUTAN  = 3;
}
