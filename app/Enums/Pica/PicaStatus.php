<?php

declare(strict_types=1);

namespace App\Enums\Pica;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PicaStatus extends Enum
{
    const Open              = 'Open';
    const OnReviewPja       = 'On Review PJA';
    const OnReviewCrs       = 'On Review CRS';
    const Overdue           = 'Overdue';
    const Closed            = 'Closed';

    const NewRequest        = 'New Request';
    const RequestedPja      = 'Requested PJA';
    const RequestedCrs      = 'Requested CRS';
    const ReturnDocument    = 'Return Document';
    const Approved          = 'Approved';
    const Rejected          = 'Rejected';

    const Publish           = 'Publish';
    const Draft             = 'Draft';
}
