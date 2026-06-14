<?php declare(strict_types=1);

namespace Modules\Audit\Enums;

use BenSampo\Enum\Enum;

final class AuditCategory extends Enum
{
    const SMKP      = "SMKP";
    const SMK3      = "SMK3";
    const ISO45001  = "ISO45001";
    const ISO9001   = "ISO9001";
    const ISO14001  = "ISO14001";
}
