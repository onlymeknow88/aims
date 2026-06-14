<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PicaSource extends Enum
{
    // const IBPR              = 'IBPR & IADL';
    const FieldLeadership   = 'Field Leadership';
    const InspeksiKPLH      = 'Inspeksi KPLH';
    const Audit             = 'Audit';
}
