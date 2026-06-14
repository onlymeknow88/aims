<?php declare(strict_types=1);

namespace App\Enums\MCU;

use BenSampo\Enum\Enum;

/**
 * @method static static A()
 * @method static static B()
 * @method static static AB()
 * @method static static O()
 */
final class BloodType extends Enum
{
    const A = 'A';
    const B = 'B';
    const AB = 'AB';
    const O = 'O';
}
