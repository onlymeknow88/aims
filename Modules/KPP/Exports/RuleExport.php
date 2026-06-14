<?php

namespace Modules\KPP\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\KPP\Entities\KppRule;

class RuleExport implements FromView, WithEvents
{
    protected $items;

    function __construct($items)
    {
        $this->items = $items;
    }

    public function view(): View
    {
        $rules = KppRule::whereIn('id', $this->items)->get();

        return view('kpp::livewire.rule.partials.excel', [
            'data' => $rules,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRangeHeader = 'A3:W3'; // All headers
                $cellRangeContent = 'A3:W500'; // All headers
                $event->sheet->getStyle($cellRangeContent)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
