<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\IoTController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ── sensor_data (ancien) ──
Route::get('/sensor-data',  [SensorDataController::class, 'index']);
Route::post('/sensor-data', [SensorDataController::class, 'store']);

// ── Export Excel ──
Route::get('/export', [ExportController::class, 'export']);

// ── IoT Nouveaux Capteurs ──
Route::post('/pression',  [IoTController::class, 'storePression']);
Route::get('/pression',   [IoTController::class, 'indexPression']);
Route::post('/watermark', [IoTController::class, 'storeWatermark']);
Route::get('/watermark',  [IoTController::class, 'indexWatermark']);
Route::post('/electrique', [IoTController::class, 'storeElectrique']);
Route::get('/electrique',  [IoTController::class, 'indexElectrique']);
