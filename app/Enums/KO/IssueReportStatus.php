<?php declare(strict_types=1);

namespace App\Enums\KO;

use BenSampo\Enum\Enum;

/**
 * @method static static Open()
 * @method static static Returned()
 * @method static static AdminVerification()
 * @method static static CoordinatorVerification()
 * @method static static Solved()
 */
final class IssueReportStatus extends Enum
{
    const Open = 'Open';
    const Returned = 'Returned';
    const AdminVerification = 'Under Admin Verification';
    const CoordinatorVerification = 'Under Coordinator Verification';
    const Solved = 'Solved';
}
