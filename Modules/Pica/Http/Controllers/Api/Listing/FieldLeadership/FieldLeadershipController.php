<?php

namespace Modules\Pica\Http\Controllers\Api\Listing\FieldLeadership;

use App\Enums\FieldLeadership\FieldLeadershipType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\Pica\Transformers\Listing\FieldLeadershipDetailResource;
use Modules\Pica\Transformers\Listing\FieldLeadershipListResource;

class FieldLeadershipController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function getFieldLeadership(): AnonymousResourceCollection
    {
        $fieldLeadership = FieldLeadership::whereIn('status', [FieldLeadershipType::Open, FieldLeadershipType::OnReviewPica])
            ->where('published', FieldLeadershipType::Publish)
            ->where('requested', FieldLeadershipType::Rejected)
            ->get();

        return FieldLeadershipListResource::collection($fieldLeadership);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('pica::create');
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
    public function detailFieldLeadership(FieldLeadership $fieldLeadership): FieldLeadershipDetailResource
    {
        return new FieldLeadershipDetailResource($fieldLeadership);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('pica::edit');
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
