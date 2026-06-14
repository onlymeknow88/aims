<?php

namespace Modules\FieldLeadership\Http\Controllers\Master\TypeKta;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Modules\FieldLeadership\Transformers\Master\TypeKtaResource;

class TypeKtaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function getType(Request $request): AnonymousResourceCollection
    {
        if ($request->type == 'Kondisi Tidak Aman') {
            $type = FieldLeadershipKtaAndTta::where('type', 'KTA')->get();
        } else {
            $type = FieldLeadershipKtaAndTta::where('type', 'TTA')->get();
        }

        return TypeKtaResource::collection($type);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('fieldleadership::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('fieldleadership::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('fieldleadership::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
