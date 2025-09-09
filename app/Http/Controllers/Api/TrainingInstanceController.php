<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingRequest;
use App\Http\Resources\TrainingResource;
use App\Models\TrainingInstance;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class TrainingInstanceController extends Controller
{
    // List all training instances
    public function index()
    {
        $instances = TrainingInstance::with('training')->latest()->get();

        return response()->json([
            'data' => $instances
        ]);
    }

    // Create a new training instance
    public function store(Request $request) {
        $validated = $request->validate([
            // Training fields
            'training_title' => 'required|string',
            'learning_description_type' => 'required|string',
            'training_nature' => 'required|string',
            'gad_related' => 'required|in:Yes,No',

            // Instance fields
            'training_start' => 'required|date',
            'training_end' => 'required|date|after_or_equal:training_start',
            'duration_hours' => 'required|integer|min:1',
            'sponsor_facilitator' => 'required|string',
            'office_id' => 'nullable|integer|exists:offices,id',
        ]);

        // Check if training exists (case-insensitive)
        $training = Training::whereRaw('LOWER(training_title) = ?', [strtolower($validated['training_title'])])->first();

        if (!$training) {
            // Create training if it doesn't exist
            $training = Training::create([
                'training_title' => $validated['training_title'],
                'learning_description_type' => $validated['learning_description_type'],
                'training_nature' => $validated['training_nature'],
                'gad_related' => $validated['gad_related'],
            ]);
        }
        
        // Create the training instance
        $instance = TrainingInstance::create([
            'training_id' => $training->id,
            'training_start' => $validated['training_start'],
            'training_end' => $validated['training_end'],
            'duration_hours' => $validated['duration_hours'],
            'sponsor_facilitator' => $validated['sponsor_facilitator'],
            'office_id' => $validated['office_id'] ?? null,
        ]);

        return response()->json([
            'message' => 'Training instance created successfully',
            'data' => $instance
        ]);
    }

    public function destroy($id) {
        try {
            $instance = TrainingInstance::findOrFail($id);

            $instance->attendees()->detach();

            $instance->delete();

            return response()->json(['message' => 'Training instance deleted.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete training instance.',
                'error' => $e->getMessage(), // This will show the actual problem
            ], 500);
        }
    }

    // Assign attendees to a training instance
    public function assignAttendees(Request $request, $id)  {
        $instance = TrainingInstance::findOrFail($id);

        $validated = $request->validate([
            'attendees' => 'required|array',
            'attendees.*.id' => 'required|exists:person_info,id',
            'attendees.*.certificate_path' => 'nullable|string',
        ]);

        $attachData = [];
        foreach ($validated['attendees'] as $attendee) {
            $attachData[$attendee['id']] = [
                'certificate_path' => $attendee['certificate_path'] ?? null,
            ];
        }

        $instance->attendees()->syncWithoutDetaching($attachData);

        return response()->json([
            'message' => 'Attendees assigned successfully'
        ]);
    }
    public function getTrainingTitle($id)   {
        $trainingInstance = TrainingInstance::with('training')->find($id);

        if (!$trainingInstance || !$trainingInstance->training) {
            return response()->json(['message' => 'Training or Training Instance not found'], 404);
        }

        return response()->json(['training_title' => $trainingInstance->training->training_title]);
    }

}
