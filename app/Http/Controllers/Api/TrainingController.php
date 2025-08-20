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
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class TrainingController extends Controller
{
    //Display a listing of the resource.
    public function index(Request $request)
    {
        $user = auth()->user();
        $office_id = $user->office_id; 
        $query = Training::select('trainings.*');

        if(!$user?->is_super_admin) {
            $query->where('trainings.office_id', $office_id);
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
        
        if ($request->has('training_nature')) {
            $query->where('training_nature', $request->training_nature);
        }
        return $query->paginate(10);
    }

    //Display the specified resource.
    public function show($id)
    {
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
/*     public function update(Request $request, $id)
    {
        $training_title = ($request->training_title) ? $request->training_title : NULL;
        $training_start = ($request->training_start) ? $request->training_start : NULL;
        $training_end = ($request->training_end) ? $request->training_end : NULL;
        $duration_hours = ($request->duration_hours) ? $request->duration_hours : NULL;
        $learning_description_type = ($request->learning_description_type) ? $request->learning_description_type : NULL;
        $sponsor_facilitator = ($request->sponsor_facilitator) ? $request->sponsor_facilitator : NULL;
        $is_gad_related = ($request->is_gad_related) ? $request->is_gad_related : FALSE;
        $training_nature = ($request->training_nature) ? $request->training_nature : NULL;

        $request->validate([
            'training_title' => [
            'required',
            'string',
            Rule::unique('trainings', 'training_title')
                ->ignore($id) // Ignore this training's own ID
                ->where(function ($query) {
                    $query->where('office_id', auth()->user()->office_id);
                })
            ],
            'training_start' => ['required', 'date'],
            'training_end' => ['required', 'date'],
            'duration_hours' => ['required', 'numeric'],
            'learning_description_type' => ['required', 'string'],
            'sponsor_facilitator' => ['required', 'string'],
            'is_gad_related' => ['boolean'],
            'training_nature' => ['required', 'in:attended,conducted'],
        ]);
        
        Training::findOrFail($id)->update([
            'training_title' => $training_title,
            'training_start' => $training_start,
            'training_end' => $training_end,
            'duration_hours' => $duration_hours,
            'learning_description_type' => $learning_description_type,
            'sponsor_facilitator' => $sponsor_facilitator,
            'is_gad_related' => $is_gad_related,
            'training_nature' => $training_nature,
        ]);


        $training = Training::find($id);
        return new TrainingResource($training);
    } */
    public function update(TrainingRequest $request, $id)
        {
            $training = Training::findOrFail($id);
            $training->update($request->validated());

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

    public function removeAttendee($trainingId, $userId){
        $training = Training::findOrFail($trainingId);
        $training->attendees()->detach($userId);

        return response()->json(['message' => 'Attendee removed']);
    }

    public function removeAllAttendees($trainingId){
        $training = Training::findOrFail($trainingId);

        // Assumes many-to-many relationship
        $training->attendees()->detach();
        return response()->json(['message' => 'All attendees removed successfully.']);
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

    public function getCertificate($trainingId, $attendeeId){
        $training = Training::findOrFail($trainingId);
        $attendee = $training->attendees()->findOrFail($attendeeId);
        $path = $attendee->pivot->certificate_path ?? null;

        // Ensure we return a public URL only if the file exists
        $url = $path && Storage::disk('public')->exists($path)
            ? Storage::url($path)
            : null;

        return response()->json(['url' => $url]);
    }


    public function uploadCertificate(Request $req, $trainingId, $attendeeId) {
        $req->validate(['certificate' => 'required|image']);
        $training = Training::findOrFail($trainingId);
        $path = $req->file('certificate')->store('certificates', 'public');
        $training->attendees()->updateExistingPivot($attendeeId, [
        'certificate_path' => $path
    ]);
        return response()->json(['message' => 'Uploaded']);
    }

    public function deleteCertificate($trainingId, $attendeeId) {
        $training = Training::findOrFail($trainingId);
        $pivot = $training->attendees()->findOrFail($attendeeId)->pivot;

        $path = $pivot->certificate_path;

        if (!$path) {
            return response()->json(['message' => 'No certificate found'], 404);
        }

        // Use the correct disk (public)
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $pivot->update(['certificate_path' => null]);

        return response()->json(['message' => 'Deleted']);
    }
}
