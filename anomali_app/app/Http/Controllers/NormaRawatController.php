<?php

namespace App\Http\Controllers;

use App\Models\NormaRawat;
use Illuminate\Http\Request;

class NormaRawatController extends Controller
{
    public function index()
    {
        $data = NormaRawat::all();
        $masterItems = \App\Models\NormaKerja::select('item_kerja')->distinct()->orderBy('item_kerja')->pluck('item_kerja');
        $masterNormaData = \App\Models\NormaKerja::all();
        return view('admin.norma_rawat', compact('data', 'masterItems', 'masterNormaData'));
    }

    public function store(Request $request)
    {
        $rawat = NormaRawat::create($request->all());
        $this->checkAnomaly($rawat);
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $item = NormaRawat::findOrFail($id);
        $item->update($request->all());
        $this->checkAnomaly($item);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $item = NormaRawat::findOrFail($id);
        $item->delete();
        return response()->json(['success' => true]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $replace = filter_var($request->input('replace', false), FILTER_VALIDATE_BOOLEAN);

        if ($replace) {
            NormaRawat::truncate();
        }

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\NormaRawatImport, $request->file('file'));

        // Send generic notification for import
        $msg = "📥 <b>IMPORT DATA SELESAI</b>\n\n";
        $msg .= "Sistem mendeteksi adanya data baru/update dari file Excel.\n";
        $msg .= "Silakan cek Dashboard aplikasi untuk melihat deteksi anomali terbaru.";
        \App\Services\TelegramService::sendMessage($msg);

        return redirect()->back()->with('success', 'Data Excel berhasil diimport!');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\NormaRawatExport, 'Data_Norma_Rawat.xlsx');
    }

    private function checkAnomaly(NormaRawat $rawat)
    {
        $mandays_shi = (float)($rawat->mandays_shi ?? 0);
        $produksi_shi = (float)($rawat->produksi_shi ?? 0);
        if ($produksi_shi == 0) return;

        $realisasi = $mandays_shi / $produksi_shi;
        $master = \App\Models\NormaKerja::where('item_kerja', $rawat->jobdesc)->first();
        if (!$master || empty($master->datar_norma)) return;

        $standar = (float)$master->datar_norma;
        if ($standar == 0) return;

        $fluktuasi = (($realisasi - $standar) / $standar) * 100;
        
        // Tetap menggunakan logika persentase > 105 untuk pemicu, atau fluktuasi > 100 sesuai UI
        // Kita gunakan $fluktuasi > 100 agar sama persis dengan 'Over Norma' di UI
        if ($fluktuasi > 100) {
            $mandays_fmt = number_format($mandays_shi, 4, '.', '');
            $produksi_fmt = number_format($produksi_shi, 4, '.', '');
            $realisasi_fmt = number_format($realisasi, 4, '.', '');
            $standar_fmt = number_format($standar, 4, '.', '');
            $fluktuasi_fmt = number_format($fluktuasi, 2, '.', '');

            $msg = "🚨 <b>ANOMALI TERDETEKSI (OVER NORMA)</b>\n\n";
            $msg .= "<b>JOBDESC</b>\n" . ($rawat->jobdesc ?? '-') . "\n\n";
            $msg .= "<b>MANDAYS_SHI</b>\n{$mandays_fmt}\n\n";
            $msg .= "<b>PRODUKSI_SHI</b>\n{$produksi_fmt}\n\n";
            $msg .= "<b>Rumus Perhitungan:</b>\n";
            $msg .= "Realisasi: MANDAYS_SHI / PRODUKSI_SHI\n";
            $msg .= "= {$mandays_fmt} / {$produksi_fmt}\n";
            $msg .= "= {$realisasi_fmt}\n\n";
            $msg .= "Norma Standar (Master Datar):\n";
            $msg .= "= {$standar_fmt}\n\n";
            $msg .= "Fluktuasi: ((Realisasi - Standar) / Standar) * 100%\n";
            $msg .= "= (({$realisasi_fmt} - {$standar_fmt}) / {$standar_fmt}) * 100%\n";
            $msg .= "= {$fluktuasi_fmt}%\n\n";
            $msg .= "⚠️ <i>Mohon segera lakukan klarifikasi di sistem.</i>";

            \App\Services\TelegramService::sendMessage($msg);
        }
    }
}
