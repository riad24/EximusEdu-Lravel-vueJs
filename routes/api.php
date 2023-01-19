<?php


use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\InstituteController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::match(['get', 'post'], '/login', function () {
    return response()->json(['errors' => 'unauthenticated'], 401);
})->name('login');

Route::prefix('auth')->name('auth.')->namespace('Auth')->group(function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/resend/email/token', [RegisterController::class, 'resendPin']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/verify/pin', [ForgotPasswordController::class, 'verifyPin']);
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('verify/email', [RegisterController::class, 'verifyEmail']);
        Route::middleware('verify.api')->group(function () {
            Route::post('/logout', [LoginController::class, 'logout']);
        });
    });
});

Route::prefix('admin')->name('admin.')->middleware('auth:sanctum', 'verify.api')->group(function () {


    Route::prefix('institute')->name('institute.')->group(function () {
        Route::get('/', [InstituteController::class, 'index']);
        Route::get('/show/{institute}', [InstituteController::class, 'show']);
        Route::post('/', [InstituteController::class, 'store']);
        Route::match(['post', 'put', 'patch'], '/{institute}', [InstituteController::class, 'update']);
        Route::delete('/{institute}', [InstituteController::class, 'destroy']);
        Route::get('/export', [InstituteController::class, 'export']);
    });



});
