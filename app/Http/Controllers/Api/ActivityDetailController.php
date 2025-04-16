<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityDetailResource;
use App\Models\ActivityDetail;
use App\Models\Attendee;
use Illuminate\Http\Request;

class ActivityDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $_activitydetail = new ActivityDetail;
        

        $ga_id = $request->ga_id;

        $activitydetails = $_activitydetail->getActivityDetailsByGA($ga_id);

        return ActivityDetailResource::collection($activitydetails);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'targets' => ['required'],
            'target_men' => ['required'],
            'target_women' => ['required'],
            'gad_budget' => ['required'],
            'responsible_unit' => ['required'],
        ], [
            'responsible_unit.required' => 'Responsible Unit/Office field is required.'
        ]);

        $activitydetail = ActivityDetail::create([
            'gad_activity_id' => $request->gad_activity_id,
            'sub_activity' => $request->sub_activity,
            'targets' => $request->targets,
            'target_women' => $request->target_women,
            'target_men' => $request->target_men,
            'gad_budget' => $request->gad_budget,
            'responsible_unit' => $request->responsible_unit,
            // 'is_active_goal' => 1
        ]);

        return new ActivityDetailResource($activitydetail);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $_activitydetail = new ActivityDetail;
        $_attendee = new Attendee;

        $activitydetail = $_activitydetail->getActivityDetail($id);
        $attendees = $_attendee->getByActivityDetailId($id);

        $male = 0;
        $female = 0;
        $lgbtqia = 0;
        if (!empty($attendees)) {
            foreach ($attendees as $attendee) {
                if ($attendee->gender=="male") {
                    $male++;
                }
                if ($attendee->gender=="female") {
                    $female++;
                }
                if ($attendee->gender=="lgbtqia+") {
                    $lgbtqia++;
                }
            }
        }

        ActivityDetail::find($id)->update(['actual_women' => $female, 'actual_men' => $male, 'actual_lgbtq'=>$lgbtqia]);

        return new ActivityDetailResource($activitydetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'targets' => ['required'],
            'target_men' => ['required'],
            'target_women' => ['required'],
            'gad_budget' => ['required'],
            'responsible_unit' => ['required'],
        ], [
            'responsible_unit.required' => 'Responsible Unit/Office field is required.'
        ]);

        $activitydetail_update = ActivityDetail::find($id)->update([
            'gad_activity_id' => $request->gad_activity_id,
            'sub_activity' => $request->sub_activity,
            'targets' => $request->targets,
            'target_women' => $request->target_women,
            'target_men' => $request->target_men,
            'gad_budget' => $request->gad_budget,
            'responsible_unit' => $request->responsible_unit,
            // 'is_active_goal' => 1
        ]);

        $activitydetail = ActivityDetail::find($id);

        return new ActivityDetailResource($activitydetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $activitydetail = ActivityDetail::find($id)->delete();
 
        return response()->noContent();
    }

    public function updateAccom(Request $request, $id)
    {
        $request->validate([
            'gad_budget' => ['required'],
            'actual_result' => ['required'],
            'actual_men' => ['required'],
            'actual_women' => ['required'],
            'actual_lgbtq' => ['required'],
            'actual_cost' => ['required'],
        ]);

        $activitydetail_update = ActivityDetail::find($id)->update([
            'gad_budget' => $request->gad_budget,
            'actual_result' => $request->actual_result,
            'actual_men' => $request->actual_men,
            'actual_women' => $request->actual_women,
            'actual_lgbtq' => $request->actual_lgbtq,
            'actual_cost' => $request->actual_cost,
            'remarks' => $request->remarks,
        ]);

        $activitydetail = ActivityDetail::find($id);

        return new ActivityDetailResource($activitydetail);
    }

    public function uploadMov(Request $request) {

        $request->validate([
            'mov' => 'required|mimes:pdf|max:5120', // 5MB limit
            'id' => 'required'
        ]);

        $file = $request->file('mov');
        $newName = 'mov_'.$request->id.'_'.time().'.'.$file->getClientOriginalExtension();
        $file->storeAs('movs', $newName, 'public');
        ActivityDetail::where('id', $request->id)->update(['mov_file' => $newName]);
        return redirect()->back();
    }

    public function downloadMov(Request $request) {
        $mov_file = $request->mov_file;
        $path = storage_path('app/public/movs/'.$mov_file);
        return response()->file($path);
    }
}
