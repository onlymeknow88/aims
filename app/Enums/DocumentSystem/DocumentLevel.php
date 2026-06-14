<?php declare(strict_types=1);

namespace App\Enums\DocumentSystem;

use BenSampo\Enum\Enum;

/**
 * @method static static Manual()
 * @method static static Sop()
 * @method static static Ts()
 */
final class DocumentLevel extends Enum
{
    const Manual        = 'Manual';
    const Sop           = 'SOP';
    const Ts            = 'TS';
}
