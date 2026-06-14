<?php declare(strict_types=1);

namespace App\Enums\MCU;

use BenSampo\Enum\Enum;

/**
 * @method static static No()
 * @method static static Low()
 * @method static static Medium()
 * @method static static High()
 */
final class ActivityStatus extends Enum
{
    const No = 'no';
    const Low = 'low';
    const Medium = 'medium';
    const High = 'high';
}
