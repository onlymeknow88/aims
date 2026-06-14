<?php declare(strict_types=1);

namespace Modules\Audit\Enums;

use BenSampo\Enum\Enum;

final class ScheduleActivityType extends Enum
{
    const OPENING = 'pembukaan';
    const ACTIVITY = 'aktivitas';
    const ISOMA = 'isoma';
    const FREE_TEXT = 'keterangan bebas';
    const CLOSING = 'penutupan';
}
