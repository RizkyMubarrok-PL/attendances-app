<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Attendances;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class RecapAttendances implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    protected $className;
    protected $filter;
    protected $filterValue;

    function __construct($className = '', $filter = '', $filterValue = '')
    {
        $this->className = $className;
        $this->filter = $filter;
        $this->filterValue = $filterValue;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function headings(): array
    {
        return $this->filter == 'tanggal' ?
            [
                'No',
                'Nama Siswa',
                'Status Kehadiran',
                'Keterangan',
                'Guru'
            ] :
            [
                'No',
                'Nama Siswa',
                'Total Kehadiran',
                'Total Izin',
                'Total Alpha'
            ];
    }

    public function collection()
    {
        $selectData = $this->filter == 'tanggal' ?
            [
                DB::raw("ROW_NUMBER() OVER(ORDER BY student.name) AS row_num"),
                'student.name as student_name',
                'attendances.status',
                DB::raw("COALESCE(attendances.description, '-') as Attendances_Description"),
                DB::raw("COALESCE(teacher.name, '-') as teacher_name")
            ] :
            [
                DB::raw("ROW_NUMBER() OVER(ORDER BY student.name) AS row_num"),
                'student.name as Student_Name',
                DB::raw("SUM(CASE WHEN attendances.status = 'Hadir' THEN 1 ELSE 0 END) as Total_Hadir"),
                DB::raw("SUM(CASE WHEN attendances.status = 'Izin' THEN 1 ELSE 0 END) as Total_Izin"),
                DB::raw("SUM(CASE WHEN attendances.status = 'Alpha' THEN 1 ELSE 0 END) as Total_Alpha")
            ];

        $query = Attendances::select($selectData)
            ->join('class_students', 'attendances.student_id', '=', 'class_students.student_id')
            ->join('classes', 'classes.id', '=', 'class_students.class_id')
            ->join('users as student', 'student.id', '=', 'attendances.student_id')
            ->leftJoin('users as teacher', 'teacher.id', '=', 'attendances.teacher_id');

        if (!empty($this->className)) {
            $query->where('classes.class_name', $this->className);
        }

        if ($this->filter == 'tanggal' && !empty($this->filterValue)) {
            $query->whereDate('attendances.created_at', $this->filterValue);
        }

        if ($this->filter == 'bulan' && !empty($this->filterValue)) {
            $query->whereRaw("DATE_FORMAT(attendances.created_at, '%Y-%m') = ?", [$this->filterValue])
            ->groupBy('student.id', 'student.name');
        }

        return $query->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();

                if (!empty($this->filterValue)) {
                    $indonesianDate = Carbon::parse($this->filterValue)->locale('id')->translatedFormat('l, d F Y');
                } else {
                    $indonesianDate = Carbon::now()->locale('id')->translatedFormat('l, d F Y');
                }

                $sheet->mergeCells('B1:D1');
                $sheet->setCellValue('A1', "Kelas: ");
                $sheet->setCellValue('B1', $this->className);
                $sheet->getStyle('A1:B1')->getFont()->setBold(true);

                $sheet->mergeCells('B2:D2');
                $sheet->setCellValue('A2', "Tanggal: ");
                $sheet->setCellValue('B2', $indonesianDate);
                $sheet->getStyle('A2:B2')->getFont()->setBold(true);

                $cellRange = 'A4:E' . $highestRow;
                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                        ],
                        'inside' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                for ($row = 4; $row <= $highestRow; $row++) {
                    $statusCell = 'C' . $row;
                    $status = $sheet->getCell($statusCell)->getValue();

                    $bgColor = match ($status) {
                        'Hadir' => 'C6EFCE',
                        'Izin' => 'FFEB9C',
                        'Alpha' => 'FFC7CE',
                        default => 'FFFFFF',
                    };

                    $sheet->getStyle("A$row:E$row")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => $bgColor],
                        ],
                    ]);
                }
            },
        ];
    }
}
