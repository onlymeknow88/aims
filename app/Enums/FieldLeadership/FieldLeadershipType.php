<?php

declare(strict_types=1);

namespace App\Enums\FieldLeadership;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FieldLeadershipType extends Enum
{
    const Internal          = 'Internal';
    const External          = 'Eksternal';

    const KTA               = 'Kondisi Tidak Aman';
    const TTA               = 'Tindakan Tidak Aman';
    const NotApplicable     = 'Tak Dapat Diterapkan';

    const Publish           = 'Publish';
    const Draft             = 'Draft';

    const Open              = 'Open';
    const OnReviewPica      = 'On Review PICA';
    const OnReviewPja       = 'On Review PJA';
    const OnReviewApproval  = 'On Review Approval';
    const Overdue           = 'Overdue';
    const Close             = 'Closed';

    const RiskFinding       = 'Temuan Risiko';
    const CorrectiveAction  = 'Tindakan Perbaikan';

    const RequestedPja      = 'Requested PJA';
    const RequestedApproval = 'Requested Approval';
    const Approved          = 'Approved';
    const Rejected          = 'Rejected';
}
