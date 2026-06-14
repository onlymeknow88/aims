<?php declare(strict_types=1);

namespace App\Enums\MCU;

use BenSampo\Enum\Enum;

/**
 * @method static static Candidate()
 * @method static static Employee()
 */
final class EmployeeStatus extends Enum
{
    const Candidate = 'CANDIDATE';
    const Employee  = 'EMPLOYEE';
}
