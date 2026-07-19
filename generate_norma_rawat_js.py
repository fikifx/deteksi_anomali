import re

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace openEdit
new_openedit = '''
function openEdit(id) {
  const row = masterData.find(r=>r.id===id);
  if(!row) return;
  editingId=id;
  document.getElementById('formModalTitle').textContent='✏️ Edit Data Norma';
  document.getElementById('formSubmitBtn').textContent='💾 Update';
  
  document.getElementById('f_sitecode').value = row.sitecode||'';
  document.getElementById('f_tdate').value = row.tdate||'';
  document.getElementById('f_afdcode').value = row.afdcode||'';
  document.getElementById('f_location').value = row.location||'';
  document.getElementById('f_plantingdate').value = row.plantingdate||'';
  document.getElementById('f_jobtype').value = row.jobtype||'';
  document.getElementById('f_jobtypedesc').value = row.jobtypedesc||'';
  document.getElementById('f_type').value = row.type||'';
  document.getElementById('f_jobgroupcode').value = row.jobgroupcode||'';
  document.getElementById('f_jobcode').value = row.jobcode||'';
  document.getElementById('f_jobdesc').value = row.jobdesc||'';
  document.getElementById('f_uom').value = row.uom||'';
  document.getElementById('f_ump').value = row.ump??'';
  document.getElementById('f_hectplanted').value = row.hectplanted??'';
  document.getElementById('f_mandays_hi').value = row.mandays_hi??'';
  document.getElementById('f_mandays_shi').value = row.mandays_shi??'';
  document.getElementById('f_hk_per_ha_hi').value = row.hk_per_ha_hi??'';
  document.getElementById('f_hk_per_ha_shi').value = row.hk_per_ha_shi??'';
  document.getElementById('f_produksi_hi').value = row.produksi_hi??'';
  document.getElementById('f_produksi_shi').value = row.produksi_shi??'';
  document.getElementById('f_cost_hi').value = row.cost_hi??'';
  document.getElementById('f_cost_shi').value = row.cost_shi??'';
  document.getElementById('f_premi_hi').value = row.premi_hi??'';
  document.getElementById('f_premi_shi').value = row.premi_shi??'';
  document.getElementById('f_addcost_hi').value = row.addcost_hi??'';
  document.getElementById('f_addcost_shi').value = row.addcost_shi??'';
  
  document.getElementById('formModal').classList.add('open');
}
'''
content = re.sub(r'function openEdit\(id\) \{.*?\n\}', new_openedit, content, flags=re.DOTALL)

# Replace submitForm
new_submitform = '''
async function submitForm() {
  const sitecode = document.getElementById('f_sitecode').value.trim();
  const location = document.getElementById('f_location').value.trim();
  if(!sitecode) { showToast('error','SITECODE wajib diisi!'); return; }
  
  const parseFloatSafe = (val) => {
     const p = parseFloat(val);
     return isNaN(p) ? null : p;
  };

  const obj = {
    sitecode: sitecode,
    tdate: document.getElementById('f_tdate').value||null,
    afdcode: document.getElementById('f_afdcode').value,
    location: location,
    plantingdate: parseInt(document.getElementById('f_plantingdate').value)||null,
    jobtype: document.getElementById('f_jobtype').value,
    jobtypedesc: document.getElementById('f_jobtypedesc').value,
    type: document.getElementById('f_type').value,
    jobgroupcode: document.getElementById('f_jobgroupcode').value,
    jobcode: document.getElementById('f_jobcode').value,
    jobdesc: document.getElementById('f_jobdesc').value,
    uom: document.getElementById('f_uom').value,
    ump: parseFloatSafe(document.getElementById('f_ump').value),
    hectplanted: parseFloatSafe(document.getElementById('f_hectplanted').value),
    mandays_hi: parseFloatSafe(document.getElementById('f_mandays_hi').value),
    mandays_shi: parseFloatSafe(document.getElementById('f_mandays_shi').value),
    hk_per_ha_hi: parseFloatSafe(document.getElementById('f_hk_per_ha_hi').value),
    hk_per_ha_shi: parseFloatSafe(document.getElementById('f_hk_per_ha_shi').value),
    produksi_hi: parseFloatSafe(document.getElementById('f_produksi_hi').value),
    produksi_shi: parseFloatSafe(document.getElementById('f_produksi_shi').value),
    cost_hi: parseFloatSafe(document.getElementById('f_cost_hi').value),
    cost_shi: parseFloatSafe(document.getElementById('f_cost_shi').value),
    premi_hi: parseFloatSafe(document.getElementById('f_premi_hi').value),
    premi_shi: parseFloatSafe(document.getElementById('f_premi_shi').value),
    addcost_hi: parseFloatSafe(document.getElementById('f_addcost_hi').value),
    addcost_shi: parseFloatSafe(document.getElementById('f_addcost_shi').value)
  };

  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const url = editingId ? '/norma-rawat/' + editingId : '/norma-rawat';
  const method = editingId ? 'PUT' : 'POST';

  try {
    const res = await fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
      },
      body: JSON.stringify(obj)
    });
    if(res.ok) {
      showToast('success', editingId ? 'Data berhasil diperbarui ✓' : 'Data berhasil ditambahkan ✓');
      setTimeout(() => window.location.reload(), 1000);
    } else {
      showToast('error', 'Gagal menyimpan data');
    }
  } catch(e) {
    showToast('error', 'Terjadi kesalahan sistem');
  }
}
'''
content = re.sub(r'async function submitForm\(\) \{.*?\n\}', new_submitform, content, flags=re.DOTALL)

# Replace masterData initialization
new_masterdata = '''
let masterData = {!! $data->toJson() !!};
'''
content = re.sub(r'let masterData = \{!!.*?!!\};', new_masterdata, content, flags=re.DOTALL)

# Update deleteItemName
content = re.sub(r'\$\{row\.status_umur\} – \$\{row\.item_kerja\}', '${row.sitecode} - ${row.location}', content)

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print('Done JS')
