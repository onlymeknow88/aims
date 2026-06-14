<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Internal()
 * @method static static Contractor()
 * @method static static SubContractor()
 */
final class CompanyType extends Enum
{
    const Internal      = 'INTERNAL';
    const Contractor    = 'CONTRACTOR';
    const SubContractor = 'SUBCONTRACTOR';
}
