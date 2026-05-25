<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'pressure'    => ['nullable', 'numeric', 'min:0', 'max:10000', 'required_without:valeur'],
            'valeur'      => ['nullable', 'numeric', 'min:0', 'max:10000', 'required_without:pressure'],
            'voltage'     => ['required', 'numeric', 'min:0', 'max:100'],
            'watermark'   => ['nullable', 'numeric', 'min:0', 'max:200'],
            'device_id'   => ['nullable', 'string', 'max:64'],
            'recorded_at' => ['nullable', 'date'],
        ]);

        $pressure = (float) ($validated['pressure'] ?? $validated['valeur']);

        $row = SensorData::create([
            'pressure'    => $pressure,
            'voltage'     => (float) $validated['voltage'],
            'watermark'   => (float) ($validated['watermark'] ?? 0),
            'device_id'   => $validated['device_id'] ?? 'esp32-main',
            'recorded_at' => $validated['recorded_at'] ?? now(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => $row,
        ], 201);
    }

    public function index(Request $request): JsonResponse
    {
        $limit = max(1, min((int) $request->integer('limit', 5000), 20000));
        $date  = $request->query('date');

        $query = SensorData::query();

        if ($date) {
            $query->whereDate('recorded_at', $date);
        }

        $total = (clone $query)->count();

        $data = $query
            ->latest('recorded_at')
            ->latest('id')
            ->limit($limit)
            ->get();

        return response()->json([
            'success'       => true,
            'count'         => $data->count(),
            'total_records' => $total,
            'selected_date' => $date,
            'data'          => $data,
        ]);
    }
}
