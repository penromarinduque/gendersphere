<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonInfoController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\GadActivityController;
use App\Http\Controllers\Api\ActivityDetailController;
use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\MunicipalityController;
use App\Http\Controllers\Api\BarangayController;
use App\Http\Controllers\Api\CommitteePositionController;
use App\Http\Controllers\Api\CommitteeController;
use App\Http\Controllers\Api\PlanBudgetController;
use App\Http\Controllers\Api\GoalController;
use App\Http\Controllers\Api\GenderIssueController;
use App\Http\Controllers\Api\CauseGenderIssueController;
use App\Http\Controllers\Api\ObjectiveController;
use App\Http\Controllers\Api\FrontlineServiceController;
use App\Http\Controllers\Api\FrontlineServiceTypeController;
use App\Http\Controllers\Api\PermitTypeController;
use App\Http\Controllers\Api\EmployeeSalaryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group( function () {
    Route::prefix('frontlineservices')->group(function () {
        Route::get('summary', [FrontlineServiceController::class, 'summary']);
    });

    Route::prefix('personinfos')->group(function () {
        Route::get('summary', [PersonInfoController::class, 'summary']);
    });

    Route::prefix('committees')->group(function () {
        Route::get('summary', [CommitteeController::class, 'summary']);
    });
    
    Route::apiResources([
        'personinfos' => PersonInfoController::class,
        'users' => UserController::class,
        'committees' => CommitteeController::class,
        'planbudgets' => PlanBudgetController::class,
        'activities' => ActivityController::class,
        'gadactivities' => GadActivityController::class,
        'activitydetails' => ActivityDetailController::class,
        'attendees' => AttendeeController::class,
        'frontlineservices' => FrontlineServiceController::class,
        'provinces' => ProvinceController::class,
        'municipalities' => MunicipalityController::class,
        'barangays' => BarangayController::class,
        'committeepositions' => CommitteePositionController::class,
        'goals' => GoalController::class,
        'genderissues' => GenderIssueController::class,
        'causegenderissues' => CauseGenderIssueController::class,
        'objectives' => ObjectiveController::class,
        'frontlineservicetypes' => FrontlineServiceTypeController::class,
        'permittypes' => PermitTypeController::class,
        'employeesalaries' => EmployeeSalaryController::class,
    ]);
    // PersonInfo
    Route::prefix('personinfos')->group(function () {
        Route::get('all/persons', [PersonInfoController::class, 'all']);
    });
    Route::get('yearlist', [CommitteeController::class, 'yearlist']);
    Route::get('genderissuebyyear/{year}', [GenderIssueController::class, 'genderIssueByYear']);
    Route::get('permittypebystatus/{status}', [PermitTypeController::class, 'getPermitTypeByStatus']);
    Route::post('updateaccom/{id}', [ActivityDetailController::class, 'updateAccom']);

    
});

// Route::apiResource('personinfos', PersonInfoController::class);
