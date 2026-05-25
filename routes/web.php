<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Exports\SensorDataExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/branding/inra-logo', function () {
    $logoPath = 'C:\\Users\\CYBORG19\\.cursor\\projects\\c-xampp-htdocs-pression-iot\\assets\\c__Users_CYBORG19_AppData_Roaming_Cursor_User_workspaceStorage_09192478557f0c02c9c66476feba82df_images_image-87cd8df6-ea1b-4161-b4c5-11e3479fee09.png';
    abort_unless(is_file($logoPath), 404);
    return response()->file($logoPath);
})->name('branding.inra-logo');

Route::get('/dashboard', [DashboardController::class, 'index']);

// ── EXPORT EXCEL ──
Route::get('/export', function (Request $request) {
    $type = $request->get('type', 'day');
    $date = $request->get('date', now()->toDateString());
    $filename = "INRA_pression_{$type}_{$date}.xlsx";
    return Excel::download(new SensorDataExport($type, $date), $filename);
});
Route::get('/electrique', [DashboardController::class, 'electrique']);
