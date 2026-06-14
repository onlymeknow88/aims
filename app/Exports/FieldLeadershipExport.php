<?php

namespace App\Exports;

use App\Models\FieldLeadership;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use App\Models\ProductTierVariation;
use Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;

class FieldLeadershipExport implements FromView, WithEvents
{
    protected $items;

    function __construct($items)
    {
        $this->items = $items;
    }

    public function view(): View
    {
        $field = FieldLeadershipRisk::whereHas('fieldLeadership', function ($query) {
            $query->whereIn('fl_id', $this->items);
        })
            ->get();

        // $field = FieldLeadership::whereIn('id', $this->items)->get();

        $data = [];
        $risk_conditions = [];
        foreach ($field as $key => $value) {

            // Member
            $members = [];
            foreach ($value->fieldleadership->members as $key => $member) {
                $members[] = $member->employee->name ?? null;
            }

            // Positive Condition
            $positive_conditions = [];
            foreach ($value->fieldleadership->positives as $key => $positive_condition) {
                $positive_conditions[] = $positive_condition->description ?? null;
            }

            // Risk Condition
            // foreach ($value->risks as $key => $risk_condition) {
            $risk_conditions[] = [
                'risk_condition' => $value->risk_condition ?? null,
                'category' => $value->category->name ?? null,
                'potency' => $value->potency->name ?? null,
                'repair_action' => $value->repair_action ?? null,
                'due_date' => Carbon::parse($value->due_date)->format('F d, Y') ?? null,
            ];
            // }


            $data[] = [
                'Date' => Carbon::parse($value->created_at)->format('F d, Y'),
                'CCOW' => $value->fieldleadership->ccow->company_name,
                'Company' => $value->fieldleadership->company->company_name,
                'DetailCompany' => $value->fieldleadership->detail_company,
                'Department' => $value->fieldleadership->department->name,
                'Section' => $value->fieldleadership->section->name,
                'Location' => $value->fieldleadership->areaLocation->name,
                'DetailLocation' => $value->fieldleadership->detail_location,
                'Type' => $value->fieldleadership->type,
                'CreatedBy' => $value->fieldleadership->createdBy->name,
                'Members' => $members,
                'PositiveCondition' => $positive_conditions,
                'RiskCondition' => $risk_conditions,
                'pja' => $value->fieldleadership->pja->user->name,
                'Status' => $value->fieldleadership->status,
            ];
        }

        // dd($data);

        return view('livewire.field-leadership.listing.active.partials.excel', [
            'data' => $data,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRangeHeader = 'A3:W3'; // All headers
                $cellRangeContent = 'A3:W500'; // All headers
                $event->sheet->getStyle($cellRangeContent)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
