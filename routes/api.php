<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\surveyController;
use App\Http\Controllers\FormController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/submit-form', [FormController::class, 'submitForm']);
Route::post('/respuestaCorta', [surveyController::class, 'respuestaCorta']);
Route::post('/respuestaLarga', [surveyController::class, 'respuestaLarga']);