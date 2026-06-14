<?php

namespace App\Exports\Audit;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AuditCriteriaExport implements FromView
{
    private $audit;
    private $availableMethods;
    private $available_sub_criteria;

    public function __construct($audit, $availableMethods, $available_sub_criteria)
    {
        $this->audit = $audit;
        $this->availableMethods = $availableMethods;
        $this->available_sub_criteria = $available_sub_criteria;
    }

    public function view(): View
    {
        return view('audit::livewire.criteria-audit.export', [
            'audit' => $this->audit,
            'availableMethods' => $this->availableMethods,
            'available_sub_criteria' => $this->available_sub_criteria
        ]);
    }
}
