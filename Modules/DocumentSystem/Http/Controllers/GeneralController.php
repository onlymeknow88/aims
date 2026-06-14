<?php

namespace Modules\DocumentSystem\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentCode;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\DocumentSystem\Entities\Document;

class GeneralController extends Controller
{
    public function invitedPeopleList(Request $request)
    {
        $data = Cache::get('peoples');
        if ($data) {
            $data = collect($data)->map(function ($item) {
                return [
                    'id' => $item->id,
                    'label' => $item->email,
                ];
            })->toArray();
        } else {
            $peoples = User::select('id', 'email')
                ->where('department_id', $request->input('department_id'))
                ->get();
            $data = Cache::remember('peoples', 600, function () use ($peoples) {
                return collect($peoples)->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'label' => $item->email,
                    ];
                })->all();
            });
        }

        return response()->json($data);
    }

    public function autocompleteSop(Request $request)
    {
        $department = DepartmentCode::find($request->input('department_id'));
        $dept_code = $department->code;
        $search = $request->term;
        $prefix = $department->department->company->document_code . '-' . $dept_code . '-';

        $documents = Document::where('department_id', $department->department_id)
            ->where('status', Document::ACTIVE)
            ->where('prefix_code', $prefix)
            ->where('sop_number', $search)
            ->where('parent_document', null)
            ->get();

        $documents = collect($documents)->map(function ($item) {
            return [
                'id' => $item->id,
                'label' => $item->prefix_code . $item->sop_number,
            ];
        })->all();
        $documents = array_map("unserialize", array_unique(array_map("serialize", $documents)));
        return response()->json($documents);
    }
}
