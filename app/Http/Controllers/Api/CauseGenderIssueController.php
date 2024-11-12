<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CauseGenderIssueResource;
use App\Models\CauseGenderIssue;
use Illuminate\Http\Request;

class CauseGenderIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $causegenderissues = CauseGenderIssue::all();
        return CauseGenderIssueResource::collection($causegenderissues);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cause' => ['required'],
        ]);

        $causegenderissue = CauseGenderIssue::create([
            'cause' => $request->cause,
            'is_active_cause' => 1
        ]);

        return new CauseGenderIssueResource($causegenderissue);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new CauseGenderIssueResource(CauseGenderIssue::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cause' => ['required'],
            'is_active_cause' => ['required'],
        ], [
            'is_active_cause.required' => 'The status field is required.'
        ]);

        $causegenderissue_updated = CauseGenderIssue::find($id)->update([
            'cause' => $request->cause,
            'is_active_cause' => $request->is_active_cause,
        ]);

        $causegenderissue = CauseGenderIssue::find($id);

        return new CauseGenderIssueResource($causegenderissue);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $causegenderissue = CauseGenderIssue::find($id)->delete();
 
        return response()->noContent();
    }
}
