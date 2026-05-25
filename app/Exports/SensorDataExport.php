<?php
namespace App\Exports;

use App\Models\SensorData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SensorDataExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected string $type;
    protected string $date;

    public function __construct(string $type, string $date)
    {
        $this->type = $type;
        $this->date = $date;
    }

    public function collection()
    {
        $query = SensorData::query();

        if ($this->type === 'day') {
            $query->whereDate('recorded_at', $this->date);
        } elseif ($this->type === 'month') {
            $year  = substr($this->date, 0, 4);
            $month = substr($this->date, 5, 2);
            $query->whereYear('recorded_at', $year)
                  ->whereMonth('recorded_at', $month);
        }

        return $query->orderBy('recorded_at', 'asc')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Device', 'Pression (Bar)', 'Tension (V)', 'Date & Heure'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->device_id,
            number_format($row->pressure, 3),
            number_format($row->voltage, 3),
            $row->recorded_at ?? $row->created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '08602b']],
            ],
        ];
    }
}
