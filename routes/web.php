<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Person Info
    Route::get('/personinfos/{any?}', function () {
        return view('personinfos');
        // Route::view('/personinfos/{any}', 'personinfos')->where('any', '.*');
    })->where('any', '.*')->name('personinfos');

    // Route::view('/personinfos/{any}', 'personinfos')
    // ->middleware(['auth'])
    // ->where('any', '.*');

    // GAD Committees
    Route::get('/committees/{any?}', function () {
        return view('committees');
        Route::view('/committees/{any}', 'committees')->where('any', '.*');
    })->where('any', '.*')->name('committees');

    // GAD Plan and Budget
    Route::get('/planbudgets/{any?}', function () {
        return view('planbudgets');
        Route::view('/planbudgets/{any}', 'planbudgets')->where('any', '.*');
    })->where('any', '.*')->name('planbudgets');

    // GAD Activities
    Route::get('/activities', function () {
        return view('activities');
        Route::view('/activities/{any}', 'activities')->where('any', '.*');
    })->name('activities');
    Route::get('/pages/gadactivities', function () {
        return view('pages.gadactivities');
        Route::view('/pages/gadactivities/{any}', 'pages.gadactivities')->where('any', '.*');
    })->name('pages.gadactivities');

    // GAD Activity Details
    Route::get('/activitydetails', function () {
        return view('activitydetails');
        Route::view('/activitydetails/{any}', 'activitydetails')->where('any', '.*');
    })->name('activitydetails');

    // Frontline Services
    Route::get('/frontlineservices/{any?}', function () {
        return view('frontlineservices');
        Route::view('/frontlineservices/{any}', 'frontlineservices')->where('any', '.*');
    })->where('any', '.*')->name('frontlineservices');

    // Users
    Route::get('/users/{any?}', function () {
        return view('users');
        Route::view('/users/{any}', 'users')->where('any', '.*');
    })->where('any', '.*')->name('users');

    // Maintenance - Committee Positions
    Route::get('/maintenance/committeepositions/{any?}', function () {
        return view('maintenance.committeepositions');
        Route::view('/maintenance/committeepositions/{any}', 'maintenance.committeepositions')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.committeepositions');

    // Maintenance - Goals
    Route::get('/maintenance/goals/{any?}', function () {
        return view('maintenance.goals');
        Route::view('/maintenance/goals/{any}', 'maintenance.goals')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.goals');

    // Maintenance - Gender Issues
    Route::get('/maintenance/genderissues/{any?}', function () {
        return view('maintenance.genderissues');
        Route::view('/maintenance/genderissues/{any}', 'maintenance.genderissues')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.genderissues');

    // Maintenance - Causes  of Gender Issues
    Route::get('/maintenance/causegenderissues/{any?}', function () {
        return view('maintenance.causegenderissues');
        Route::view('/maintenance/causegenderissues/{any}', 'maintenance.causegenderissues')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.causegenderissues');

    // Maintenance - GAD Objectives
    Route::get('/maintenance/objectives/{any?}', function () {
        return view('maintenance.objectives');
        Route::view('/maintenance/objectives/{any}', 'maintenance.objectives')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.objectives');

    // Maintenance - Frontline Services Types
    Route::get('/maintenance/frontlineservicetypes/{any?}', function () {
        return view('maintenance.frontlineservicetypes');
        Route::view('/maintenance/frontlineservicetypes/{any}', 'maintenance.frontlineservicetypes')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.frontlineservicetypes');

    // Maintenance - Permit Types
    Route::get('/maintenance/permittypes/{any?}', function () {
        return view('maintenance.permittypes');
        Route::view('/maintenance/permittypes/{any}', 'maintenance.permittypes')->where('any', '.*');
    })->where('any', '.*')->name('maintenance.permittypes');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reports
    Route::group(['prefix'=>'report', 'as' => 'report.'], function(){
        Route::get('/employees/{employment_type?}', [ReportController::class, 'employees'])->name('employees');
        Route::get('/gadplanbudgets', [ReportController::class, 'gadPlanBudgets'])->name('gadplanbudgets');
        Route::get('/sexaggregated', [ReportController::class, 'sexAggregated'])->name('sexaggregated');
        Route::get('/sexaggregated-print', [ReportController::class, 'sexAggregatedPrint'])->name('sexaggregated-print');
        Route::get('/getpermittypes/{frontlineservicetype_id?}', [ReportController::class, 'getPermitTypes'])->name('getpermittypes');
    });
});
    
require __DIR__.'/auth.php';
