<?php

namespace App\Exports;

use App\Models\NormaRawat;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NormaRawatExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('exports.norma_rawat', [
            'data' => NormaRawat::all()
        ]);
    }
}
