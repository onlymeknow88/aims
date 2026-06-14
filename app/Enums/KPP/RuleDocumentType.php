<?php declare(strict_types=1);

namespace App\Enums\KPP;

use BenSampo\Enum\Enum;

/**
 * @method static static ENV()
 * @method static static OHS()
 * @method static static ALL()
 */
final class RuleDocumentType extends Enum
{
    const ENV = 'ENV';
    const OHS = 'OHS';
}
