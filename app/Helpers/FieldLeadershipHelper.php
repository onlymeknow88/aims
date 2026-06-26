<?php

namespace App\Helpers;

use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Models\AreaManager;
use Modules\FieldLeadership\Entities\FieldLeadership;

class FieldLeadershipHelper
{
    function totalRequestPjaPublished()
    {
        $areaManager = AreaManager::where('user_id', auth()->user()->id)->get()->pluck('id');

        return FieldLeadership::where('requested', FieldLeadershipType::RequestedPja)
            ->where('published', FieldLeadershipType::Publish)
            ->where('status',  FieldLeadershipType::Open)
            ->whereIn('pja_id', $areaManager)
            ->count();
    }

    function totalRequestPjaDrafted()
    {
        $areaManager = AreaManager::where('user_id', auth()->user()->id)->get()->pluck('id');

        return FieldLeadership::where('requested', FieldLeadershipType::RequestedPja)
            ->where('published', FieldLeadershipType::Draft)
            ->where('status',  FieldLeadershipType::Open)
            ->whereIn('pja_id', $areaManager)
            ->count();
    }

    function totalRequestApproval()
    {
        $isSuperAdmin = auth()->user()->hasRole('Field Leadership - Super Admin', 'field-leadership') || auth()->user()->can('Field Leadsership - Delete');

        return FieldLeadership::where('requested', FieldLeadershipType::RequestedApproval)
            ->where('published', FieldLeadershipType::Publish)
            ->when(!$isSuperAdmin, function ($query) {
                $query->whereHas('company', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
            })
            ->count();
    }
}
