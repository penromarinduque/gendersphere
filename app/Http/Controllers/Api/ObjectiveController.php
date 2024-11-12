<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObjectiveResource;
use App\Models\Objective;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objectives = Objective::all();
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
            'is_active_objective' => 1
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

        $objective_updated = Objective::find($id)->update([
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
        $objective = Objective::find($id)->delete();
 
        return response()->noContent();
    }
}
