<?php declare(strict_types=1);

namespace App\Enums\KPP;

use BenSampo\Enum\Enum;

/**
 * @method static static N()
 * @method static static IA()
 * @method static static IIA()
 * @method static static IIIA()
 * @method static static IIIB()
 */
final class ComplianceLevel extends Enum
{
    const N = 'N';
    const IA = 'IA';
    const IIA = 'IIA';
    const IIIA = 'IIIA';
    const IIIB = 'IIIB';
}
