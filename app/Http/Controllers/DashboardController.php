<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Committee;
use App\Models\FrontlineService;
use App\Models\PersonInfo;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $year = $request->has('year') ? $request->year : date('Y');

        return (object)[
            'totals' => [
                'users' => User::where('is_active', 1)->count(),
                'personnels' => PersonInfo::where('person_type', 1)->count(),
                'committees' => Committee::where('year_covered', $year)->count(),
                'frontlineServices' => FrontlineService::whereYear('date_released', $year)->count(),
            ]
        ];
    }
}
