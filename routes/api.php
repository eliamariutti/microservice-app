<?php

use App\Actions\CreateNewJob;
use App\Actions\GetResults;
use Illuminate\Support\Facades\Route;

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

Route::post('/jobs', CreateNewJob::class);
Route::get('/jobs/{id}', GetResults::class);