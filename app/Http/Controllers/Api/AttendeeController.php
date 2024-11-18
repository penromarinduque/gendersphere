<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Models\PersonInfo;
use App\Models\ActivityDetail;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendees = Attendee::select('attendees.activity_id', 'attendees.activity_detail_id', 'person_infos.*')
            ->join('person_infos', 'person_infos.id', 'attendees.person_info_id')
            ->get();
        return AttendeeResource::collection($attendees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $_activitydetail = new ActivityDetail;

        
        if ($request->person_type==1) {
            $request->validate([
                'person_info_id' => ['required'],
            ], [
                'person_info_id.required' => 'Please select an employee.'
            ]);

            $person_info_id = $request->person_info_id;
            $activity_id = $request->activity_id;
    
            $attendee = Attendee::create([
                'activity_id' => $activity_id,
                'activity_detail_id' => $activity_id,
                'person_info_id' => $person_info_id
            ]);
    
            return new AttendeeResource($attendee);

        } else {
            $request->validate([
                'lastname' => ['required', 'string'],
                'firstname' => ['required', 'string'],
                'middlename' => ['required', 'string'],
                'extname' => ['nullable', 'string'],
                'gender' => ['required'],
                'age' => ['required'],
                'province_id' => ['required'],
                'municipality_id' => ['required'],
                'barangay_id' => ['required'],
                'contact_no' => ['nullable', 'max:12'],
                'organization' => ['nullable'],
            ]);
    
            $personInfo = PersonInfo::create([
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'extname' => $request->extname,
                'gender' => $request->gender,
                'age' => $request->age,
                'province_id' => $request->province_id,
                'municipality_id' => $request->municipality_id,
                'barangay_id' => $request->barangay_id,
                'contact_no' => $request->contact_no,
                'organization' => $request->organization,
                'person_type' => 2
            ]);
    
            $person_info_id = $personInfo->id;
            $activity_id = $request->activity_id;
    
            $attendee = Attendee::create([
                'activity_id' => $activity_id,
                'activity_detail_id' => $activity_id,
                'person_info_id' => $person_info_id
            ]);
    
            return new AttendeeResource($attendee);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($activity_id)
    {
        $attendees = Attendee::select('attendees.id as attendee_id', 'attendees.activity_id', 'attendees.activity_detail_id', 'attendees.person_info_id', 'person_infos.*', 'barangays.barangay_name', 'municipalities.municipality_name', 'provinces.province_name')
            ->join('person_infos', 'person_infos.id', 'attendees.person_info_id')
            ->leftJoin('provinces', 'provinces.id', 'person_infos.province_id')
            ->leftJoin('municipalities', 'municipalities.id', 'person_infos.municipality_id')
            ->leftJoin('barangays', 'barangays.id', 'person_infos.barangay_id')
            ->where('attendees.activity_detail_id', $activity_id)
            ->get();
        return AttendeeResource::collection($attendees);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $attendee = Attendee::find($id);

        if (!empty($attendee)) {
            $personInfo = PersonInfo::find($attendee->person_info_id);
            if (!empty($personInfo)) {
                if ($personInfo->person_type==2) {
                    PersonInfo::find($personInfo->id)->delete();
                }
            }
        }
        $attendeeDelete = Attendee::find($id)->delete();

        return response()->noContent();
    }
}
