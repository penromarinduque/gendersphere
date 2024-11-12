<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoalResource;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goals = Goal::all();
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

        $goal = Goal::create([
            'goal_no' => $request->goal_no,
            'gad_goal' => $request->gad_goal,
            'is_active_goal' => 1
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

        $goal_updated = Goal::find($id)->update([
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
        $goal = Goal::find($id)->delete();
 
        return response()->noContent();
    }
}
