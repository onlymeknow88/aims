<?php

namespace App\Helpers;

use App\Enums\KPP\ExtractionStatus;
use App\Enums\KPP\ObedienceRequestStatus;
use Modules\KPP\Entities\KppExtraction;
use Modules\KPP\Entities\KppObedienceRequest;
use Modules\KPP\Entities\KppRule;
use Auth;

class KppHelper
{
    function getActivities()
    {
        return KppExtraction::whereIn('status', [ExtractionStatus::NotComply()->value, ExtractionStatus::Checking(), ExtractionStatus::InReview()])->get();
    }

    function obedienceRequestTotal()
    {
        return KppObedienceRequest::where('status', ObedienceRequestStatus::Requested()->value)
            ->count();
    }

    function draftRuleTotal()
    {
        return KppRule::where('is_draft', 1)
            ->count();
    }

    function extractionTotal($status)
    {
        return KppExtraction::where('status', ExtractionStatus::$status()->value)
            ->when($status == ExtractionStatus::Checking()->value, function ($query) {
                return $query->where('responsible_id', Auth::user()->id);
            })
            ->count();
    }

    function picaTotal()
    {
        return KppExtraction::where('status', ExtractionStatus::NotComply()->value)
            ->count();
    }
}




