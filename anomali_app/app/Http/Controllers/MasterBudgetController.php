<?php

namespace App\Http\Controllers;

use App\Models\MasterBudget;
use Illuminate\Http\Request;

class MasterBudgetController extends Controller
{
    public function index()
    {
        $data = MasterBudget::orderBy('bulan', 'asc')->get();
        return view('admin.master_budget', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required|date',
            'jumlah_hk' => 'required|numeric',
            'budget_bulan_rp' => 'required|numeric',
        ]);

        MasterBudget::create($request->all());

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bulan' => 'required|date',
            'jumlah_hk' => 'required|numeric',
            'budget_bulan_rp' => 'required|numeric',
        ]);

        $item = MasterBudget::findOrFail($id);
        $item->update($request->all());

        return response()->json(['message' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        $item = MasterBudget::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
