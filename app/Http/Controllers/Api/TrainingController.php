<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingRequest;
use App\Http\Resources\TrainingResource;
use App\Models\Training;
use App\Models\TrainingInstance;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{

    public function index(Request $request) {
        $user = auth()->user();
        $office_id = $user->office_id;  
        $query = TrainingInstance::with(['training', 'attendees']);
        // Normalize request inputs in case they're arrays like ['value' => 'all'] or ['all']
        $type = is_array($request->type) ? ($request->type['value'] ?? $request->type[0] ?? null) : $request->type;
        $title = is_array($request->title) ? ($request->title['value'] ?? $request->title[0] ?? null) : $request->title;
        $employeeId = is_array($request->employee_id) ? ($request->employee_id['value'] ?? $request->employee_id[0] ?? null) : $request->employee_id;
        $trainingNature = is_array($request->training_nature) ? ($request->training_nature['value'] ?? $request->training_nature[0] ?? null) : $request->training_nature;
        $year = is_array($request->year) ? ($request->year['value'] ?? $request->year[0] ?? null) : $request->year;

        if (!$user?->is_super_admin) {
            $query->where('office_id', $office_id);
        }

        if ($year && $year !== 'all') {
            $query->whereYear('training_start', $year);
        }

        if ($title && $title !== 'all') {
            $query->whereHas('training', function ($q) use ($title) {
                $q->where('training_title', 'like', '%' . $title . '%');
            });
        }

        if ($employeeId && $employeeId !== 'all') {
            $query->whereHas('attendees', function ($q) use ($employeeId) {
                $q->where('person_info_id', $employeeId);
            });
        }

        if ($trainingNature && $trainingNature !== 'all') {
            $query->whereHas('training', function ($q) use ($trainingNature) {
                $q->where('training_nature', $trainingNature);
            });
        }

        if ($type && $type !== 'all') {
            $query->whereHas('training', function ($q) use ($type) {
                $q->where('learning_description_type', $type);
            });
        }


        return $query->paginate(10)->through(function ($instance) {
            return [
                'id' => $instance->id,
                'training_start' => $instance->training_start,
                'training_end' => $instance->training_end,
                'duration_hours' => $instance->duration_hours,
                'training_title' => $instance->training->training_title ?? '',
                'training_nature' => $instance->training->training_nature ?? '',
                'learning_description_type' => $instance->training->learning_description_type ?? '',
                'is_gad_related' => $instance->training->is_gad_related ?? false,
                'sponsor_facilitator' => $instance->sponsor_facilitator,
                'attendees' => $instance->attendees,
            ];
        });
    }

    public function showByInstance($id) {
        $instance = TrainingInstance::with('training')->find($id);

        if (!$instance || !$instance->training) {
            return response()->json(['message' => 'Training instance or parent training not found.'], 404);
        }

        $merged = [
            // From parent Training model
            'id' => $instance->training->id,
            'training_title' => $instance->training->training_title,
            'learning_description_type' => $instance->training->learning_description_type,
            'training_nature' => $instance->training->training_nature,
            'is_gad_related' => (bool) $instance->training->is_gad_related,

            // From this TrainingInstance
            'training_start' => $instance->training_start,
            'training_end' => $instance->training_end,
            'duration_hours' => $instance->duration_hours,
            'sponsor_facilitator' => $instance->sponsor_facilitator,
            'office_id' => $instance->office_id,
        ];

        return response()->json(['data' => $merged]);
    }


    public function store(TrainingRequest $request) {
        $validated = $request->validated();

        // Extract instance data
        $instanceData = $validated['training_instance'];

        // Check for duplicate
        $duplicate = Training::where('training_title', $validated['training_title'])
            ->whereHas('instances', function ($query) use ($instanceData) {
                $query->where('office_id', $instanceData['office_id'])
                    ->where(function ($q) use ($instanceData) {
                        $q->whereDate('training_start', '<=', $instanceData['training_end'])
                        ->whereDate('training_end', '>=', $instanceData['training_start']);
                    });
            })->exists();

        if ($duplicate) {
            return response()->json([
                'message' => 'Overlapping Dates for an Existing Training!',
                'errors' => [
                    'training_title' => ['Overlapping Dates for an Existing Training!']
                ]
            ], 422);
        }

        // Create or find the training record
        $training = Training::firstOrCreate(
            ['training_title' => $validated['training_title']],
            [
                'learning_description_type' => $validated['learning_description_type'],
                'is_gad_related' => $validated['is_gad_related'],
                'training_nature' => $validated['training_nature'],
            ]
        );

        // Create training instance
        $training->instances()->create([
            'training_start' => $instanceData['training_start'],
            'training_end' => $instanceData['training_end'],
            'duration_hours' => $instanceData['duration_hours'],
            'sponsor_facilitator' => $instanceData['sponsor_facilitator'],
            'office_id' => $instanceData['office_id'],
        ]);

        return new TrainingResource($training->load('instances'));
    }

    public function updateFromInstance(TrainingRequest $request, $instanceId)
    {
        $validated = $request->validated();
        $instanceData = $validated['training_instance'];

        DB::beginTransaction();

        try {
            // Find instance and related training
            $instance = TrainingInstance::with('training')->findOrFail($instanceId);
            $training = $instance->training;

            //Update parent training
            $training->update([
                'training_title' => $validated['training_title'],
                'training_nature' => $validated['training_nature'],
                'learning_description_type' => $validated['learning_description_type'],
                'is_gad_related' => $validated['is_gad_related'],
            ]);

            //Update instance
            $instance->update([
                'training_start' => $instanceData['training_start'],
                'training_end' => $instanceData['training_end'],
                'duration_hours' => $instanceData['duration_hours'],
                'sponsor_facilitator' => $instanceData['sponsor_facilitator'],
                'office_id' => $instanceData['office_id'],
            ]);

            DB::commit();

            //return redirect()->route('trainings.index')->with('success', 'Training updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'error' => 'Update failed: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function summary(Request $request)
    {
        $user = auth()->user();

        // Get all enum values from the `trainings` table
        $enumValues = DB::selectOne("
            SELECT COLUMN_TYPE 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = 'trainings' 
            AND COLUMN_NAME = 'learning_description_type'
            AND TABLE_SCHEMA = DATABASE()
        ");

        preg_match("/^enum\((.*)\)$/", $enumValues->COLUMN_TYPE, $matches);
        $types = collect(str_getcsv($matches[1], ',', "'"))->toArray(); // clean enum values

        // Base query
        $query = DB::table('training_instances')
            ->join('trainings', 'training_instances.training_id', '=', 'trainings.id');

        if (!$user->is_super_admin) {
            $query->where('training_instances.office_id', $user->office_id);
        }

        // Get actual counts
        $counts = $query
            ->select('trainings.learning_description_type', DB::raw('COUNT(*) as instance_count'))
            ->groupBy('trainings.learning_description_type')
            ->pluck('instance_count', 'trainings.learning_description_type')
            ->toArray();

        // Format result with 0 fallback
        $byTraining = [];
        foreach ($types as $type) {
            $byTraining[] = [
                'learning_description_type' => $type,
                'instance_count' => $counts[$type] ?? 0,
            ];
        }

        return response()->json([
            'total_instances' => array_sum($counts),
            'by_training' => $byTraining,
        ]);
    }


    public function attendees($id)  {
        $trainingInstance = TrainingInstance::with('attendees')->findOrFail($id);

        return $trainingInstance->attendees->map(function ($attendee) {
            return [
                'id' => $attendee->id,
                'firstname' => $attendee->firstname,
                'middlename' => $attendee->middlename,
                'lastname' => $attendee->lastname,
                'gender' => $attendee->gender,
                'certificate' => $attendee->pivot->certificate_path ?? null,
            ];
        });
    }


    public function addAttendees(Request $request, $id) {
        $request->validate([
            'person_info_ids' => 'required|array',
            'person_info_ids.*' => 'exists:person_infos,id',
        ]);

        $trainingInstance = TrainingInstance::findOrFail($id);
        $trainingInstance->attendees()->syncWithoutDetaching($request->person_info_ids);

        return response()->json(['message' => 'Attendees added successfully.']);
    }

    public function removeAttendee($trainingId, $userId){
        $trainingInstance = TrainingInstance::findOrFail($trainingId);

        // Fetch the pivot record
        $pivot = $trainingInstance->attendees()->where('person_info_id', $userId)->first();

        if ($pivot && $pivot->pivot->certificate_path) {
            // Delete certificate file from storage
            Storage::disk('private')->delete($pivot->pivot->certificate_path);
        }

        // Detach the attendee from the training
        $trainingInstance->attendees()->detach($userId);

        return response()->json(['message' => 'Attendee removed']);
    }

    public function removeAllAttendees($trainingId) {
        $trainingInstance = TrainingInstance::findOrFail($trainingId);

        // Get only certificate paths from the pivot table
        $paths = $trainingInstance->attendees()->pluck('certificate_path');

        // Filter out nulls and delete all files in a batch
        if ($paths->isNotEmpty()) {
            Storage::disk('private')->delete($paths->filter()->all());
        }

        // Now safely detach all attendees
        $trainingInstance->attendees()->detach();

        return response()->json(['message' => 'All attendees removed successfully.']);
    }

    public function getTrainingList() {   
        $user = auth()->user();
        $office_id = $user->office_id;

        $titles = TrainingInstance::select('trainings.training_title')
            ->join('trainings', 'training_instances.training_id', '=', 'trainings.id')
            ->where('training_instances.office_id', $office_id)
            ->distinct()
            ->pluck('trainings.training_title');

        return response()->json(['data' => $titles]);
    }

    public function getCertificate($trainingId, $attendeeId) {
        $trainingInstance = TrainingInstance::findOrFail($trainingId);
        $attendee = $trainingInstance->attendees()->findOrFail($attendeeId);
        $path = $attendee->pivot->certificate_path;

        if (!$path || !Storage::disk('private')->exists($path)) {
            return response()->json(['message' => 'Certificate not found'], 404);
        }

        // Ensure user has access
        if ($trainingInstance->office_id !== auth()->user()->office_id) {
            abort(403, 'Unauthorized');
        }

        $file = Storage::disk('private')->get($path);
        $mime = Storage::disk('private')->mimeType($path);

        return response($file, 200)->header('Content-Type', $mime);
    }

    public function uploadCertificate(Request $req, $trainingId, $attendeeId) {
        $req->validate(['certificate' => 'required|image|max:2048']);

        $trainingInstance = TrainingInstance::findOrFail($trainingId);

        // Get attendee from pivot relationship
        $attendee = $trainingInstance->attendees()->where('person_info_id', $attendeeId)->first();

        if (!$attendee) {
            return response()->json(['message' => 'Attendee not found'], 404);
        }

        // Combine and sanitize name
        $fullName = $attendee->firstname . '_' . ($attendee->middlename ?? '') . '_' . $attendee->lastname;
        $cleanName = preg_replace('/[^A-Za-z0-9]/', '_', $fullName);
        $cleanName = preg_replace('/_+/', '_', $cleanName);
        $cleanName = trim($cleanName, '_');

        // Create filename
        $fileName = $cleanName . "_Cert_" . time() . "." . $req->file('certificate')->getClientOriginalExtension();

        // Store the file
        $path = $req->file('certificate')->storeAs('certificates', $fileName, 'private');

        // Update pivot table
        $trainingInstance->attendees()->updateExistingPivot($attendeeId, [
            'certificate_path' => $path,
        ]);

        return response()->json(['message' => 'Certificate uploaded successfully']);
    }

    public function deleteCertificate($trainingId, $attendeeId) {
        $trainingInstance = TrainingInstance::findOrFail($trainingId);
        $attendee = $trainingInstance->attendees()->findOrFail($attendeeId);
        $path = $attendee->pivot->certificate_path;

        if (!$path || !Storage::disk('private')->exists($path)) {
            return response()->json(['message' => 'No certificate found'], 404);
        }

        Storage::disk('private')->delete($path);
        $trainingInstance->attendees()->updateExistingPivot($attendeeId, [
            'certificate_path' => null,
        ]);

        return response()->json(['message' => 'Certificate deleted successfully']);
    }

    public function suggestTitles(Request $request) {
        $query = $request->input('q');

        $results = Training::with('instances') // get related instance
            ->where('training_title', 'like', "%{$query}%")
            //->limit(10)
            ->get()
            ->map(function ($training) {
                return [
                    'id' => $training->id,
                    'training_title' => $training->training_title,
                    'learning_description_type' => $training->learning_description_type,
                    'training_nature' => $training->training_nature,
                    'is_gad_related' => $training->is_gad_related,
                    // Add more fields if needed
                ];
            });

        return response()->json($results);
    }

    public function getTrainingTypes()
    {
        // Get enum values from the `learning_description_type` column
        $typeValues = DB::select("SHOW COLUMNS FROM trainings WHERE Field = 'learning_description_type'");
        preg_match("/^enum\((.*)\)$/", $typeValues[0]->Type, $matches);

        $types = [];
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $types[] = [
                'label' => ucfirst($v),
                'value' => $v
            ];
        }

        return response()->json($types);
    }

    public function getTrainingTitle($id){
        $training = Training::findOrFail($id);

        return response()->json([
            'training_title' => $training->training_title
        ]);
    }
}
