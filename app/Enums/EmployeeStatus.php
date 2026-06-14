<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Candidate()
 * @method static static Active()
 * @method static static Inactive()
 */
final class EmployeeStatus extends Enum
{
    const Active = 'ACTIVE';
    const Inactive  = 'INACTIVE';
    const Candidate  = 'CANDIDATE';
}
