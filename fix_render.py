import re

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

new_render = '''  tbody.innerHTML = page.map(r => {
    return `<tr>
      <td>${r.sitecode||'-'}</td>
      <td>${r.tdate||'-'}</td>
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
      <td><div style="display:flex;gap:6px;justify-content:center">
        <button class="btn btn-edit-sm" onclick="openEdit(${r.id})" title="Edit">✏️ Edit</button>
        <button class="btn btn-danger-sm" onclick="openDelete(${r.id})" title="Hapus">🗑️</button>
      </div></td>
    </tr>`;
  }).join('');'''

content = re.sub(r'tbody\.innerHTML = page\.map.*?join\(\'\'\);', new_render, content, flags=re.DOTALL)

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Fixed render logic')
