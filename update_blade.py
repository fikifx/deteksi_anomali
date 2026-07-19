import re

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\master.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace the export button
content = re.sub(r'<button[^>]*onclick="exportExcel\(\)"[^>]*>.*?</button>', 
                 '''<a href="{{ route('master.export') }}" class="btn btn-excel" style="text-decoration:none">📥 Export Excel</a>''', 
                 content)

# Replace the import form
import_modal_new = '''
<div class="modal" id="importModal">
  <div class="modal-content">
    <h3>📥 Import Data Excel</h3>
    <p>Pilih file master data (.xlsx, .xls, .csv). Pastikan format tabel sesuai dengan template.</p>
    <form action="{{ route('master.import') }}" method="POST" enctype="multipart/form-data" style="margin-top:20px;">
      @csrf
      <input type="file" id="excelFile" name="file" accept=".xlsx, .xls, .csv" style="display:block;margin-bottom:15px;" required>
      <label style="display:flex;align-items:center;gap:8px;font-size:13px;margin-bottom:20px;">
        <input type="checkbox" id="replaceData" name="replace" value="true"> Timpa semua data yang ada (Truncate)
      </label>
      <div class="modal-actions">
        <button type="button" class="btn-ghost" onclick="closeImport()">Batal</button>
        <button type="submit" class="btn">Mulai Import</button>
      </div>
    </form>
  </div>
</div>
'''

content = re.sub(r'<div class="modal" id="importModal">.*?</div>\s*</div>', import_modal_new, content, flags=re.DOTALL)

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\master.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated master.blade.php')
