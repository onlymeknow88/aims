<?php declare(strict_types=1);

namespace Modules\Audit\Enums;

use BenSampo\Enum\Enum;

final class BundleStatusEnum extends Enum
{
    const DRAFT = 'Draft';
    const ON_GOING = 'On Progress';
    const NEED_REVIEW = 'Need Review';
    const IN_REVIEW = 'In Review';
    const APPROVED = 'Approved';
    const REJECTED = 'Rejected';
    const REJECTED_WITH_NOTES = 'Rejected With Notes';

}
