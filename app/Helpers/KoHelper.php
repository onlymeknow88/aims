<?php

namespace App\Helpers;

use App\Enums\KO\IssueReportStatus;
use App\Enums\KO\KoStatus;
use App\Enums\KO\UnitRevokeStatus;
use Auth;
use Modules\KO\Entities\KoIssueReport;
use Modules\KO\Entities\KoProposal;
use Modules\KO\Entities\KoUnit;

class KoHelper
{
    function draftTotal()
    {
        return KoProposal::where('status', KoStatus::Draft()->value)
            ->where(function ($query) {
                $query->where('ccow_id', Auth::user()->department->company->id)
                    ->orWhere('company_id', Auth::user()->department->company->id);
            })
            ->count();
    }

    function returnedTotal()
    {
        return KoProposal::where('status', KoStatus::Returned()->value)
            ->where(function ($query) {
                $query->where('ccow_id', Auth::user()->department->company->id)
                    ->orWhere('company_id', Auth::user()->department->company->id);
            })
            ->count();
    }

    function adminVerificationTotal()
    {
        return KoProposal::where('status', KoStatus::AdminProposalVerification()->value)
            ->count();
    }

    function coordinatorVerificationTotal()
    {
        return KoProposal::where('status', KoStatus::CoordinatorProposalVerification()->value)
            ->count();
    }

    function commissioningTotal()
    {
        return KoProposal::where('status', KoStatus::Commissioning()->value)
            ->count();
    }

    function reportIssueTotal($status)
    {
        return KoIssueReport::where('status', IssueReportStatus::$status()->value)
            ->count();
    }


    function proposalTotal($status)
    {
        return KoProposal::where('status', KoStatus::$status()->value)
            ->count();
    }

    function revokeRequestTotal($status)
    {
        return KoUnit::where('revoke_status', UnitRevokeStatus::$status()->value)
            ->count();
    }

    function qrRequestTotal()
    {
        return KoProposal::where('temporary_qr_status', 'Coordinator Verification')->get()
            ->count();
    }
}




