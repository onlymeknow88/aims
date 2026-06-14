<?php declare(strict_types=1);

namespace App\Enums\MCU;

use BenSampo\Enum\Enum;

/**
 * @method static static PreEmployment()
 * @method static static Employment()
 * @method static static OptionThree()
 */
final class MedicalExamType extends Enum
{
    const PreEmployment = 0;
    const Employment = 1;
    const OptionThree = 2;
}
