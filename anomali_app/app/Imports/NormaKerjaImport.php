<?php

namespace App\Imports;

use App\Models\NormaKerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class NormaKerjaImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        // Headers take up rows 1-3, data starts at row 4 (or 5? wait. Excel row 1 is empty, row 2, 3, 4 are headers, data starts at row 5).
        // Let's use 5. If 4 has data, it'll be caught. Actually, in Excel, data starts at row 5.
        return 5;
    }

    public function model(array $row)
    {
        // Check if row is completely empty or missing required fields
        if (!isset($row[0]) || !isset($row[1])) {
            return null;
        }

        $cleanVal = function($val) {
            if ($val === '-' || $val === '' || $val === null) {
                return null;
            }
            // replace commas with dots if user typed 1,8 instead of 1.8
            return (float) str_replace(',', '.', $val);
        };

        return new NormaKerja([
            'status_umur_tanaman' => $row[0],
            'item_kerja' => $row[1],
            'datar_norma' => $cleanVal($row[2] ?? null),
            'datar_rotasi' => $cleanVal($row[3] ?? null),
            'datar_nxr' => $cleanVal($row[4] ?? null),
            'roling1_norma' => $cleanVal($row[5] ?? null),
            'roling1_rotasi' => $cleanVal($row[6] ?? null),
            'roling1_nxr' => $cleanVal($row[7] ?? null),
            'roling2_norma' => $cleanVal($row[8] ?? null),
            'roling2_rotasi' => $cleanVal($row[9] ?? null),
            'roling2_nxr' => $cleanVal($row[10] ?? null),
        ]);
    }
}
