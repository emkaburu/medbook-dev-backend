<?php

use Illuminate\Http\Request;
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

// Get all patient records
Route::post('patients', 'Api\PatientsController@index')->name('patients');

//Create a patient
Route::post('patient-create', 'Api\PatientsController@store')->name('patient_create');

// Update Patient
Route::put('patient-update/{id}', 'Api\PatientsController@update')->name('patient_update');

//Delete Patient
Route::delete('patient-delete/{id}', 'Api\PatientsController@destroy')->name('patient_delete');

// Fetch one patient
Route::get('patient/{id}', 'Api\PatientsController@show')->name('patient');

// Fetch genders
Route::post('genders', 'Api\GenderController@index')->name('genders');


// Fetch services
Route::post('services', 'Api\ServiceController@index')->name('services');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
