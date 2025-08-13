<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingRequest;
use App\Http\Resources\TrainingResource;
use App\Models\Training;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $office_id = $user->office_id; 
       

        if($user?->is_super_admin) {
            $query = Training::select('trainings.*');
        } 
        else {
            $query = Training::select('trainings.*')
                ->where('trainings.office_id', $office_id);
        }

        if ($request->has('year')) {
            $query->whereYear('training_start', $request->year);
        }

        if ($request->has('title')) {
            $query->where('training_title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('employee_id')) {
            $query->whereHas('attendees', function ($q) use ($request) {
                $q->where('person_info_id', $request->employee_id);
            });
        }

        if ($request->has('type')) {
            $query->where('learning_description_type', $request->type);
        }

        return $query->paginate(10);
    
        }

        /**
         * Display the specified resource.
         */
    public function show($id)
    {
            // return new PersonInfoResource($personInfo);
        $training = Training::find($id);
        return new TrainingResource($training);
    }

    public function store(TrainingRequest $request)
    {

        Gate::authorize('create', Training::class);
        
        $training = Training::create([
            ...$request->validated(),
            'office_id' => auth()->user()->office_id
        ]);

        $training = Training::find($training->id);
        return new TrainingResource($training);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $training_title = ($request->training_title) ? $request->training_title : NULL;
        $training_start = ($request->training_start) ? $request->training_start : NULL;
        $training_end = ($request->training_end) ? $request->training_end : NULL;
        $duration_hours = ($request->duration_hours) ? $request->duration_hours : NULL;
        $learning_description_type = ($request->learning_description_type) ? $request->learning_description_type : NULL;
        $sponsor_facilitator = ($request->sponsor_facilitator) ? $request->sponsor_facilitator : NULL;

        $request->validate([
            'training_title' => ['required', 'string'],
            'training_start' => ['required', 'date'],
            'training_end' => ['required', 'date'],
            'duration_hours' => ['required', 'numeric'],
            'learning_description_type' => ['required', 'string'],
            'sponsor_facilitator' => ['required', 'string'],
        ]);
        
        Training::findOrFail($id)->update([
            'training_title' => $training_title,
            'training_start' => $training_start,
            'training_end' => $training_end,
            'duration_hours' => $duration_hours,
            'learning_description_type' => $learning_description_type,
            'sponsor_facilitator' => $sponsor_facilitator,
        ]);


        $training = Training::find($id);
        return new TrainingResource($training);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $training = Training::find($id)->delete();

        return response()->noContent();
    }

    public function all(Request $request) {
        $user = auth()->user();
        $office_id = $user->office_id; 
        
        if($user?->is_super_admin) {
            $training_qry = Training::select('*');
        } 
        else {
            $training_qry = Training::select('trainings.*')
                ->where('trainings.office_id', $office_id);
        }

        $trainings = $training_qry->orderBy('training_title', 'ASC')
            ->get();
        // $personinfos->appends(['searchkey' => $searchkey]);
        return TrainingResource::collection($trainings);
    }

    public function summary(Request $request){
        $user = auth()->user();
        $office_id = $user->office_id; 

        if($user?->is_super_admin) {
            $total_trainings = Training::query()->count();
            $total_managerial = Training::query()->where('learning_description_type', 'managerial')->count();
            $total_supervisory = Training::query()->where('learning_description_type', 'supervisory')->count();
            $total_technical = Training::query()->where('learning_description_type', 'technical')->count();
            $total_foundation = Training::query()->where('learning_description_type', 'foundation')->count();

        }
        else {
            $total_trainings = Training::query()->where('office_id', $office_id)->count();
            $total_managerial = Training::query()->where('learning_description_type', 'managerial')->where('office_id', $office_id)->count();
            $total_supervisory = Training::query()->where('learning_description_type', 'supervisory')->where('office_id', $office_id)->count();
            $total_technical = Training::query()->where('learning_description_type', 'technical')->where('office_id', $office_id)->count();
            $total_foundation = Training::query()->where('learning_description_type', 'foundation')->where('office_id', $office_id)->count();
        }
        return response()->json([
            "total_trainings" => $total_trainings,
            "total_managerial" => $total_managerial,
            "total_supervisory" => $total_supervisory,
            "total_foundation" => $total_foundation,
            "total_technical" => $total_technical,
        ]);
    }
    public function attendees($id)
    {
        $training = Training::with('attendees')->findOrFail($id);
        return response()->json($training->attendees);
    }

    public function addAttendees(Request $request, $id)
    {
        $request->validate([
            'person_info_ids' => 'required|array',
            'person_info_ids.*' => 'exists:person_infos,id',
        ]);

        $training = Training::findOrFail($id);
        $training->attendees()->syncWithoutDetaching($request->person_info_ids);

        return response()->json(['message' => 'Attendees added successfully.']);
    }

    public function removeAttendee($trainingId, $userId)
    {
        $training = Training::findOrFail($trainingId);
        $training->attendees()->detach($userId);

        return response()->json(['message' => 'Attendee removed']);
    }

    public function getTrainingList()
    {   
        $user = auth()->user();
        $office_id = $user->office_id; 
        $titles = Training::select('training_title')
            ->where('office_id', $office_id)
            ->distinct()
            ->pluck('training_title');

        return response()->json(['data' => $titles]);
    }
}
