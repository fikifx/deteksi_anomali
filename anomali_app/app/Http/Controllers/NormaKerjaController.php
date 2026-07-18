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
        $replace = $request->input('replace', false);
        $data = $request->input('data', []);

        if (empty($data)) {
            return response()->json(['success' => false, 'message' => 'No data provided'], 400);
        }

        if ($replace) {
            NormaKerja::truncate();
        }

        foreach ($data as $row) {
            NormaKerja::create([
                'status_umur_tanaman' => $row['status_umur_tanaman'] ?? '',
                'item_kerja' => $row['item_kerja'] ?? '',
                'datar_norma' => $row['datar_norma'] ?? null,
                'datar_rotasi' => $row['datar_rotasi'] ?? null,
                'datar_nxr' => $row['datar_nxr'] ?? null,
                'roling1_norma' => $row['roling1_norma'] ?? null,
                'roling1_rotasi' => $row['roling1_rotasi'] ?? null,
                'roling1_nxr' => $row['roling1_nxr'] ?? null,
                'roling2_norma' => $row['roling2_norma'] ?? null,
                'roling2_rotasi' => $row['roling2_rotasi'] ?? null,
                'roling2_nxr' => $row['roling2_nxr'] ?? null,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function overview()
    {
        return view('dashboard');
    }
}
