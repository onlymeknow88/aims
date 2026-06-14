<?php declare(strict_types=1);

namespace App\Enums\KO;

use BenSampo\Enum\Enum;

/**
 * @method static static AdminVerification()
 * @method static static CoordinatorVerification()
 * @method static static Revoked()
 */
final class UnitRevokeStatus extends Enum
{
    const AdminVerification = 'Under Admin Verification';
    const CoordinatorVerification = 'Under Coordinator Verification';
    const Revoked = 'Revoked';
}
