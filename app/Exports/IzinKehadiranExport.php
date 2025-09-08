<?php

namespace App\Exports;

use App\Models\IzinKehadiran;
use App\Models\Kelompok;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IzinKehadiranExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kelompokId;

    public function __construct($kelompokId = null)
    {
        $this->kelompokId = $kelompokId;
    }

    public function collection()
    {
        $query = IzinKehadiran::query();

        if ($this->kelompokId) {
            $query->where('kelompok_id', $this->kelompokId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Tanggal',
            'Kelompok',
            'Keterangan',
        ];
    }

    public function map($row): array
    {
        return [
            $row->nim,
            $row->tanggal,
            optional($row->kelompok)->nama_kelompok ?? $row->kelompok_id,
            $row->keterangan,
          
        ];
    }
}
