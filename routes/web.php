<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
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

Route::get('/', function () {return redirect('/');});

Route::get('/{id?}', [PageController::class, 'survey'])->name('survey');

Route::get('/otra-pagina', [PageController::class, 'questions'])->name('questions');