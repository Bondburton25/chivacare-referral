<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController
};

use App\Http\Controllers\{
    EmployeeController,
    PatientController
};


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

Auth::routes();

// Login with LINE
Route::controller(LoginController::class)->group(function () {
    Route::get('/auth/line', [LoginController::class, 'redirectToLine']);
    Route::get('/auth/line/callback', [LoginController::class, 'handleLineCallback']);
});

// Register
Route::get('register-employee', [RegisterController::class, 'registerEmployee'])->name('register.employee');
Route::post('register-line-store', [RegisterController::class, 'registerLine'])->name('register.line.store');

// Homepage
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Authentication
Route::group(['middleware' => ['auth']], function () {
    Route::resource('/patients', PatientController::class)->except(['show']);
    Route::put('/patients/{patient}/end_service', [PatientController::class, 'endService'])->name('patients.end-service');

    Route::middleware([managePatient::class])->group(function() {
        Route::resource('/patients', PatientController::class)->only(['show']);
    });

    Route::middleware([onlySuperAdmin::class])->group(function() {
        Route::resource('/employees', EmployeeController::class)->only(['index', 'show', 'update']);
    });

    Route::get('patient-referral-fees', PatientController::class, 'referralFees')->name('patients.referral-fees');
});


URL::forceScheme('https');
