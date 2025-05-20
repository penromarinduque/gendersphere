<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PlanBudget extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['year', 'focus', 'goal_id', 'gender_issue_id', 'cause_gender_issue_id', 'objective_id', 'relevant_org'];

    public function gad_activities()
    {
        return $this->hasMany(GadActivity::class, 'plan_budget_id');
    }

    public function getPlanBudgetByYear($year)
    {
        return PlanBudget::select('plan_budgets.*', 'goals.goal_no', 'goals.gad_goal', 'gender_issues.gender_issue_mandate', 'cause_gender_issues.cause as cause_gender_issue', 'objectives.gad_objective')
            ->with(['gad_activities' => function ($gad_activities) {
                $gad_activities->select('gad_activities.id', 'gad_activities.plan_budget_id', 'gad_activities.main_activity')
                ->with(['activity_details' => function ($activity_details) {
                    $activity_details->select('activity_details.gad_activity_id', 'sub_activity', 'targets', 'target_women', 'target_men', 'gad_budget', 'responsible_unit', 'actual_result', 'actual_women', 'actual_men', 'actual_lgbtq', 'actual_cost', 'remarks');
                }]);
            }])
            ->leftJoin('goals', 'goals.id', 'plan_budgets.goal_id')
            ->leftJoin('gender_issues', 'gender_issues.id', 'plan_budgets.gender_issue_id')
            ->leftJoin('cause_gender_issues', 'cause_gender_issues.id', 'plan_budgets.cause_gender_issue_id')
            ->leftJoin('objectives', 'objectives.id', 'plan_budgets.objective_id')
            ->where('plan_budgets.year', $year)
            ->get();
    }

    public function getPlanBudgetGoals($year)
    {
        return PlanBudget::select('plan_budgets.focus', 'plan_budgets.goal_id', 'goals.goal_no', 'goals.gad_goal')
            ->join('goals', 'goals.id', 'plan_budgets.goal_id')
            ->where('plan_budgets.year', $year)
            ->groupBy('plan_budgets.goal_id')
            ->orderBy('goals.goal_no', 'ASC')
            ->get();
    }
}
