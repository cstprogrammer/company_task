<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::post('/user/search', [UserController::class, 'search'])
            ->name('user.search');

    Route::resource('users', UserController::class);

   Route::resource('companies', CompanyController::class);

    Route::resource('departments', DepartmentController::class);

    Route::resource('employees', EmployeeController::class);
});

Auth::routes([
    'register'  => false,
    'reset'     => false,
    'verify'    => false,
    'confirm'   => false,
]);
