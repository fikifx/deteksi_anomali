import re

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Inject masterNormaData
content = content.replace(
    'let masterData = {!! $data->toJson() !!};',
    'let masterData = {!! $data->toJson() !!};\nlet masterNormaData = {!! $masterNormaData->toJson() !!};'
)

# 2. Add STATUS column header
content = content.replace(
    '<th style="min-width:110px">Aksi</th>',
    '<th style="min-width:150px">STATUS</th>\n              <th style="min-width:110px">Aksi</th>'
)

# 3. Add modal HTML for detail before toast-container
detail_modal = '''
<!-- MODAL: DETAIL -->
<div class="modal-overlay" id="detailModal">
  <div class="modal" style="max-width:550px">
    <div class="modal-header">
      <h3 id="detailTitle">👁️ Detail Fluktuasi Norma</h3>
      <button class="modal-close" onclick="closeDetailModal()">✕</button>
    </div>
    <div class="modal-body" style="padding-top:10px;">
      <div id="detailContent"></div>
    </div>
  </div>
</div>
'''
content = content.replace('<div class="toast-container"', detail_modal + '\n<div class="toast-container"')

# 4. JS for openDetail
js_funcs = '''
function closeDetailModal() {
  document.getElementById('detailModal').classList.remove('open');
}

function openDetail(id) {
  const r = masterData.find(x => x.id === id);
  if(!r) return;
  
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
  
  const content = `
    <div style="background:var(--bg-deep); padding:16px; border-radius:12px; border:1px solid var(--border); margin-bottom:16px;">
      <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
        <span style="color:var(--text-3); font-size:12px;">JOBDESC</span>
        <strong style="color:var(--text-1)">${r.jobdesc || '-'}</strong>
      </div>
      <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
        <span style="color:var(--text-3); font-size:12px;">MANDAYS_SHI</span>
        <strong style="color:var(--text-1)">${r.mandays_shi || 0}</strong>
      </div>
      <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
        <span style="color:var(--text-3); font-size:12px;">PRODUKSI_SHI</span>
        <strong style="color:var(--text-1)">${r.produksi_shi || 0}</strong>
      </div>
    </div>
    
    <div style="background:var(--bg-deep); padding:16px; border-radius:12px; border:1px solid var(--border); margin-bottom:16px;">
      <h4 style="font-size:13px; margin-bottom:10px; color:var(--text-2);">Rumus Perhitungan:</h4>
      <p style="font-size:13px; color:var(--text-1); margin-bottom:8px;">
        <strong>Realisasi:</strong> MANDAYS_SHI / PRODUKSI_SHI<br>
        = ${r.mandays_shi || 0} / ${r.produksi_shi || 0} <br>
        = <span style="color:var(--accent-l)">${realisasi.toFixed(4)}</span>
      </p>
      <p style="font-size:13px; color:var(--text-1); margin-bottom:8px;">
        <strong>Norma Standar (Master Datar):</strong><br>
        = <span style="color:var(--info)">${standar.toFixed(4)}</span>
      </p>
      <hr style="border-color:var(--border); margin:12px 0;">
      <p style="font-size:13px; color:var(--text-1); line-height:1.6">
        <strong>Fluktuasi:</strong> ((Realisasi - Standar) / Standar) * 100% <br>
        = ((${realisasi.toFixed(4)} - ${standar.toFixed(4)}) / ${standar.toFixed(4)}) * 100% <br>
        = <strong>${fluktuasi.toFixed(2)}%</strong>
      </p>
    </div>
    
    <div style="text-align:center; padding:12px;">
      <div style="font-size:12px; color:var(--text-3); margin-bottom:6px;">KESIMPULAN STATUS</div>
      <span class="badge-status ${badgeCls}" style="font-size:16px; padding:6px 16px;">${statusText}</span>
    </div>
  `;
  document.getElementById('detailContent').innerHTML = content;
  document.getElementById('detailModal').classList.add('open');
}
'''
content = content.replace('// ========== CRUD: ADD/EDIT ==========', js_funcs + '\n// ========== CRUD: ADD/EDIT ==========')

# 5. Update renderTable loop
new_render = '''  tbody.innerHTML = page.map((r, i) => {
    
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
    let badgeCls = 'badge-success'; // assuming normal is green
    if (fluktuasi > 100) {
      statusText = 'Over Norma';
      badgeCls = 'badge-danger'; // red
    } else if (fluktuasi < 0) {
      statusText = 'Di Bawah Norma';
      badgeCls = 'badge-info'; // blue
    }
    if (!standar) {
      statusText = 'N/A';
      badgeCls = 'badge-tmtua'; // gray-ish
    }
    
    const statusCol = `<span class="badge-status ${badgeCls}">${statusText}</span><br><small style="color:var(--text-3);font-size:10px">${fluktuasi.toFixed(1)}%</small>`;

    return `<tr>
      <td class="sticky-col" style="text-align:center">${start + i + 1}</td>
      <td>${r.sitecode||'-'}</td>
      <td style="white-space:nowrap">${r.tdate||'-'}</td>
      <td>${r.afdcode||'-'}</td>
      <td>${r.location||'-'}</td>
      <td>${r.plantingdate||'-'}</td>
      <td>${r.jobtype||'-'}</td>
      <td>${r.jobtypedesc||'-'}</td>
      <td>${r.type||'-'}</td>
      <td>${r.jobgroupcode||'-'}</td>
      <td>${r.jobcode||'-'}</td>
      <td>${r.jobdesc||'-'}</td>
      <td>${r.uom||'-'}</td>
      <td>${fmt(r.ump)}</td>
      <td>${fmt(r.hectplanted)}</td>
      <td>${fmt(r.mandays_hi)}</td>
      <td>${fmt(r.mandays_shi)}</td>
      <td>${fmt(r.hk_per_ha_hi)}</td>
      <td>${fmt(r.hk_per_ha_shi)}</td>
      <td>${fmt(r.produksi_hi)}</td>
      <td>${fmt(r.produksi_shi)}</td>
      <td>${fmt(r.cost_hi)}</td>
      <td>${fmt(r.cost_shi)}</td>
      <td>${fmt(r.premi_hi)}</td>
      <td>${fmt(r.premi_shi)}</td>
      <td>${fmt(r.addcost_hi)}</td>
      <td>${fmt(r.addcost_shi)}</td>
      <td>${statusCol}</td>
      <td><div style="display:flex;gap:6px;justify-content:center">
        <button class="btn btn-primary" style="padding:5px 8px;font-size:11px" onclick="openDetail(${r.id})" title="Lihat Detail">👁️ Detail</button>
        <button class="btn btn-edit-sm" onclick="openEdit(${r.id})" title="Edit">✏️</button>
        <button class="btn btn-danger-sm" onclick="openDelete(${r.id})" title="Hapus">🗑️</button>
      </div></td>
    </tr>`;
  }).join('');'''

content = re.sub(r'tbody\.innerHTML = page\.map\(\(r, i\) => \{.*?\n\s*\}\)\.join\(\'\'\);', new_render, content, flags=re.DOTALL)

# Let's add some missing CSS for the detail modal
css_extra = '''
    .badge-success { background: rgba(34,197,94,0.15); color: #22c55e; border: 1px solid rgba(34,197,94,0.4); }
    .badge-danger { background: rgba(239,68,68,0.15); color: #ef4444; border: 1px solid rgba(239,68,68,0.4); }
    .badge-info { background: rgba(59,130,246,0.15); color: #3b82f6; border: 1px solid rgba(59,130,246,0.4); }
'''
content = content.replace('/* FORM */', css_extra + '/* FORM */')


with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated details view')
