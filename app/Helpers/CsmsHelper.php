<?php

namespace App\Helpers;

use App\Enums\CSMS\CsmsStatus;
use Modules\CSMS\Entities\Bidding;
use Modules\CSMS\Entities\CsmsPjo;

class CsmsHelper
{
    function totalApprovalBidding()
    {
        $count = Bidding::whereIn('criteria', [
            CsmsStatus::Bidding
        ])->whereIn('status', [
            CsmsStatus::OnReviewOHS,
            CsmsStatus::OnReviewDHOHS,
            CsmsStatus::OnReviewKTT,
        ])->whereIn('requested', [
            CsmsStatus::Approved,
            CsmsStatus::RequestedOHS,
            CsmsStatus::RequestedDHOHS,
            CsmsStatus::RequestedKTT,
        ])->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Bidding Reviewer OHS')) {
            return $count->count();
        } else {
            return $count->where('maker_id', auth()->user()->id)->count();
        }
    }

    function totalApprovalPostBidding()
    {
        $count = Bidding::whereIn('criteria', [
            CsmsStatus::PostBidding,
            CsmsStatus::Renewal,
            CsmsStatus::Inactive,
        ])->whereIn('status', [
            CsmsStatus::OnReviewOHS,
            CsmsStatus::OnReviewDHOHS,
            CsmsStatus::OnReviewKTT,
        ])->whereIn('requested', [
            CsmsStatus::Approved,
            CsmsStatus::RequestedOHS,
            CsmsStatus::RequestedDHOHS,
            CsmsStatus::RequestedDHOHS,
        ])->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Post Bidding Reviewer OHS') || auth()->user()->hasPermissionTo('CSMS - Post Bidding Reviewer D/H OHS') || auth()->user()->hasPermissionTo('CSMS - Post Bidding Reviewer KTT')) {
            return $count->count();
        } else {
            return $count->where('maker_id', auth()->user()->id)->count();
        }
    }

    function totalRequestBidding()
    {
        $count = Bidding::where('criteria', CsmsStatus::Bidding)
            ->whereIn('requested', [CsmsStatus::RequestedOHS, CsmsStatus::RequestedDHOHS, CsmsStatus::RequestedKTT])
            ->whereNotIn('status', [CsmsStatus::Approved, CsmsStatus::Obsolate])
            ->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Bidding Reviewer OHS') || auth()->user()->hasPermissionTo('CSMS - Bidding Reviewer D/H OHS') || auth()->user()->hasPermissionTo('CSMS - Bidding Reviewer KTT')) {
            $count = $count->count();
        } else {
            $count = $count->where('maker_id', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalActiveBidding()
    {
        $count = Bidding::where('criteria', CsmsStatus::Bidding)
            ->where('status', CsmsStatus::Approved)
            ->where('requested', CsmsStatus::Approved)
            ->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Bidding View Active')) {
            $count = $count->count();
        } else {
            $count = $count->where('maker_id', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalOnGoingBidding()
    {
        $count = Bidding::where('criteria', CsmsStatus::Bidding)->whereIn('status', [
            CsmsStatus::OnReviewOHS,
            CsmsStatus::OnReviewDHOHS,
            CsmsStatus::OnReviewKTT,
        ])->whereIn('requested', [
            CsmsStatus::RequestedOHS,
            CsmsStatus::RequestedDHOHS,
            CsmsStatus::RequestedKTT,
            CsmsStatus::Rejected,
            CsmsStatus::Approved,
        ])->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Bidding View On Going')) {
            $count = $count->count();
        } else {
            $count = $count->where('maker_id', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalDraftBidding()
    {
        $count = Bidding::where('criteria', CsmsStatus::Bidding)
            ->where('status', CsmsStatus::Draft)
            ->where('requested', CsmsStatus::Draft)
            ->where('published', CsmsStatus::Draft);

        if (auth()->user()->hasPermissionTo('CSMS - Bidding View Draft')) {
            $count = $count->count();
        } else {
            $count = $count->where('maker_id', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalRequestPostBidding()
    {
        $count = Bidding::whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])
            ->whereIn('requested', [CsmsStatus::RequestedOHS, CsmsStatus::RequestedDHOHS, CsmsStatus::RequestedKTT])
            ->whereNotIn('status', [CsmsStatus::Approved, CsmsStatus::Obsolate])
            ->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Post Bidding Reviewer OHS') || auth()->user()->hasPermissionTo('CSMS - Post Bidding Reviewer D/H OHS') || auth()->user()->hasPermissionTo('CSMS - Post Bidding Reviewer KTT')) {
            $count = $count->count();
        } else {
            $count = $count->where('maker_id', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalActivePostBidding()
    {
        $count = Bidding::whereIn('criteria', [
            CsmsStatus::PostBidding,
            CsmsStatus::Renewal,
            CsmsStatus::Inactive,
        ])
            ->whereIn('status', [CsmsStatus::Approved])
            ->whereIn('requested', [CsmsStatus::Approved])
            ->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Post Bidding View Active')) {
            $count = $count->count();
        } else {
            $count = $count->where('maker_id', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalOnGoingPostBidding()
    {
        $count = Bidding::whereIn('criteria', [
            CsmsStatus::PostBidding,
            CsmsStatus::Renewal,
            CsmsStatus::Inactive,
        ])
            ->whereIn('status', [
                CsmsStatus::OnReviewOHS,
                CsmsStatus::OnReviewDHOHS,
                CsmsStatus::OnReviewKTT,
            ])
            ->whereIn('requested', [
                CsmsStatus::RequestedOHS,
                CsmsStatus::RequestedDHOHS,
                CsmsStatus::RequestedKTT,
                CsmsStatus::Rejected,
                CsmsStatus::Approved,
            ])
            ->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Post Bidding View On Going')) {
            $count = $count->count();
        } else {
            $count = $count->where('maker_id', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalDraftPostBidding()
    {
        $count = Bidding::whereIn('criteria', [
            CsmsStatus::PostBidding,
            CsmsStatus::Renewal,
            CsmsStatus::Inactive,
        ])
            ->where('status', CsmsStatus::Draft)
            ->where('requested', CsmsStatus::Draft)
            ->where('published', CsmsStatus::Draft);

        if (auth()->user()->hasPermissionTo('CSMS - Post Bidding View Draft')) {
            $count = $count->count();
        } else {
            $count = $count->where('maker_id', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalPica()
    {
        $count = CsmsPjo::whereIn('requested', [CsmsStatus::RequestedOHS, CsmsStatus::RequestedDHOHS, CsmsStatus::RequestedKTT])
            ->where('status', CsmsStatus::Rejected)
            ->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Pica View Active') || auth()->user()->hasPermissionTo('CSMS - Pica View On Going') || auth()->user()->hasPermissionTo('CSMS - Pica View Draft')) {
            $count = $count->count();
        } else {
            $count = $count->where('created_by', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalRequestPJO()
    {
        $count = CsmsPjo::whereIn('requested', [CsmsStatus::RequestedOHS, CsmsStatus::RequestedEvaluator, CsmsStatus::RequestedKTT])
            ->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Pjo Reviewer OHS') || auth()->user()->hasPermissionTo('CSMS - Pjo Reviewer Evaluator') || auth()->user()->hasPermissionTo('CSMS - Pjo Reviewer KTT')) {
            $count = $count->count();
        } else {
            $count = $count->where('created_by', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalPJOActive()
    {
        $count = CsmsPjo::where('status', CsmsStatus::Approved)
            ->where('published', CsmsStatus::Publish);

        if (auth()->user()->hasPermissionTo('CSMS - Pjo View Active')) {
            $count = $count->count();
        } else {
            $count = $count->where('created_by', auth()->user()->id)->count();
        }

        return $count;
    }

    function totalPJODraft()
    {
        $count = CsmsPjo::where('published', CsmsStatus::Draft);

        if (auth()->user()->hasPermissionTo('CSMS - Pjo View Draft')) {
            $count = $count->count();
        } else {
            $count = $count->where('created_by', auth()->user()->id)->count();
        }

        return $count;
    }
}
