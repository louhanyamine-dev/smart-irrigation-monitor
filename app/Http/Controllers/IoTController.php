<?php

namespace App\Http\Controllers;

use App\Models\MesuresWatermark;
use App\Models\MesuresElectrique;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IoTController extends Controller
{
    // ══════════════════════════════════════
    // POST /api/watermark
    // ══════════════════════════════════════
    public function storeWatermark(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'w1'        => ['required', 'numeric', 'min:0', 'max:199'],
            'w2'        => ['required', 'numeric', 'min:0', 'max:199'],
            'w3'        => ['required', 'numeric', 'min:0', 'max:199'],
            'w4'        => ['nullable', 'numeric', 'min:0', 'max:199'],
            'w5'        => ['nullable', 'numeric', 'min:0', 'max:199'],
            'w6'        => ['nullable', 'numeric', 'min:0', 'max:199'],
            'device_id' => ['nullable', 'string',  'max:64'],
            'rssi'      => ['nullable', 'integer'],
            'timestamp' => ['nullable', 'date'],        // ← زيد
        ]);

        $row = MesuresWatermark::create([
            'watermark1'  => (float) $validated['w1'],
            'watermark2'  => (float) $validated['w2'],
            'watermark3'  => (float) $validated['w3'],
            'watermark4'  => (float) ($validated['w4'] ?? 0),
            'watermark5'  => (float) ($validated['w5'] ?? 0),
            'watermark6'  => (float) ($validated['w6'] ?? 0),
            'device_id'   => $validated['device_id']  ?? 'esp32-watermark',
            'recorded_at' => $validated['timestamp']  ?? now(), // ← بدل
        ]);

        return response()->json(['success' => true, 'data' => $row], 201);
    }

    // ══════════════════════════════════════
    // GET /api/watermark?date=2024-01-01
    // ══════════════════════════════════════
    public function indexWatermark(Request $request): JsonResponse
    {
        $limit = max(1, min((int) $request->integer('limit', 5000), 20000));
        $date  = $request->query('date');

        $query = MesuresWatermark::query();
        if ($date) $query->whereDate('recorded_at', $date);

        $total = (clone $query)->count();
        $data  = $query->latest('recorded_at')->latest('id')->limit($limit)->get();

        return response()->json([
            'success'       => true,
            'total_records' => $total,
            'data'          => $data,
        ]);
    }

    // ══════════════════════════════════════
    // POST /api/electrique
    // ══════════════════════════════════════
    public function storeElectrique(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'i1'        => ['required', 'numeric', 'min:-30', 'max:30'],
            'i2'        => ['required', 'numeric', 'min:-30', 'max:30'],
            'i3'        => ['required', 'numeric', 'min:-30', 'max:30'],
            'v1'        => ['required', 'numeric', 'min:0',   'max:100'],
            'v2'        => ['required', 'numeric', 'min:0',   'max:100'],
            'p'         => ['required', 'numeric', 'min:0',   'max:20'],
            'device_id' => ['nullable', 'string',  'max:64'],
            'rssi'      => ['nullable', 'integer'],
            'timestamp' => ['nullable', 'date'],        // ← زيد
        ]);

        $row = MesuresElectrique::create([
            'courant1'    => (float) $validated['i1'],
            'courant2'    => (float) $validated['i2'],
            'courant3'    => (float) $validated['i3'],
            'tension1'    => (float) $validated['v1'],
            'tension2'    => (float) $validated['v2'],
            'pression'    => (float) $validated['p'],
            'device_id'   => $validated['device_id']  ?? 'esp32-electrique',
            'rssi'        => $validated['rssi']        ?? null,
            'recorded_at' => $validated['timestamp']   ?? now(), // ← بدل
        ]);

        return response()->json(['success' => true, 'data' => $row], 201);
    }

    // ══════════════════════════════════════
    // GET /api/electrique?date=2024-01-01
    // ══════════════════════════════════════
    public function indexElectrique(Request $request): JsonResponse
    {
        $limit = max(1, min((int) $request->integer('limit', 5000), 20000));
        $date  = $request->query('date');

        $query = MesuresElectrique::query();
        if ($date) $query->whereDate('recorded_at', $date);

        $total = (clone $query)->count();
        $data  = $query->latest('recorded_at')->latest('id')->limit($limit)->get();

        return response()->json([
            'success'       => true,
            'total_records' => $total,
            'data'          => $data,
        ]);
    }
}
