<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiToken;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VersionController;


//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/data', [ParticipantController::class, 'index']  )->middleware([ApiToken::class]);

Route::get('/version', [VersionController::class, 'index']  )->middleware([ApiToken::class]);

Route::post('/participant', [ParticipantController::class, 'store']  )->middleware([ApiToken::class]);

Route::post('/volunteer', [VolunteerController::class, 'store']  )->middleware([ApiToken::class]);
