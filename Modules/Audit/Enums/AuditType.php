<?php declare(strict_types=1);

namespace Modules\Audit\Enums;

use BenSampo\Enum\Enum;


final class AuditType extends Enum
{
    const INTERNAL="Audit Internal";
    const EXTERNAL="Audit External";
}
