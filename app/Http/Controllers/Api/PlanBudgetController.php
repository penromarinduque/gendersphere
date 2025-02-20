<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanBudgetResource;
use App\Models\PlanBudget;
use Illuminate\Http\Request;

class PlanBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = $request->year;
        $planbudgets = PlanBudget::select('plan_budgets.*', 'goals.goal_no', 'goals.gad_goal', 'gender_issues.gender_issue_mandate', 'cause_gender_issues.cause as cause_gender_issue', 'objectives.gad_objective')
            ->with(['gad_activities' => function ($gad_activities) {
                $gad_activities->select('gad_activities.id', 'gad_activities.plan_budget_id', 'gad_activities.main_activity')
                ->with(['activity_details' => function ($activity_details) {
                        $activity_details->select('activity_details.gad_activity_id');
                    }]);
            }])
            ->leftJoin('goals', 'goals.id', 'plan_budgets.goal_id')
            ->leftJoin('gender_issues', 'gender_issues.id', 'plan_budgets.gender_issue_id')
            ->leftJoin('cause_gender_issues', 'cause_gender_issues.id', 'plan_budgets.cause_gender_issue_id')
            ->leftJoin('objectives', 'objectives.id', 'plan_budgets.objective_id')
            ->get();
        return PlanBudgetResource::collection($planbudgets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => ['required'],
            'focus' => ['required'],
            'goal_id' => ['required'],
            'gender_issue_id' => ['required'],
            'objective_id' => ['required'],
            'relevant_org' => ['required'],
        ], [
            'goal_id.required' => 'The GAD Goal field is required.',
            'gender_issue_id.required' => 'The Gender Issue/GAD Mandate field is required.',
            'objective_id.required' => 'The GAD Objective field is required.',
            'relevant_org.required' => 'The Relevant Organization field is required.',
        ]);

        $planbudget = PlanBudget::create([
            'year' => $request->year,
            'focus' => $request->focus,
            'goal_id' => $request->goal_id,
            'gender_issue_id' => $request->gender_issue_id,
            'cause_gender_issue_id' => $request->cause_gender_issue_id,
            'objective_id' => $request->objective_id,
            'relevant_org' => $request->relevant_org,
        ]);

        return new PlanBudgetResource($planbudget);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $planbudget = PlanBudget::find($id);
        return new PlanBudgetResource($planbudget);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'year' => ['required'],
            'focus' => ['required'],
            'goal_id' => ['required'],
            'gender_issue_id' => ['required'],
            'objective_id' => ['required'],
            'relevant_org' => ['required'],
        ], [
            'goal_id.required' => 'The GAD Goal field is required.',
            'gender_issue_id.required' => 'The Gender Issue/GAD Mandate field is required.',
            'objective_id.required' => 'The GAD Objective field is required.',
            'relevant_org.required' => 'The Relevant Organization field is required.',
        ]);

        $planbudget_update = PlanBudget::find($id)->update([
            'year' => $request->year,
            'focus' => $request->focus,
            'goal_id' => $request->goal_id,
            'gender_issue_id' => $request->gender_issue_id,
            'cause_gender_issue_id' => $request->cause_gender_issue_id,
            'objective_id' => $request->objective_id,
            'relevant_org' => $request->relevant_org,
        ]);
        $planbudget = PlanBudget::find($id);

        return new PlanBudgetResource($planbudget);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $planBudget->delete();
        $planBudget = PlanBudget::find($id)->delete();
 
        return response()->noContent();
    }
}
