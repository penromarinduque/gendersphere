<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObjectiveResource;
use App\Models\Objective;
use App\Models\PlanBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Objective::query();
        if($request->has('office_id')) {
            $query->where('office_id', $request->office_id);
        }
        $objectives = $query->get();
        return ObjectiveResource::collection($objectives);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gad_objective' => ['required'],
        ]);

        $objective = Objective::create([
            'gad_objective' => $request->gad_objective,
            'is_active_objective' => 1,
            'office_id' => auth()->user()->office_id
        ]);

        return new ObjectiveResource($objective);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new ObjectiveResource(Objective::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'gad_objective' => ['required'],
            'is_active_objective' => ['required'],
        ], [
            'is_active_objective.required' => 'The status field is required.'
        ]);

        $objective = Objective::find($id);
        Gate::authorize('update', $objective);
        $objective->update([
            'gad_objective' => $request->gad_objective,
            'is_active_objective' => $request->is_active_objective,
        ]);

        $objective = Objective::find($id);

        return new ObjectiveResource($objective);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $objective = Objective::find($id);
        $isUsed = PlanBudget::where('objective_id', $objective->id)->exists();
        if($isUsed) {
            return response()->json(['message' => 'This objective is used in a plan budget therefore it cannot be deleted.'], 403);
        }
        Gate::authorize('delete', $objective);
        $objective->delete();
 
        return response()->noContent();
    }
}
