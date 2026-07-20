<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterBudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['bulan' => '2026-01-01', 'jumlah_hk' => 875.14, 'budget_bulan_rp' => 137117253.63],
            ['bulan' => '2026-02-01', 'jumlah_hk' => 661.39, 'budget_bulan_rp' => 103625862.83],
            ['bulan' => '2026-03-01', 'jumlah_hk' => 663.35, 'budget_bulan_rp' => 103933006.91],
            ['bulan' => '2026-04-01', 'jumlah_hk' => 819.28, 'budget_bulan_rp' => 128364269.49],
            ['bulan' => '2026-05-01', 'jumlah_hk' => 636.98, 'budget_bulan_rp' => 99802317.59],
            ['bulan' => '2026-06-01', 'jumlah_hk' => 665.24, 'budget_bulan_rp' => 104229396.17],
            ['bulan' => '2026-07-01', 'jumlah_hk' => 352.07, 'budget_bulan_rp' => 55162238.58],
            ['bulan' => '2026-08-01', 'jumlah_hk' => 549.34, 'budget_bulan_rp' => 86070100.82],
            ['bulan' => '2026-09-01', 'jumlah_hk' => 417.40, 'budget_bulan_rp' => 65397715.70],
            ['bulan' => '2026-10-01', 'jumlah_hk' => 375.63, 'budget_bulan_rp' => 58853835.04],
            ['bulan' => '2026-11-01', 'jumlah_hk' => 621.91, 'budget_bulan_rp' => 97440557.28],
            ['bulan' => '2026-12-01', 'jumlah_hk' => 343.05, 'budget_bulan_rp' => 53749843.75],
        ];

        foreach ($data as $item) {
            \App\Models\MasterBudget::create($item);
        }
    }
}
