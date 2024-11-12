<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GadActivityResource;
use App\Models\GadActivity;
use Illuminate\Http\Request;

class GadActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'main_activity' => ['required'],
        ], [
            'main_activity.required' => 'GAD Activity field is required.'
        ]);

        $gadactivity = GadActivity::create([
            'plan_budget_id' => $request->plan_budget_id,
            'main_activity' => $request->main_activity,
            // 'is_active_goal' => 1
        ]);

        return new GadActivityResource($gadactivity);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gadactivity = GadActivity::find($id);
        return new GadActivityResource($gadactivity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'main_activity' => ['required'],
        ]);

        $gadactivity_update = GadActivity::find($id)->update([
            'main_activity' => $request->main_activity,
        ]);

        $gadactivity = GadActivity::find($id);

        return new GadActivityResource($gadactivity);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gadactivity = GadActivity::find($id)->delete();
 
        return response()->noContent();
    }
}
