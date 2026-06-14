<?php

declare(strict_types=1);

namespace App\Enums\CSMS;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CsmsStatus extends Enum
{
    /* Published */
    const Publish               = 'Publish';
    const Draft                 = 'Draft';
    /* Published */

    /* Status */
    const Open                  = 'Open';
    const OnReviewOHS           = 'On Review OHS';
    const OnReviewDHOHS         = 'On Review D/H OHS';
    const OnReviewEvaluator     = 'On Review Evaluator';
    const OnReviewKTT           = 'On Review KTT';
    const Inactive              = 'Inactive';
    const Obsolate              = 'Obsolate';
    const Close                 = 'Closed';
    /* Status */

    /* Requested */
    const RequestedPica         = 'Requested PICA';
    const RequestedOHS          = 'Requested OHS';
    const RequestedDHOHS        = 'Requested D/H OHS';
    const RequestedEvaluator    = 'Requested Evaluator';
    const RequestedKTT          = 'Requested KTT';
    const Approved              = 'Approved';
    const Rejected              = 'Rejected';
    /* Requested */

    /* Criteria */
    const Bidding               = 'Bidding';
    const PostBidding           = 'Post Bidding';
    const Renewal               = 'Renewal';
    /* Criteria */

    /* Classification */
    const KontraktorUtama       = 'Kontraktor Utama';
    const KontraktorLangsung    = 'Kontraktor Langsung';
    const SubkontraktorTunggal  = 'Subkontraktor Tunggal';
    const KontraktorBersama     = 'Kontraktor Bersama';
    /* Classification */
}
