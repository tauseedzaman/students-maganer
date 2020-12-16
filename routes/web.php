<?php

use Illuminate\Support\Facades\Route;



// student app with ajax routes
Route::get('students',[\App\Http\Controllers\studentscrudController::class,'index']);
Route::post('students-store',[\App\Http\Controllers\studentscrudController::class,'store']);
Route::get('students-loaddata',[\App\Http\Controllers\studentscrudController::class,'loaddata']);
Route::post('students-edit',[\App\Http\Controllers\studentscrudController::class,'edit']);
Route::post('students-delete',[\App\Http\Controllers\studentscrudController::class,'delete']);
Route::post('students-delete-all',[\App\Http\Controllers\studentscrudController::class,'delete_all']);
Route::post('students-update',[\App\Http\Controllers\studentscrudController::class,'update']);
