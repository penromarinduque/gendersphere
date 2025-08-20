<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Committee;
use App\Models\FrontlineService;
use App\Models\PersonInfo;
use App\Models\User;
use App\Models\Training;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $year = $request->has('year') ? $request->year : date('Y');
        $user = auth()->user();
        $office_id = $user->office_id; 
        $user_count = User::where('is_active', 1)->whereYear('created_at', $year)->count();
        $personnel_count = PersonInfo::where('person_type', 1)->whereYear('created_at', $year)->count();
        $committee_count = Committee::where('year_covered', $year)->count();
        $frontline_service_count= FrontlineService::whereYear('date_released', $year)->count();
        $training_count = Training::whereYear('training_start', $year)->count();
            
        if (!$user?->is_super_admin) {
            $user_count = User::where('is_active', 1)->where('office_id', $office_id)->whereYear('created_at', $year)->count();
            $personnel_count = PersonInfo::where('person_type', 1)->where('office_id', $office_id)->whereYear('created_at', $year)->count();
            $committee_count = Committee::where('year_covered', $year)->where('office_id', $office_id)->count();
            $frontline_service_count = FrontlineService::whereYear('date_released', $year)->where('office_id', $office_id)->count();
            $training_count = Training::whereYear('training_start', $year)->where('office_id', $office_id)->count();
        }
        return (object)[
            'totals' => [
                'users' => $user_count,
                'personnels' => $personnel_count,
                'committees' => $committee_count,
                'frontlineServices' => $frontline_service_count,
                'trainings' => $training_count 
            ]
        ];
    }
}
