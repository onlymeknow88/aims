<?php

namespace Modules\Mcu\Http\Livewire\Docs;

use App\Models\Company;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DB;
use Livewire\Component;
use Modules\Mcu\Entities\MedicalHistory;
use PDF;

class Publish extends Component
{
    public function printSkk($id)
    {
        // $now = Carbon::now();
        // $count = MedicalHistory::whereIn('doctor_status_review', array('Fit', 'Curently Unfit', 'Unfit'))
        //     ->where(DB::raw('YEAR(mcu_date)'), '=', $now->format('Y'))
        //     ->count();
        $mcu = MedicalHistory::with('employee', 'provider', 'doctor')->whereId($id)->first();

        $mcu_date = Carbon::parse($mcu->mcu_date);

        $count = $mcu->doctor_remark; // count

        $docNumber = 'SKK-' . (sprintf("%06d", ($count))) . '-AIMS-' . $mcu_date->format('m-y') . '';

        $data = [
            'docNumber' => $docNumber,
            'revision' => '0.0',
            'docDate' => $mcu_date->format('d-m-Y'),
            'letterNumber' => 'SKK/' . (sprintf("%06d", ($count))) . '/' . $mcu_date->format('Y') . '',
            'employeeName' => $mcu->employee->name,
            'employeeNIK' => $mcu->employee->id_number ? $mcu->employee->id_number : '',
            'employeeNRP' => $mcu->employee->number ? $mcu->employee->number : '',
            'employeeDepartment' => $mcu->employee->user->department_id ? $mcu->employee->user->department->name : '-',
            'employeeBd' => Carbon::parse($mcu->employee->date_of_birth)->format('d-m-Y'),
            'employeeAge' => Carbon::parse($mcu->employee->date_of_birth)->age,
            'company' => $mcu->employee->user->department_id ? $mcu->employee->user->department->company->company_name : '-',
            'position' => $mcu->employee->position ? $mcu->employee->position : '-',
            'doctor' => $mcu->doctor ? $mcu->doctor->name : '-',
            'mcuDate' => $mcu_date->format('d-m-Y'),
            'mcuProvider' => $mcu->provider ? $mcu->provider->name : '-',
            'medicalType' => ($mcu->medical_type == 'pre-employment') ? 'Pre Employment' : (($mcu->medical_type == 'periodic') ? 'Periodic' : 'Pre Retirement') ,
            'mcuCompanion' => '-',
            'mcuCompanionDept' => '-',
            'validFrom' => $mcu_date->format('d-m-Y'),
            'validUntil' => $mcu->mcu_exp_date ? Carbon::parse($mcu->mcu_exp_date)->format('d-m-Y') : '-',
            'note' => $mcu->doctor_suggestion,
            'status' => $mcu->doctor_status_review,
        ];
        // dd($data);

        $pdfContent = PDF::loadView('mcu::livewire.docs.print-skk', $data)->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "$docNumber.pdf"
        );
    }

    public function printSkkS($id)
    {
        // $now = Carbon::now();
        // $count = MedicalHistory::where('doctor_status_review', 'Fit With Recomendation')
        //     ->where(DB::raw('YEAR(mcu_date)'), '=', $now->format('Y'))
        //     ->count();
        $mcu = MedicalHistory::with('employee', 'provider', 'doctor')->whereId($id)->first();

        $mcu_date = Carbon::parse($mcu->mcu_date);

        $count = $mcu->doctor_remark; // count

        $docNumber = 'SKKs-' . (sprintf("%06d", ($count))) . '-AIMS-' . $mcu_date->format('m-y') . '';

        $data = [
            'docNumber' => $docNumber,
            'revision' => '0.0',
            'docDate' => $mcu_date->format('d-m-Y'),
            'letterNumber' => 'SKKs/' . (sprintf("%06d", ($count))) . '/' . $mcu_date->format('Y') . '',
            'employeeName' => $mcu->employee->name,
            'employeeBd' => Carbon::parse($mcu->employee->date_of_birth)->format('d-m-Y'),
            'employeeAge' => Carbon::parse($mcu->employee->date_of_birth)->age,
            'company' => $mcu->employee->user->department_id ? $mcu->employee->user->department->company->company_name : '-',
            'position' => $mcu->employee->position ? $mcu->employee->position : '-',
            'doctor' => $mcu->doctor ? $mcu->doctor->name : '-',
            'mcuDate' => $mcu_date->format('d-m-Y'),
            'mcuProvider' => $mcu->provider ? $mcu->provider->name : '-',
            'mcuCompanion' => '-',
            'mcuCompanionDept' => '-',
            'validFrom' => $mcu_date->format('d-m-Y'),
            'validUntil' => $mcu->mcu_date ? Carbon::parse($mcu->mcu_date)->addMonths(3)->format('d-m-Y') : '-',
            'note' => $mcu->doctor_suggestion,
            'status' => $mcu->doctor_status_review,
        ];

        $pdfContent = PDF::loadView('mcu::livewire.docs.print-skks', $data)->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "$docNumber.pdf"
        );
    }

    public function printReff($id)
    {
        // $now = Carbon::now();
        // $count = MedicalHistory::where('doctor_status_review', 'Curently Unfit')
        //     ->where(DB::raw('YEAR(mcu_date)'), '=', $now->format('Y'))
        //     ->count();
        $mcu = MedicalHistory::with('employee', 'provider', 'doctor')->whereId($id)->first();

        $mcu_date = Carbon::parse($mcu->mcu_date);

        $count = $mcu->doctor_remark; // count

        $docNumber = 'REFF-' . (sprintf("%06d", ($count))) . '-AIMS-' . $mcu_date->format('y') . '';

        $data = [
            'docNumber' => $docNumber,
            'revision' => '0.0',
            'docDate' => $mcu_date->format('d-m-Y'),
            'letterNumber' => 'REFF/' . (sprintf("%06d", ($count))) . '/AIMS/' . $mcu_date->format('Y') . '',
            'employeeName' => $mcu->employee->name,
            'employeeBd' => Carbon::parse($mcu->employee->date_of_birth)->format('d-m-Y'),
            'employeeAge' => Carbon::parse($mcu->employee->date_of_birth)->age,
            'employeeNIK' => $mcu->employee->id_number ? $mcu->employee->id_number : '',
            'employeeNRP' => $mcu->employee->number ? $mcu->employee->number : '',
            'company' => $mcu->employee->user->department_id ? $mcu->employee->user->department->company->company_name : '-',
            'position' => $mcu->employee->position ? $mcu->employee->position : '-',
            'doctor' => $mcu->doctor ? $mcu->doctor->name : '-',
            'mcuDate' => $mcu_date->format('d-m-Y'),
            'mcuType' => $mcu->medical_type,
            'mcuDiagnose' => $mcu->doctor_suggestion,
            'mcuResult' => $mcu->amc_matrix_compliance,
            'mcuProvider' => $mcu->provider ? $mcu->provider->name : '-',
            'mcuCompanion' => '-',
            'mcuCompanionDept' => '-',
            'validFrom' => $mcu_date->format('d-m-Y'),
            'validUntil' => $mcu->mcu_exp_date ? Carbon::parse($mcu->mcu_exp_date)->format('d-m-Y') : '-',
            'note' => $mcu->doctor_suggestion,
            'status' => $mcu->doctor_status_review,
        ];

        $pdfContent = PDF::loadView('mcu::livewire.docs.print-reff', $data)->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "$docNumber.pdf"
        );
    }

    public function downloadTemplateExcel()
    {
        $file = 'download-template-excel_v_1_1.xlsx';
        $check = Storage::exists($file);

        if ($check) {
            $file = storage_path($file);
            return response()->file($file);
        } else {
            return abort(404);
        }
    }

    public function render()
    {
        return view('mcu::livewire.docs.print-skk')->extends('mcu::layouts.no-header');
    }
}
