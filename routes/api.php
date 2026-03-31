<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguratorController;
Route::middleware(['auth:sanctum'])->group(function () {

Route::post('/configurator/validate', [ConfiguratorController::class, 'validateConfiguration']);

// Add this new route for machine components
Route::get('/machine-components/{machineId}', [ConfiguratorController::class, 'getMachineComponents']);
});