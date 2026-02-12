<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoalResource;
use App\Models\Goal;
use App\Models\PlanBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Goal::query();
        if($request->has('office_id')) {
            $query->where('office_id', $request->office_id);
        }
        $goals = $query->get();
        return GoalResource::collection($goals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'goal_no' => ['required'],
            'gad_goal' => ['required'],
        ]);
        
        Gate::authorize('create', Goal::class);

        $goal = Goal::create([
            'goal_no' => $request->goal_no,
            'gad_goal' => $request->gad_goal,
            'is_active_goal' => 1,
            'office_id' => auth()->user()->office_id
        ]);

        return new GoalResource($goal);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new GoalResource(Goal::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'goal_no' => ['required'],
            'gad_goal' => ['required'],
            'is_active_goal' => ['required'],
        ], [
            'is_active_goal.required' => 'The status field is required.'
        ]);


        $goal = Goal::find($id);

        Gate::authorize('update', $goal);
        
        $goal->update([
            'goal_no' => $request->goal_no,
            'gad_goal' => $request->gad_goal,
            'is_active_goal' => $request->is_active_goal,
        ]);

        $goal = Goal::find($id);

        return new GoalResource($goal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $goal = Goal::find($id);

        $isUsed = PlanBudget::where('goal_id', $goal->id)->exists();
        if($isUsed) {
            return response()->json(['message' => 'This goal is used in a plan budget therefore it cannot be deleted.'], 403);
        }

        Gate::authorize('delete', $goal);
        
        $goal->delete();
 
        return response()->noContent();
    }
}
