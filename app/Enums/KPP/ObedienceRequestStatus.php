<?php declare(strict_types=1);

namespace App\Enums\KPP;

use BenSampo\Enum\Enum;

/**
 * @method static static Requested()
 * @method static static Approved()
 * @method static static Rejected()
 */
final class ObedienceRequestStatus extends Enum
{
    const Requested = 'Requested';
    const Approved = 'Approved';
    const Rejected = 'Rejected';
}
