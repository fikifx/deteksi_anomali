<?php

namespace App\Imports;

use App\Models\NormaRawat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class NormaRawatImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        if (empty($row[0])) {
            return null;
        }

        $cleanVal = function($val) {
            if ($val === '-' || $val === '' || $val === null) return null;
            return (float) str_replace(',', '.', $val);
        };
        
        $parseDate = function($val) {
            if (!$val) return null;
            // If it's Excel serial date (numeric)
            if (is_numeric($val)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val)->format('Y-m-d');
            }
            // If it's already a string like "2026-07-17"
            return date('Y-m-d', strtotime($val));
        };

        return new NormaRawat([
            'sitecode' => $row[0],
            'tdate' => $parseDate($row[1] ?? null),
            'afdcode' => $row[2],
            'location' => $row[3],
            'plantingdate' => $row[4],
            'jobtype' => $row[5],
            'jobtypedesc' => $row[6],
            'type' => $row[7],
            'jobgroupcode' => $row[8],
            'jobcode' => $row[9],
            'jobdesc' => $row[10],
            'uom' => $row[11],
            'ump' => $cleanVal($row[12] ?? null),
            'hectplanted' => $cleanVal($row[13] ?? null),
            'mandays_hi' => $cleanVal($row[14] ?? null),
            'mandays_shi' => $cleanVal($row[15] ?? null),
            'hk_per_ha_hi' => $cleanVal($row[16] ?? null),
            'hk_per_ha_shi' => $cleanVal($row[17] ?? null),
            'produksi_hi' => $cleanVal($row[18] ?? null),
            'produksi_shi' => $cleanVal($row[19] ?? null),
            'cost_hi' => $cleanVal($row[20] ?? null),
            'cost_shi' => $cleanVal($row[21] ?? null),
            'premi_hi' => $cleanVal($row[22] ?? null),
            'premi_shi' => $cleanVal($row[23] ?? null),
            'addcost_hi' => $cleanVal($row[24] ?? null),
            'addcost_shi' => $cleanVal($row[25] ?? null),
        ]);
    }
}
