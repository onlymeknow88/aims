<?php declare(strict_types=1);

namespace App\Enums\KO;

use BenSampo\Enum\Enum;

/**
 * @method static static Draft()
 * @method static static Returned()
 * @method static static AdminProposalVerification()
 * @method static static CoordinatorProposalVerification()
 * @method static static Commissioning()
 * @method static static Issue()
 * @method static static CommissionerCommissioningVerification()
 * @method static static CoordinatorCommissioningVerification()
 * @method static static CommissioningReturned()
 * @method static static Completed()
 */
final class KoStatus extends Enum
{
    const Draft = 'Draft';
    const Returned = 'Returned';
    const AdminProposalVerification = 'Admin Proposal Verification';
    const CoordinatorProposalVerification = 'Coordinator Proposal Verification';
    const Commissioning = 'Commissioning in Progress';
    const Issue = 'Issue';
    const CommissionerCommissioningVerification = 'Commissioner Commissioning Verification';
    const CoordinatorCommissioningVerification = 'Coordinator Commissioning Verification';
    const CommissioningReturned = 'Commissioning Returned';
    const Completed = 'Completed';
}
