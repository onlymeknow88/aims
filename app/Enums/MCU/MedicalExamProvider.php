<?php declare(strict_types=1);

namespace App\Enums\MCU;

use BenSampo\Enum\Enum;

/**
 * @method static static Framingham()
 * @method static static JakartaCardioVascular()
 */
final class MedicalExamProvider extends Enum
{
    const Framingham = 'Framingham Risk';
    const JakartaCardioVascular = 'Jakarta Cardiovascular';
}
