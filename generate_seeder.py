import pandas as pd
import json

df = pd.read_excel('D:\\deteksi_anomali\\data master.xlsx', skiprows=2)

data = []
for index, row in df.iterrows():
    if pd.isna(row.iloc[0]) or pd.isna(row.iloc[1]):
        continue
    
    def clean_val(v):
        if pd.isna(v) or v == '-':
            return 'null'
        return str(v)

    data.append(f"""
            [
                'status_umur_tanaman' => '{row.iloc[0]}',
                'item_kerja' => '{row.iloc[1]}',
                'datar_norma' => {clean_val(row.iloc[2])},
                'datar_rotasi' => {clean_val(row.iloc[3])},
                'datar_nxr' => {clean_val(row.iloc[4])},
                'roling1_norma' => {clean_val(row.iloc[5])},
                'roling1_rotasi' => {clean_val(row.iloc[6])},
                'roling1_nxr' => {clean_val(row.iloc[7])},
                'roling2_norma' => {clean_val(row.iloc[8])},
                'roling2_rotasi' => {clean_val(row.iloc[9])},
                'roling2_nxr' => {clean_val(row.iloc[10])},
            ]""")

seeder_content = f"""<?php

namespace Database\\Seeders;

use Illuminate\\Database\\Seeder;
use App\\Models\\NormaKerja;

class NormaKerjaSeeder extends Seeder
{{
    public function run()
    {{
        $data = [{','.join(data)}
        ];

        foreach ($data as $item) {{
            NormaKerja::create($item);
        }}
    }}
}}
"""

with open(r'D:\deteksi_anomali\anomali_app\database\seeders\NormaKerjaSeeder.php', 'w', encoding='utf-8') as f:
    f.write(seeder_content.replace('$data', '$data').replace('$item', '$item'))

print('Seeder generated successfully.')
