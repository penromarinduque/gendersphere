<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CauseGenderIssueResource;
use App\Models\CauseGenderIssue;
use App\Models\PlanBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CauseGenderIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CauseGenderIssue::query();
        if($request->has('office_id')) {
            $query->where('office_id', $request->office_id);
        }
        $causegenderissues = $query->get();
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
            'is_active_cause' => 1,
            'office_id' => auth()->user()->office_id
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

        $causegenderissue = CauseGenderIssue::find($id);
        Gate::authorize('update', $causegenderissue);
        $causegenderissue->update([
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
        $causegenderissue = CauseGenderIssue::find($id);
        $isUsed = PlanBudget::where('cause_gender_issue_id', $causegenderissue->id)->exists();
        if($isUsed) {
            return response()->json(['message' => 'This cause is used in a plan budget.'], 400);
        }
        Gate::authorize('delete', $causegenderissue);
        $causegenderissue->delete();
 
        return response()->noContent();
    }
}
