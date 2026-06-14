<?php declare(strict_types=1);

namespace App\Enums\MCU;

use BenSampo\Enum\Enum;

/**
 * @method static static Never()
 * @method static static Ex_smoker()
 * @method static static Smoker()
 */
final class SmokingStatus extends Enum
{
    const Never = Never;
    const Ex_smoker = Ex_smoker;
    const Smoker = Smoker;
}
