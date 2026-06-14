<?php declare(strict_types=1);

namespace App\Enums\MCU;

use BenSampo\Enum\Enum;


/**
 * @method static static Underweight()
 * @method static static Normal()
 * @method static static Overweight()
 * @method static static Obesitas1()
 * @method static static Obesitas2()
 */
final class NutritionCategory extends Enum
{
    const Underweight = 'Underweight';
    const Normal = 'Normal';
    const Overweight = 'Overweight';
    const Obesitas1 = 'Obesitas I';
    const Obesitas2 = 'Obesitas II';
}
