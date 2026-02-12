<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommitteePositionResource;
use App\Models\Committee;
use App\Models\CommitteePosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommitteePositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CommitteePosition::query();
        if($request->has('office_id')) {
            $query->where('office_id', $request->office_id);
        }
        $committeePositions = $query->get();
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
            'is_active_position' => 1,
            'office_id' => auth()->user()->office_id
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

        $committeePosition = CommitteePosition::find($id);

        Gate::authorize('update', $committeePosition);

        $committeePosition->update([
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
        $committeePosition = CommitteePosition::find($id);

        $isUsed = Committee::where('committee_position_id', $committeePosition->id)->exists();
        if($isUsed) {
            return response()->json(['message' => 'This position is used in a committee.'], 403);
        }
        
        Gate::authorize('update', $committeePosition);
        
        $committeePosition->delete();
 
        return response()->noContent();
    }
}
