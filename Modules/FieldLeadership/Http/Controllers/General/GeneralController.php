<?php

namespace Modules\FieldLeadership\Http\Controllers\General;

use App\Enums\CompanyType;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\FieldLeadership\Transformers\General\AreaLocationResource;
use Modules\FieldLeadership\Transformers\General\AreaManagerResource;
use Modules\FieldLeadership\Transformers\General\CompanyResource;
use Modules\FieldLeadership\Transformers\General\DepartmentResource;
use Modules\FieldLeadership\Transformers\General\EmployeeResource;
use Modules\FieldLeadership\Transformers\General\SectionResource;
use Storage;

class GeneralController extends Controller
{
    public function getCcows(): AnonymousResourceCollection
    {
        $ccows = Company::where('type', CompanyType::Internal)->get();

        return CompanyResource::collection($ccows);
    }

    public function getCompanies(): AnonymousResourceCollection
    {
        $company = Company::all();

        return CompanyResource::collection($company);
    }

    public function getDepartments($id): AnonymousResourceCollection
    {
        $department = Department::where('company_id', $id)->get();

        return DepartmentResource::collection($department);
    }

    public function getSections($id): AnonymousResourceCollection
    {
        $section = Section::where('department_id', $id)->get();

        return SectionResource::collection($section);
    }

    public function getAreaLocations($id): AnonymousResourceCollection
    {
        $area_location = AreaLocation::where('section_id', $id)->get();

        return AreaLocationResource::collection($area_location);
    }

    public function getAreaManagers($id): AnonymousResourceCollection
    {
        $area_manager =  AreaManager::where('section_id', $id)->get();

        return AreaManagerResource::collection($area_manager);
    }

    public function getEmployees($id, $type): AnonymousResourceCollection
    {
        $employee = Employee::whereHas('user', function ($sql) use ($id, $type) {
            $sql->whereHas('department', function ($query) use ($id, $type) {
                $query->where('company_id', $id)
                    ->whereHas('company', function ($q) use ($type) {
                        $q->where('type', $type ?? null);
                    });
            });
        })->get();

        return EmployeeResource::collection($employee);
    }

    public function getMembers($type): AnonymousResourceCollection
    {
        $employee = Employee::whereHas('user', function ($sql) use ($type) {
            $sql->whereHas('department', function ($query) use ($type) {
                $query->whereHas('company', function ($q) use ($type) {
                    $q->where('type', $type);
                });
            });
        })
            ->get();

        return EmployeeResource::collection($employee);
    }

    public function getDetailCompany()
    {
        $type = CompanyType::asSelectArray();

        $data = [];
        foreach ($type as $key => $value) {
            $data[] = [
                'type' => $key
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function uploadFile()
    {
        $file = request()->file('file');
        $file_name = $file->getClientOriginalName();
        $file_size = $this->changeByte($file->getSize());
        $file_ext = $file->getClientOriginalExtension();

        $name = explode(' ', $file_name);
        $name = implode('_', $name);

        $path = Storage::disk('public')->putFileAs('temp-field-leadership/attachment', $file, $name);

        return response()->json([
            'status' => 'success',
            'data' =>
            [
                'path' => $path,
                'file_name' => $name,
                'file_size' => $file_size,
                'file_ext' => $file_ext,
            ]
        ]);
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
}
