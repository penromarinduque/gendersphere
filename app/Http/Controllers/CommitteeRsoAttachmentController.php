<?php

namespace App\Http\Controllers;

use App\Models\CommitteeRsoAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class CommitteeRsoAttachmentController extends Controller
{
    //
    public function store(Request $request)
    {
        // Handle the file upload logic here
        // Validate the request, save the file, etc.
        
        $request->validate([
            'year' => 'required|integer',
            'rso' => 'required|file|mimes:pdf|max:2048', // 2MB max size
        ]);

        return DB::transaction(function () use ($request) {
            $rso = CommitteeRsoAttachment::where('year', $request->year)->first();
    
            $request->file('rso')->storeAs('rso_attachments', $request->year . '.' . $request->file('rso')->getClientOriginalExtension(), 'private');
    
            if($rso) {
                // Update existing record
                $rso->update([
                    'year' => $request->year,
                    'file_name' => $request->year . '.' . $request->file('rso')->getClientOriginalExtension(),
    
                ]);
            } else {
                // Create new record
                CommitteeRsoAttachment::create([
                    'year' => $request->year,
                    'file_name' => $request->year . '.' . $request->file('rso')->getClientOriginalExtension(),
                ]);
            }
    
            return response()->json(['message' => 'File uploaded successfully'], 200);
        });
    }

    public function show(Request $request)
    {
        // Retrieve the file based on the year
        $rso = CommitteeRsoAttachment::where('year', $request->year)->first();

        if (!$rso) {
            abort(404, 'RSO file not found for the specified year.');
        }
        // Return the file as a response
        $file = Storage::disk('private')->get('rso_attachments/' . $rso->file_name);
        if (!$file) {
            abort(404, 'File not found in storage.');
        }
        return response($file, 200)
            ->header('Content-Type', 'application/pdf');
    }
}
