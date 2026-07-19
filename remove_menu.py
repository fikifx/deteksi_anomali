import os

files = [
    'd:/deteksi_anomali/anomali_app/resources/views/admin/master.blade.php',
    'd:/deteksi_anomali/anomali_app/resources/views/admin/norma_rawat.blade.php',
    'd:/deteksi_anomali/anomali_app/resources/views/admin/settings.blade.php'
]

search_text = """    <div class="nav-section-label" style="margin-top:12px">Laporan</div>
    <a href="#" class="nav-item"><span class="icon">📈</span> Analisis Anggaran</a>
    <a href="#" class="nav-item"><span class="icon">🔍</span> Deteksi Anomali</a>
    <a href="#" class="nav-item"><span class="icon">🗓️</span> Rencana Kerja</a>"""

for file_path in files:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if search_text in content:
        content = content.replace(search_text, '')
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Removed from {os.path.basename(file_path)}")
    else:
        print(f"Not found in {os.path.basename(file_path)}")

print("Done")
