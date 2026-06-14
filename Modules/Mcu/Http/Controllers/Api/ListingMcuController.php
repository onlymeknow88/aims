<?php

namespace Modules\Mcu\Http\Controllers\Api;

// use App\Enums\FieldLeadershipType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Transformers\Listing\FieldLeadershipDetailResource;
use Modules\FieldLeadership\Transformers\Listing\FieldLeadershipListResource;

class ListingMcuController extends Controller
{
    public function gelLists(): AnonymousResourceCollection
        {
            $Mcu = Mcu::whereIn('status', [McuType::Open, McuType::OnReviewPica])
                ->where('published', McuType::Publish)
                ->where('requested', McuType::Rejected)
                ->get();

            return McuListResource::collection($Mcu);

    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('mcu::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('mcu::create');
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
        return view('mcu::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('mcu::edit');
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
