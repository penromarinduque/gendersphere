<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenderIssueResource;
use App\Models\GenderIssue;
use App\Models\PlanBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GenderIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GenderIssue::query();
        if($request->has('office_id')) {
            $query->where('office_id', $request->office_id);
        }
        $genderissues = $query->get();
        return GenderIssueResource::collection($genderissues);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mandate_year' => ['required'],
            'gender_issue_mandate' => ['required'],
        ]);

        $genderissue = GenderIssue::create([
            'mandate_year' => $request->mandate_year,
            'gender_issue_mandate' => $request->gender_issue_mandate,
            'is_active_gender_issue' => 1,
            'office_id' => auth()->user()->office_id
        ]);

        return new GenderIssueResource($genderissue);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new GenderIssueResource(GenderIssue::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'mandate_year' => ['required'],
            'gender_issue_mandate' => ['required'],
            'is_active_gender_issue' => ['required'],
        ], [
            'mandate_year.required' => 'The year field is required.',
            'is_active_gender_issue.required' => 'The status field is required.'
        ]);

        $genderissue = GenderIssue::find($id);
        Gate::authorize('update', $genderissue);
        $genderissue->update([
            'mandate_year' => $request->mandate_year,
            'gender_issue_mandate' => $request->gender_issue_mandate,
            'is_active_gender_issue' => $request->is_active_gender_issue,
        ]);

        $genderissue = GenderIssue::find($id);

        return new GenderIssueResource($genderissue);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $genderissue = GenderIssue::find($id);
        
        Gate::authorize('delete', $genderissue);
        $isUsed = PlanBudget::where('gender_issue_id', $genderissue->id)->exists();
        if($isUsed) {
            return response()->json(['message' => 'This gender issue is used in a plan budget therefore it cannot be deleted.'], 403);
        }
        $genderissue->delete();
 
        return response()->noContent();
    }

    public function genderIssueByYear($year)
    {
        $genderissues = GenderIssue::select('id', 'mandate_year', 'gender_issue_mandate')->where('mandate_year', $year)->where('is_active_gender_issue', 1)->get();
        return GenderIssueResource::collection($genderissues);
    }
}
