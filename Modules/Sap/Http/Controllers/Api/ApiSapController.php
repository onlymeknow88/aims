<?php

namespace Modules\Sap\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sap\Entities\SapMonthlyCategory;
use App\Access\dateSetup;


class ApiSapController extends Controller
{
    public function PersonalData(request $request)
    {
        $search = $request->get('search');
        $year = $request->get('year') ? $request->get('year') : date('Y');
        //MONTH
        $month = $request->get('months');
        $monthArray = explode(",", $month);
        if (count($monthArray) > 0 && $month != null) {
            $months = dateSetup::month($year);
            $months = collect($months)->whereIn('month', $monthArray);
            $months = $months->values()->all();
        } else {
            $month = dateSetup::month($year);
            $months =  $month;
        }

        //dept
        $departments = $request->get('departments') ? $request->get('departments') : null;
        $departments = $departments ? (explode(",", $departments)) : [];

        //grade 
        $grades = $request->get('grades') ? $request->get('grades') : null;
        $grades = $grades ? explode(",",  $grades) : [];

        $getData = SapMonthlyCategory::orderby('created_at', 'ASC')
            ->has('employeeList')
            ->with(['employeeList' => function ($q) use ($search, $year, $months, $departments, $grades) {
                $employee = $q->leftjoin('sap_monthly', function ($join) use ($year, $search) {
                    $join->on('sap_monthly.employee_id', '=', 'sap_monthly_employee.id')
                        ->where('sap_monthly.year', '=', $year);
                });

                if ($search) {
                    $employee = $employee->where('sap_monthly_employee.name', 'like', '%' . $search . '%');
                }
                if (count($departments) > 0) {
                    $employee = $employee->whereIn('sap_monthly_employee.code', $departments);
                }
                if (count($grades) > 0) {
                    $employee = $employee->whereIn('sap_monthly_employee.grade_code', $grades);
                }

                $employee = $employee->selectRaw("
                        sap_monthly_employee.*,
                        sap_monthly.*,
                        sap_monthly_employee.id as id_employee
                    ");

                //JIKA 0.00 TAMPIL BLANK
                foreach ($months as $list) {
                    $x = $list['month_name'];
                    $employee =  $employee->selectRaw("
                           CASE
                               WHEN sap_monthly.$x = '0.00' THEN ''
                               ELSE sap_monthly.$x
                           END AS $x
                        ");
                }
            }])
            ->get();

        $data = json_decode($getData, true);

        return [
            'filter' => $departments,
            'data' => $data
        ];
    }
}


