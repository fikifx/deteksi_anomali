import re

with open('resources/views/admin/master_budget.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace Page Header
content = re.sub(r'<h1>📋 Data Master Norma.*?</p>', '<h1>💰 Master Budget</h1>\n      <p>Manajemen data budget bulanan</p>', content, flags=re.DOTALL)
content = content.replace('Data Master Norma', 'Master Budget')
content = content.replace('Home &rsaquo; <span>Master Norma</span>', 'Home &rsaquo; <span>Master Budget</span>')
content = content.replace('master.export', 'budget.export')

# Replace Table Headers
headers = '''
              <th style="min-width:50px">No</th>
              <th style="min-width:150px" class="left">BULAN</th>
              <th style="min-width:150px">JUMLAH HK</th>
              <th style="min-width:150px">BUDGET BULAN (Rp)</th>
              <th style="min-width:120px">AKSI</th>
'''
content = re.sub(r'<thead>.*?</thead>', f'<thead><tr>{headers}</tr></thead>', content, flags=re.DOTALL)

# Replace Javascript table rendering
js_render = '''
        tbody.innerHTML = page.map((r, i) => {
    
    const dateObj = new Date(r.bulan);
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const monthName = months[dateObj.getMonth()];

    return `<tr>
      <td>${start + i + 1}</td>
      <td class="left" style="font-weight:600">${monthName ? monthName.toUpperCase() : (r.bulan || '-')}</td>
      <td class="num-cell">${r.jumlah_hk !== null ? numFmt(r.jumlah_hk) : '–'}</td>
      <td class="num-cell accent">${r.budget_bulan_rp !== null ? numFmt(r.budget_bulan_rp) : '–'}</td>
      <td><div style="display:flex;gap:6px;justify-content:center">
        <button class="btn btn-edit-sm" onclick="openEdit(${r.id})" title="Edit">✏️</button>
        <button class="btn btn-danger-sm" onclick="openDelete(${r.id})" title="Hapus">🗑️</button>
      </div></td>
    </tr>`;
  }).join('');
'''
content = re.sub(r'tbody\.innerHTML = page\.map\(\(r, i\).*?\}\)\.join\(\'\'\);', js_render, content, flags=re.DOTALL)

# Modify Form inputs
form_html = '''
      <div class="form-grid">
        <div class="form-group full"><label>Bulan</label><input type="month" id="f_bulan" required></div>
        <div class="form-group"><label>Jumlah HK</label><input type="number" step="0.01" id="f_jumlah_hk"></div>
        <div class="form-group"><label>Budget Bulan (Rp)</label><input type="number" step="0.01" id="f_budget_bulan_rp"></div>
      </div>
'''
content = re.sub(r'<div class="form-grid">.*?</div>\s*</div>\s*<div class="modal-footer">', f'{form_html}</div><div class="modal-footer">', content, flags=re.DOTALL)

# Javascript CRUD functions
content = content.replace("'f_status_umur','f_item_kerja','f_datar_norma','f_datar_rotasi','f_datar_nxr','f_roling1_norma','f_roling1_rotasi','f_roling1_nxr','f_roling2_norma','f_roling2_rotasi','f_roling2_nxr'", "'f_bulan','f_jumlah_hk','f_budget_bulan_rp'")

js_edit = '''
  document.getElementById('f_bulan').value = row.bulan ? row.bulan.substring(0,7) : '';
  document.getElementById('f_jumlah_hk').value = row.jumlah_hk ?? '';
  document.getElementById('f_budget_bulan_rp').value = row.budget_bulan_rp ?? '';
'''
content = re.sub(r"document\.getElementById\('f_status_umur'\)\.value = row\.status_umur\|\|'';.*?document\.getElementById\('f_roling2_nxr'\)\.value = row\.roling2_nxr\?\?'';", js_edit, content, flags=re.DOTALL)

js_submit = '''
  const obj = {
    bulan: document.getElementById('f_bulan').value ? document.getElementById('f_bulan').value + '-01' : null,
    jumlah_hk: parseFloat(document.getElementById('f_jumlah_hk').value) || 0,
    budget_bulan_rp: parseFloat(document.getElementById('f_budget_bulan_rp').value) || 0,
  };
'''
content = re.sub(r"const obj = \{.*?roling2_nxr: parseFloat\(document\.getElementById\('f_roling2_nxr'\)\.value\) \|\| null\s*\};", js_submit, content, flags=re.DOTALL)

content = content.replace("'/master-norma/'", "'/master-budget/'")
content = content.replace("'/master-norma'", "'/master-budget'")
content = content.replace("document.getElementById('deleteItemName').textContent=`${row.status_umur} - ${row.item_kerja}`;", "document.getElementById('deleteItemName').textContent=`Bulan ${row.bulan}`;")

with open('resources/views/admin/master_budget.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
