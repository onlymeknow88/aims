<?php

namespace Modules\FieldLeadership\Http\Controllers\Listing\Pja;

use App\Enums\FieldLeadership\FieldLeadershipType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Transformers\Listing\FieldLeadershipListResource;

class PjaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function getFieldLeadershipPja(): AnonymousResourceCollection
    {
        $fieldLeadership = FieldLeadership::where('published', FieldLeadershipType::Publish)
            ->whereIn('status', [FieldLeadershipType::Open, FieldLeadershipType::OnReviewPja])
            ->get();

        return FieldLeadershipListResource::collection($fieldLeadership);
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
