<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// License Verification API (public - no auth required)
Route::post('/license/verify', [\App\Http\Controllers\Api\LicenseApiController::class, 'verify']);
Route::post('/license/deactivate', [\App\Http\Controllers\Api\LicenseApiController::class, 'deactivate']);
