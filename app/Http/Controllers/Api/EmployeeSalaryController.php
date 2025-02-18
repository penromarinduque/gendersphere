<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeSalary;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeSalaryResource;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $person_info_id = $request->person_info_id;
        $salaries = EmployeeSalary::select('employee_salaries.*')->where('person_info_id', $person_info_id)->orderBy('salary_year', 'DESC')->get();
        return EmployeeSalaryResource::collection($salaries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'salary_year' => ['required'],
            'amount' => ['required'],
        ], [
            'salary_year.required' => 'The year field is required.'
        ]);

        $employeesalary = EmployeeSalary::create([
            'person_info_id' => $request->person_info_id,
            'salary_year' => $request->salary_year,
            'amount' => $request->amount,
        ]);

        return new EmployeeSalaryResource($employeesalary);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeSalary $employeeSalary)
    {
        //
    }
}
