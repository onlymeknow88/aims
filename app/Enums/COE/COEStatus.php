<?php declare(strict_types=1);

namespace App\Enums\COE;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class COEStatus extends Enum
{
    const Draft         = 'DRAFT';
    const Pending       = 'PENDING';
    const Canceled      = 'CANCELED';
    const Done          = 'DONE';
}
