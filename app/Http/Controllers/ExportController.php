<?php

namespace App\Http\Controllers;

use App\Exports\SensorDataExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function export(Request $request): BinaryFileResponse
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['day', 'month'])],
            'date' => ['required', 'string'],
        ]);

        if ($validated['type'] === 'day') {
            $request->validate(['date' => ['date_format:Y-m-d']]);
        } else {
            $request->validate(['date' => ['regex:/^\d{4}-(0[1-9]|1[0-2])$/']]);
        }

        $filename = sprintf('sensor-data-%s-%s.xlsx', $validated['type'], $validated['date']);

        return Excel::download(
            new SensorDataExport($validated['type'], $validated['date']),
            $filename
        );
    }
}
