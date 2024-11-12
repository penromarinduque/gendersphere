<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommitteePositionResource;
use App\Models\CommitteePosition;
use Illuminate\Http\Request;

class CommitteePositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $committeePositions = CommitteePosition::all();
        return CommitteePositionResource::collection($committeePositions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'position_title' => ['required'],
        ]);

        $committeePosition = CommitteePosition::create([
            'position_title' => $request->position_title,
            'is_active_position' => 1
        ]);

        return new CommitteePositionResource($committeePosition);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new CommitteePositionResource(CommitteePosition::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'position_title' => ['required'],
            'is_active_position' => ['required'],
        ], [
            'is_active_position.required' => 'The status field is required.'
        ]);

        $committeePosition_updated = CommitteePosition::find($id)->update([
            'position_title' => $request->position_title,
            'is_active_position' => $request->is_active_position,
        ]);

        $committeePosition = CommitteePosition::find($id);

        return new CommitteePositionResource($committeePosition);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $committeePosition = CommitteePosition::find($id)->delete();
 
        return response()->noContent();
    }
}
