import re

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Add calcStatus helper
helper_js = '''
function calcStatus(r) {
  let realisasi = 0;
  if(r.produksi_shi && r.produksi_shi > 0) {
    realisasi = r.mandays_shi / r.produksi_shi;
  }
  const master = masterNormaData.find(m => m.item_kerja === r.jobdesc);
  const standar = master && master.datar_norma ? parseFloat(master.datar_norma) : 0;
  
  let fluktuasi = 0;
  if (standar > 0) {
    fluktuasi = ((realisasi - standar) / standar) * 100;
  }
  
  let statusText = 'Normal';
  let badgeCls = 'badge-success';
  if (fluktuasi > 100) {
    statusText = 'Over Norma';
    badgeCls = 'badge-danger';
  } else if (fluktuasi < 0) {
    statusText = 'Di Bawah Norma';
    badgeCls = 'badge-info';
  }
  if (!standar) {
    statusText = 'N/A';
    badgeCls = 'badge-tmtua';
  }
  return { statusText, badgeCls, fluktuasi, realisasi, standar };
}

// ========== FILTER =========='''

content = content.replace('// ========== FILTER ==========', helper_js)


# Update applyFilter
new_filter = '''function applyFilter() {
  const q = document.getElementById('searchInput').value.toLowerCase().trim();
  const s = document.getElementById('filterStatus').value;
  filteredData = masterData.filter(r => {
    const st = calcStatus(r);
    const matchQ = !q || (r.jobdesc||'').toLowerCase().includes(q) || (r.sitecode||'').toLowerCase().includes(q) || (r.location||'').toLowerCase().includes(q);
    const matchS = !s || st.statusText === s;
    return matchQ && matchS;
  });
  currentPage = 1;
  renderTable();
  updateStats();
}'''

content = re.sub(r'function applyFilter\(\) \{.*?\n\}', new_filter, content, flags=re.DOTALL)


# Update updateFilterDropdown
new_dropdown = '''function updateFilterDropdown() {
  const sel = document.getElementById('filterStatus');
  const cur = sel.value;
  const statuses = ['Over Norma', 'Normal', 'Di Bawah Norma', 'N/A'];
  sel.innerHTML = '<option value="">Semua Status</option>' +
    statuses.map(s => `<option value="${s}" ${s===cur?'selected':''}>${s}</option>`).join('');
}'''

content = re.sub(r'function updateFilterDropdown\(\) \{.*?\n\}', new_dropdown, content, flags=re.DOTALL)


# Update renderTable to use calcStatus
new_render = '''  tbody.innerHTML = page.map((r, i) => {
    
    const st = calcStatus(r);
    const statusCol = `<span class="badge-status ${st.badgeCls}">${st.statusText}</span><br><small style="color:var(--text-3);font-size:10px">${st.fluktuasi.toFixed(1)}%</small>`;

    return `<tr>'''

content = re.sub(r'  tbody\.innerHTML = page\.map\(\(r, i\) => \{.*?(const statusCol = [^\n]+)', new_render, content, flags=re.DOTALL)

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Filter fixed')
