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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');


Route::get('/agent', [App\Http\Controllers\HomeController::class, 'agent'])->name('agent');
Route::get('/agentlist', [App\Http\Controllers\HomeController::class, 'agentlist'])->name('agentlist');
Route::post('/agentcreate', [App\Http\Controllers\HomeController::class, 'agentcreate'])->name('agentcreate');


Route::get('/leadslist', [App\Http\Controllers\HomeController::class, 'leadslist'])->name('leadslist');
Route::get('/addlead', [App\Http\Controllers\HomeController::class, 'addlead'])->name('addlead');
Route::get('/leadedit/{leadId}', [App\Http\Controllers\HomeController::class, 'leadedit'])->name('leadedit');
Route::post('/editlead', [App\Http\Controllers\HomeController::class, 'editlead'])->name('editlead');
Route::get('/export-csv', [App\Http\Controllers\ExportController::class, 'exportCsv']);

Route::post('/importcsv', [App\Http\Controllers\ExportController::class, 'importCsv'])->name('importcsv');
Route::post('/createnewlead', [App\Http\Controllers\HomeController::class, 'createnewlead'])->name('createnewlead');
Route::get('/agent', [App\Http\Controllers\HomeController::class, 'agent'])->name('agent');


Route::get('/bulkupload', [App\Http\Controllers\HomeController::class, 'bulkupload'])->name('bulkupload');
Route::get('/lead_type', [App\Http\Controllers\HomeController::class, 'lead_type'])->name('lead_type');
Route::post('/leadtypefetch', [App\Http\Controllers\HomeController::class, 'leadtypefetch'])->name('leadtypefetch');
Route::post('/leadtypeedit', [App\Http\Controllers\HomeController::class, 'leadtypeedit'])->name('leadtypeedit');
Route::post('/add_leadtype', [App\Http\Controllers\HomeController::class, 'add_leadtype'])->name('add_leadtype');
Route::get('/roomtype', [App\Http\Controllers\HomeController::class, 'roomtype'])->name('roomtype');
Route::post('/add_roomtype', [App\Http\Controllers\HomeController::class, 'add_roomtype'])->name('add_roomtype');
Route::post('/roomtypefetch', [App\Http\Controllers\HomeController::class, 'roomtypefetch'])->name('roomtypefetch');
Route::post('/roomtypeedit', [App\Http\Controllers\HomeController::class, 'roomtypeedit'])->name('roomtypeedit');
Route::get('/extras', [App\Http\Controllers\HomeController::class, 'extras'])->name('extras');
Route::post('/add_addons', [App\Http\Controllers\HomeController::class, 'add_addons'])->name('add_addons');
Route::post('/addonfetch', [App\Http\Controllers\HomeController::class, 'addonfetch'])->name('addonfetch');
Route::post('/addonedit', [App\Http\Controllers\HomeController::class, 'addonedit'])->name('addonedit');
Route::get('/notification', [App\Http\Controllers\HomeController::class, 'notification'])->name('notification');
Route::get('/addtask', [App\Http\Controllers\HomeController::class, 'addtask'])->name('addtask');
Route::post('/createnewtask', [App\Http\Controllers\HomeController::class, 'createnewtask'])->name('createnewtask');
Route::get('/assignleads', [App\Http\Controllers\HomeController::class, 'assignleads'])->name('assignleads');
Route::post('/assignuser', [App\Http\Controllers\HomeController::class, 'assignuser'])->name('assignuser');
Route::post('/reasignuser', [App\Http\Controllers\HomeController::class, 'reasignuser'])->name('reasignuser');



Route::get('/employeelist', [App\Http\Controllers\EmployeeController::class, 'employeelist'])->name('employeelist');
Route::get('/addemployee', [App\Http\Controllers\EmployeeController::class, 'addemployee'])->name('addemployee');
Route::post('/createnewemployee', [App\Http\Controllers\EmployeeController::class, 'createnewemployee'])->name('createnewemployee');
Route::get('/employeeedit/{employeeId}', [App\Http\Controllers\EmployeeController::class, 'employeeedit'])->name('employeeedit');
Route::post('/editemployee', [App\Http\Controllers\EmployeeController::class, 'editemployee'])->name('editemployee');



Route::get('/reminderlist/{leadId}', [App\Http\Controllers\HomeController::class, 'reminderlist'])->name('reminderlist');
Route::post('/reminderstore', [App\Http\Controllers\HomeController::class, 'reminderstore'])->name('reminderstore');
Route::get('/tasklist', [App\Http\Controllers\HomeController::class, 'tasklist'])->name('tasklist');
Route::post('/createtask', [App\Http\Controllers\HomeController::class, 'createtask'])->name('createtask');
Route::get('/taskcreate', [App\Http\Controllers\HomeController::class, 'taskcreate'])->name('taskcreate');
Route::get('/taskedit/{taskId}', [App\Http\Controllers\HomeController::class, 'taskedit'])->name('taskedit');
Route::post('/updateTask', [App\Http\Controllers\HomeController::class, 'updateTask'])->name('updateTask');
