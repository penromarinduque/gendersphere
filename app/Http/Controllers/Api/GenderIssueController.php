<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenderIssueResource;
use App\Models\GenderIssue;
use Illuminate\Http\Request;

class GenderIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genderissues = GenderIssue::all();
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
            'is_active_gender_issue' => 1
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

        $genderissue_updated = GenderIssue::find($id)->update([
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
        $genderissue = GenderIssue::find($id)->delete();
 
        return response()->noContent();
    }

    public function genderIssueByYear($year)
    {
        $genderissues = GenderIssue::select('id', 'mandate_year', 'gender_issue_mandate')->where('mandate_year', $year)->where('is_active_gender_issue', 1)->get();
        return GenderIssueResource::collection($genderissues);
    }
}
