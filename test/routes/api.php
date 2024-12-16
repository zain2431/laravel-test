<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::group(['middleware'=>'auth:sanctum'], function (){
    Route::post('/create-task',[TasksController::class,'store']);
    Route::get('/task-list',[TasksController::class,'index']);
    Route::get('/edit-task/{task}',[TasksController::class,'edit']);
    Route::post('/update-task/{task}',[TasksController::class,'update']);
    Route::get('/delete-task/{task}',[TasksController::class,'destroy']);
});