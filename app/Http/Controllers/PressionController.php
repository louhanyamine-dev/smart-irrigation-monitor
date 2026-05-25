<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class PressionController extends Controller
{
    // ESP32 kattrsl data hna
    public function store(Request $request)
    {
        $pression = SensorData::create([
            'pressure'  => $request->valeur ?? $request->pressure,
            'voltage' => $request->voltage,
            'device_id' => $request->device_id ?? 'esp32-main',
            'recorded_at' => $request->recorded_at ?? now(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => $pression
        ]);
    }

    // Dashboard katqra data mn hna
    public function index()
    {
        $data = SensorData::orderBy('recorded_at', 'desc')
                        ->take(50)
                        ->get()
                        ->map(fn (SensorData $row) => [
                            'id' => $row->id,
                            'valeur' => $row->pressure,
                            'voltage' => $row->voltage,
                            'created_at' => $row->recorded_at ?? $row->created_at,
                        ]);
        return response()->json($data->values());
    }
}
