<?php declare(strict_types=1);

namespace App\Enums\KPP;

use BenSampo\Enum\Enum;

/**
 * @method static static Draft()
 * @method static static Submitted()
 */
final class ObedienceStatus extends Enum
{
    const Draft = 'Draft';
    const Submitted = 'Submitted';
}
