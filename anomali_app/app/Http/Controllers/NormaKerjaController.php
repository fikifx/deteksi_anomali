<?php

namespace App\Http\Controllers;

use App\Models\NormaKerja;
use Illuminate\Http\Request;

class NormaKerjaController extends Controller
{
    public function index()
    {
        $data = NormaKerja::all();
        return view('admin.master', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'status_umur_tanaman' => 'required|string',
            'item_kerja' => 'required|string',
            'datar_norma' => 'nullable|numeric',
            'datar_rotasi' => 'nullable|numeric',
            'datar_nxr' => 'nullable|numeric',
            'roling1_norma' => 'nullable|numeric',
            'roling1_rotasi' => 'nullable|numeric',
            'roling1_nxr' => 'nullable|numeric',
            'roling2_norma' => 'nullable|numeric',
            'roling2_rotasi' => 'nullable|numeric',
            'roling2_nxr' => 'nullable|numeric',
        ]);

        NormaKerja::create($data);
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $norma = NormaKerja::findOrFail($id);
        
        $data = $request->validate([
            'status_umur_tanaman' => 'required|string',
            'item_kerja' => 'required|string',
            'datar_norma' => 'nullable|numeric',
            'datar_rotasi' => 'nullable|numeric',
            'datar_nxr' => 'nullable|numeric',
            'roling1_norma' => 'nullable|numeric',
            'roling1_rotasi' => 'nullable|numeric',
            'roling1_nxr' => 'nullable|numeric',
            'roling2_norma' => 'nullable|numeric',
            'roling2_rotasi' => 'nullable|numeric',
            'roling2_nxr' => 'nullable|numeric',
        ]);

        $norma->update($data);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        NormaKerja::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $replace = filter_var($request->input('replace', false), FILTER_VALIDATE_BOOLEAN);

        if ($replace) {
            NormaKerja::truncate();
        }

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\NormaKerjaImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data Excel berhasil diimport!');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\NormaKerjaExport, 'Master_Data_Norma_Kerja.xlsx');
    }

    public function overview()
    {
        // Data for Live Alert Feed
        $rawatData = \App\Models\NormaRawat::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())
            ->orderBy('created_at', 'desc')
            ->get();
            
        $masterNorma = \App\Models\NormaKerja::all();
        
        // Find June budget (or current month)
        $juneBudget = \App\Models\MasterBudget::whereMonth('bulan', 6)->sum('budget_bulan_rp');
        
        // Calculate realization from Live Alert Feed (for this month/June)
        // HK Price is 158680
        $hkPrice = 158680;
        $totalRealisasi = 0;
        foreach ($rawatData as $rawat) {
            $mandays = (float) ($rawat->mandays_shi ?? 0);
            $totalRealisasi += $mandays * $hkPrice;
        }
        
        $sisaBudget = $juneBudget - $totalRealisasi;
        $masterBudget = \App\Models\MasterBudget::orderBy('bulan', 'asc')->get();

        return view('dashboard', compact('rawatData', 'masterNorma', 'juneBudget', 'totalRealisasi', 'sisaBudget', 'masterBudget'));
    }
}
