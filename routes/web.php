<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController
};

use App\Http\Controllers\{
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

URL::forceScheme('https');

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
Route::post('register-line-store', [RegisterController::class, 'registerLine'])->name('register.line.store');

// Homepage
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Authentication
Route::group(['middleware' => ['auth']], function () {
    Route::resource('/patients', PatientController::class);
});
