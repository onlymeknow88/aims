<?php

namespace App\Exports\Mcu;

use App\Models\Mcu\MedicalHistory;
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
// dd($data);
        return view('export.Mcu.MedicalHistory', compact('data'));
    }
}
