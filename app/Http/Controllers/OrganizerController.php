<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizerRequest;
use App\Http\Resources\Organizer\OrganizerCollection;
use App\Http\Resources\Organizer\OrganizerResource;
use App\Model\Organizer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return OrganizerCollection::collection(Organizer::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * @param OrganizerRequest $request
     */
    public function store(OrganizerRequest $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param Organizer $organizer
     * @return OrganizerResource
     */
    public function show(Organizer $organizer)
    {
        return new OrganizerResource($organizer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Organizer $organizer
     * @return \Illuminate\Http\Response
     */
    public function edit(Organizer $organizer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Organizer $organizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizer $organizer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Organizer $organizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organizer $organizer)
    {
        $this->destroy($organizer);
        return response()->json('deleted');
    }
}
