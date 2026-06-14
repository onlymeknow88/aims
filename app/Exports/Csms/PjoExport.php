<?php

namespace App\Exports\Csms;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Modules\CSMS\Entities\CsmsPjo;

class PjoExport implements FromView, WithEvents
{
    protected $items;

    function __construct($items)
    {
        $this->items = $items;
    }

    public function view(): View
    {
        $csms = CsmsPjo::whereIn('id', $this->items)->get();

        $data = [];

        foreach ($csms as $key => $value) {
            $data[] = [
                'company' => $value->company->company_name ?? null,
                'criteria' => $value->criteria ?? null,
                'ccow' => $value->ccow->company_name ?? null,
                'submission' => $value->submission ?? null,
                'number' => $value->number_pjo ?? null,
                'name' => $value->name ?? null,
                'date_of_birth' => $value->date_of_birth ?? null,
                'phone' => $value->phone ?? null,
                'email' => $value->email ?? null,
                'status' => $value->status ?? null,
            ];
        }

        return view('csms::livewire.pjo.excel.pjo', [
            'data' => $data
        ]);
    }

    public function registerEvents(): array
    {
        return [];
    }
}
