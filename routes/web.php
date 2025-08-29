<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ActivityDetailController;
use App\Http\Controllers\Api\BarangayController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Models\ActivityDetail;
use App\Models\CauseGenderIssue;
use App\Models\Committee;
use App\Models\CommitteePosition;
use App\Models\FrontlineService;
use App\Models\FrontlineServiceType;
use App\Models\GenderIssue;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\Office;
use App\Models\PermitType;
use App\Models\PersonInfo;
use App\Models\PlanBudget;
use App\Models\Signatory;
use App\Models\Training;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Person Info
    Route::get('/personinfos/{any?}', function () {
        return view('personinfos');
        // Route::view('/personinfos/{any}', 'personinfos')->where('any', '.*');
    })->where('any', '.*')->name('personinfos')->can('viewAny', PersonInfo::class);

    // Route::view('/personinfos/{any}', 'personinfos')
    // ->middleware(['auth'])
    // ->where('any', '.*');

    // GAD Committees
    Route::get('/committees/{any?}', function () {
        return view('committees');
        Route::view('/committees/{any}', 'committees')->where('any', '.*');
    })->where('any', '.*')->name('committees')->can('viewAny', Committee::class);

    // GAD Plan and Budget
    Route::get('/planbudgets/{any?}', function () {
        return view('planbudgets');
        Route::view('/planbudgets/{any}', 'planbudgets')->where('any', '.*');
    })->where('any', '.*')->name('planbudgets')->can('viewAny', PlanBudget::class);

    // GAD Activities
    Route::get('/activities/{any?}', function () {
        return view('activities');
        Route::view('/activities/{any}', 'activities')->where('any', '.*');
    })->name('activities');
    Route::get('/pages/gadactivities', function () {
        return view('pages.gadactivities');
        Route::view('/pages/gadactivities/{any}', 'pages.gadactivities')->where('any', '.*');
    })->where('any', '.*')->name('pages.gadactivities');

    // GAD Activity Details
    Route::prefix('activitydetails')->group(function () {
        Route::post('upload-mov', [ActivityDetailController::class, 'uploadMov']);
        Route::get('download-mov', [ActivityDetailController::class, 'downloadMov']);
        Route::get('/{any?}', function () {
            return view('activitydetails');
            Route::view('/activitydetails/{any}', 'activitydetails')->where('any', '.*');
        })->where('any', '.*')->name('activitydetails');
    });

    // Frontline Services
    Route::get('/frontlineservices/{any?}', function () {
        return view('frontlineservices');
        Route::view('/frontlineservices/{any}', 'frontlineservices')->where('any', '.*');
    })->where('any', '.*')->name('frontlineservices')->can('viewAny', FrontlineService::class);

    //Training
    Route::get('/trainings/{any?}', function () {
        return view('trainings');
        Route::view('/trainings/{any}', 'trainings')->where('any', '.*');
    })->where('any', '.*')->name('trainings')->can('viewAny', Training::class);

    // Users
    Route::get('/users/{any?}', function () {
        return view('users');
        Route::view('/users/{any}', 'users')->where('any', '.*');
    })->where('any', '.*')->name('users');

    // Maintenance - Committee Positions
    Route::get('/maintenance/committeepositions/{any?}', function () {
        return view('maintenance.committeepositions');
        Route::view('/maintenance/committeepositions/{any}', 'maintenance.committeepositions')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.committeepositions')->can('viewAny', CommitteePosition::class);

    // Maintenance - Goals
    // Route::get('/maintenance/goals/{any?}', function () {
    //     return view('maintenance.goals');
    //     Route::view('/maintenance/goals/{any}', 'maintenance.goals')->where('any', '.*');
    // })->where('any', '.*')->name('maintenance.goals');

    Route::get('/maintenance/goals/{any?}', function () {
        return view('maintenance.goals');
    })->where('any', '.*')->name('maintenance.goals')->can('viewAny', Goal::class);

    // Maintenance - Gender Issues
    Route::get('/maintenance/genderissues/{any?}', function () {
        return view('maintenance.genderissues');
        Route::view('/maintenance/genderissues/{any}', 'maintenance.genderissues')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.genderissues')->can('viewAny', GenderIssue::class);

    // Maintenance - Causes  of Gender Issues
    Route::get('/maintenance/causegenderissues/{any?}', function () {
        return view('maintenance.causegenderissues');
        Route::view('/maintenance/causegenderissues/{any}', 'maintenance.causegenderissues')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.causegenderissues')->can('viewAny', CauseGenderIssue::class);

    // Maintenance - GAD Objectives
    Route::get('/maintenance/objectives/{any?}', function () {
        return view('maintenance.objectives');
        Route::view('/maintenance/objectives/{any}', 'maintenance.objectives')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.objectives')->can('viewAny', Objective::class);

    // Maintenance - Frontline Services Types
    Route::get('/maintenance/frontlineservicetypes/{any?}', function () {
        return view('maintenance.frontlineservicetypes');
        Route::view('/maintenance/frontlineservicetypes/{any}', 'maintenance.frontlineservicetypes')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.frontlineservicetypes')->can('viewAny', FrontlineServiceType::class);

    // Maintenance - Permit Types
    Route::get('/maintenance/permittypes/{any?}', function () {
        return view('maintenance.permittypes');
        Route::view('/maintenance/permittypes/{any}', 'maintenance.permittypes')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.permittypes')->can('viewAny', PermitType::class);

    // Maintenance - Offices
    Route::get('/maintenance/offices/{any?}', function () {
        return view('maintenance.offices');
        Route::view('/maintenance/offices/{any}', 'maintenance.offices')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.offices')->can('viewAny', Office::class);

    // Maintenance - Signatories
    Route::get('/maintenance/signatories/{any?}', function () {
        return view('maintenance.signatories');
        Route::view('/maintenance/signatories/{any}', 'maintenance.signatories')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.signatories')->can('viewAny', Signatory::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reports
    Route::group(['prefix'=>'report', 'as' => 'report.'], function(){
        Route::get('/employees/{employment_type?}', [ReportController::class, 'employees'])->name('employees');
        Route::get('/gadplanbudgets', [ReportController::class, 'gadPlanBudgets'])->name('gadplanbudgets');
        Route::get('/gadplanbudgets/print', [ReportController::class, 'printGadPlanBudgets'])->name('printgadplanbudgets');
        Route::get('/sexaggregated', [ReportController::class, 'sexAggregated'])->name('sexaggregated');
        Route::get('/sexaggregated-print', [ReportController::class, 'sexAggregatedPrint'])->name('sexaggregated-print');
        Route::get('/getpermittypes/{frontlineservicetype_id?}', [ReportController::class, 'getPermitTypes'])->name('getpermittypes');
    });
    
    Route::group(['prefix'=>'error/{any?}', 'as' => 'error.'], function(){
        Route::view('', 'error')->name('error');
     
    });

});
Route::get("/test/{name}", [BarangayController::class, 'search']);    
    
require __DIR__.'/auth.php';
