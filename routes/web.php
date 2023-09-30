<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// routes/web.php

Route::get('/download-csv-template', 'App\Http\Controllers\EmployeeController@downloadCsvTemplate')->name('download-csv-template');


Route::post('/import', 'App\Http\Controllers\EmployeeController@store')->name('import');

Route::get('/','App\Http\Controllers\EmployeeController@list_emp');


Route::get('/Home','App\Http\Controllers\EmployeeController@list_emp');

Route::get('/AddEmployee','App\Http\Controllers\EmployeeController@add_emp');



Route::post('/new_employee','App\Http\Controllers\EmployeeController@new_emp');

Route::get('/view_emp/{employee_id}','App\Http\Controllers\EmployeeController@view_employee');

Route::get('/edit_emp/{employee_id}','App\Http\Controllers\EmployeeController@edit_employee');

Route::post('/update_employee','App\Http\Controllers\EmployeeController@update_emp');

Route::get('/del_emp/{employee_id}','App\Http\Controllers\EmployeeController@delete_employee');
