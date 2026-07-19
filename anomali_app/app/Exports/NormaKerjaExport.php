<?php

namespace App\Exports;

use App\Models\NormaKerja;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NormaKerjaExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('exports.norma_kerja', [
            'data' => NormaKerja::all()
        ]);
    }
}
