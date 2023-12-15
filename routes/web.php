<?php

use App\Http\Controllers\EmployeeController;
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

Route::get('/',[EmployeeController::class,'index'])->name('employees.index');

Route::match(['get', 'post'], 'employees/store', [EmployeeController::class,'store']);

Route::get('/employees/{id}', [EmployeeController::class, 'show']);

// Route::get('/employee-update/{id}', [EmployeeController::class, 'update']);
// Route::post('/update-employee/{id}',[EmployeeController::class, 'update']);
Route::match(['get', 'post'], '/update-employee/{id}', [EmployeeController::class,'update']);

Route::delete('employee/{id}/delete',[EmployeeController::class,'destroy'])->name('employees.delete');

Route::get('get-designations/{id}',[EmployeeController::class,'getDesignations'])->name('get-designations');













//Route::get('get-designations-update',[EmployeeController::class,'getDesignationsupdate'])->name('get-designationsupdate');

//Route::get('/employees/create',[EmployeeController::class,'create'])->name('employees.create');
//Route::post('/employees/store',[EmployeeController::class,'store'])->name('employees.store');
//Route::get('employees/{id}/edit',[EmployeeController::class,'edit'])->name('employees.edit');
//Route::put('employees/{id}/update',[EmployeeController::class,'update'])->name('employees.update');
//Route::put('/update-user-data',[EmployeeController::class,'update'])->name('/update-user-data');
//Route::get('get-designations', 'EmployeeController@getDesignations')->name('get-designations');
//Route::get('/employees/designation',[EmployeeController::class,'designation']);

//Route::get('get-user-data',[EmployeeController::class,'edit'])->name('get-user-data');
//Route::put('/employees/{id}', [EmployeeController::class, 'update']);
// Route::get('/employees/{id}', [EmployeeController::class, 'edit']);
// Route::get('employees/{id}',[EmployeeController::class,'edit']);

