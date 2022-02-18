<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testcontroller;
use App\Http\Controllers\projectcontroller;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('logintest',[testcontroller::class,'logintest']);
Route::post('registertest',[testcontroller::class,'registertest']);
//MY PROJECT
Route::post('login',[projectcontroller::class,'login']);
Route::post('register',[projectcontroller::class,'register']);
Route::get('getAdmin',[projectcontroller::class,'getadmin']);
Route::get('getEmergancy',[projectcontroller::class,'getemergancy']);
Route::get('getdoctors',[projectcontroller::class,'getdoctors']);
Route::get('mypatient/{id}',[projectcontroller::class,'mypatient']);
Route::post('addpatient',[projectcontroller::class,'addpatient']);
Route::get('doctorinfo/{id}',[projectcontroller::class,'doctorinfo']);
Route::get('allpatient',[projectcontroller::class,'allpatient']);
Route::get('getregistrar',[projectcontroller::class,'getregistrar']);
Route::get('onepatient/{id}',[projectcontroller::class,'onepatient']);
Route::put('updatepatient/{id}',[projectcontroller::class,'updatepatient']);
Route::put('updatedio/{id}',[projectcontroller::class,'updatedio']);
Route::delete('deletepatient/{id}',[projectcontroller::class,'deletepatient']);
//edit admin profile
Route::put('edit-all/{id}',[projectcontroller::class,'editall']);
Route::put('edit-data/{id}',[projectcontroller::class,'editdata']);
// edit registrar profile
Route::put('edit-registrar/{id}',[projectcontroller::class,'editregistrar']);
Route::put('edit-registrardata/{id}',[projectcontroller::class,'editregistrardata']);
//edit doctor profile
Route::put('edit-doctor/{id}',[projectcontroller::class,'editdoctor']);
Route::put('edit-doctordata/{id}',[projectcontroller::class,'editdoctordata']);
//patient by doctor
Route::get('pat-by-doctor/{id}',[projectcontroller::class,'patbydoctor']);
//edit patient by emergency
Route::put('edit-patient-by-emergency/{id}',[projectcontroller::class,'editpatientbyemergency']);
//edit patient by doctor
Route::put('edit-patient-by-doctor/{id}',[projectcontroller::class,'editpatientbydoctor']);
//edit emergency profile
Route::put('edit-emergency/{id}',[projectcontroller::class,'editemergency']);
Route::put('edit-emergencydata/{id}',[projectcontroller::class,'editemergencydata']);