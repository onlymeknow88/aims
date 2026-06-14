<?php

namespace Modules\Mcu\Exports;

use Modules\Mcu\Entities\MedicalHistory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MedicalHistoryExport implements FromView, ShouldAutoSize
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $data = MedicalHistory::with('employee')->whereIn('id', $this->id)->get();
        return view('mcu::export.MedicalHistory', compact('data'));
    }
}
