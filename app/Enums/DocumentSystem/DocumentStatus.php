<?php declare(strict_types=1);

namespace App\Enums\DocumentSystem;

use BenSampo\Enum\Enum;

/**
 * @method static static WaitingReview()
 * @method static static Return()
 * @method static static RoutingApproval()
 * @method static static Approved()
 * @method static static Obsolate()
 * @method static static Draft()
 */
final class DocumentStatus extends Enum
{
    const Draft             = 'DRAFT';
    const WaitingReview     = 'WAITING_REVIEW';
    const RoutingApproval   = 'ROUTING_APPROVAL';
    const Approved          = 'APPROVED';
    const Return            = 'RETURN';
    const Obsolate          = 'OBSOLATE';
    
}
