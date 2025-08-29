<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignatoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Signatory::all();
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeGpbSignatory(Request $request) {
        $request->validate([
            'prepared_by' => 'required|exists:committee_positions,id',
            'approved_by' => 'required|exists:committee_positions,id'
        ]);

        return DB::transaction(function () use ($request) {
            $approved_by = Signatory::where('report', 'gpb')->where('label', 'Approved By')->first();
            $prepared_by = Signatory::where('report', 'gpb')->where('label', 'Prepared By')->first();
            if($approved_by) {
                $approved_by->update([
                    'signatory' => $request->approved_by
                ]);
            } else {
                Signatory::create([
                    'report' => 'gpb',
                    'label' => 'Approved By',
                    'signatory' => $request->approved_by
                ]);
            }
            if($prepared_by) {
                $prepared_by->update([
                    'signatory' => $request->prepared_by
                ]);
            } else {
                Signatory::create([
                    'report' => 'gpb',
                    'label' => 'Prepared By',
                    'signatory' => $request->prepared_by
                ]);
            }
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    }
}
