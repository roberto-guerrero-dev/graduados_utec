<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GraduadosExport implements FromArray, WithHeadings, WithStyles
{
    protected $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function array(): array {
        return array_map(function ($row) {
            return [
                $row->nombre,
                $row->genero,
                $row->carrera,
                $row->facultad,
                $row->modalidad,
                $row->fecha_graduacion,
                $row->ciclo_graduacion,
            ];
        }, json_decode(json_encode($this->data), true)); // <- convierte stdClass a array asociativo
    }

    public function headings(): array {
        return [
            'Nombre',
            'Género',
            'Carrera',
            'Facultad',
            'Modalidad',
            'Fecha Graduación',
            'Ciclo'
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '5E0022']],
            'alignment' => ['horizontal' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => 'thin']]
        ]);
    }
}
