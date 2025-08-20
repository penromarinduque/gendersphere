<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityDetailReportResource;
use App\Models\ActivityDetailReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ActivityDetailReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $office_id = auth()->user()->office_id;
        $activity_detail_id = $request->activity_detail_id;
        $activityDetailReports = ActivityDetailReport::where('activity_detail_id', $activity_detail_id)
        // ->whereHas('activityDetail.gad_activity.plan_budget', function ($query) use ($office_id) {
        //     $query->where('office_id', $office_id);
        // })
        ->get();
        return ActivityDetailReportResource::collection($activityDetailReports);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'activity_detail_id' => 'required|integer|exists:activity_details,id',
            'report' => 'required|file|mimes:pdf|max:2048', // 2MB max size
        ]);

        return DB::transaction(function () use ($request) {
            Gate::authorize('create', ActivityDetailReport::class);
            $name = $request->activity_detail_id . '_' . time() . '.' . $request->file('report')->getClientOriginalExtension();
            $request->file('report')->storeAs('activity_details', $name, 'private');
            ActivityDetailReport::create([
                'activity_detail_id' => $request->activity_detail_id,
                'file' => $name,
            ]);
            return response()->json(['message' => 'Report uploaded successfully'], 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $report = ActivityDetailReport::findOrFail($id);
        Gate::authorize('view', $report);
        $file = Storage::disk('private')->get('activity_details/' . $report->file);
        if (!$file) {
            abort(404, 'File not found in storage.');
        }
        return response($file, 200)->header('Content-Type', 'application/pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $activityDetailReport = ActivityDetailReport::findOrFail($id);
        Gate::authorize('delete', $activityDetailReport);
        Storage::disk('private')->delete('activity_details/' . $activityDetailReport->file);
        $activityDetailReport->delete();
    }
}
