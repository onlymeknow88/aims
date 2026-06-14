<?php declare(strict_types=1);

namespace App\Enums\KPP;

use BenSampo\Enum\Enum;

/**
 * @method static static Draft()
 * @method static static Checking()
 * @method static static InReview()
 * @method static static UnderRevision()
 * @method static static Complied()
 * @method static static NotComply()
 * @method static static NotApplicable()
 */
final class ExtractionStatus extends Enum
{
    const Draft = 'Draft';
    const Checking = 'Checking';
    const InReview = 'In Review';
    const UnderRevision = 'Under Revision';
    const Complied = 'Patuh';
    const NotComply = 'Tidak Patuh';
    const NotApplicable = 'Tidak Berlaku';
}
