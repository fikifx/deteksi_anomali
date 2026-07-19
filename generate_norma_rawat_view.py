import re

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\master.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace basic text
content = content.replace('Master Data Norma', 'Data Norma Rawat')
content = content.replace('master-norma', 'norma-rawat')
content = content.replace('master.export', 'rawat.export')
content = content.replace('master.import', 'rawat.import')

# Update table headers
new_th = '''
              <th style="min-width:100px">SITECODE</th>
              <th style="min-width:100px">TDATE</th>
              <th style="min-width:100px">AFDCODE</th>
              <th style="min-width:100px">LOCATION</th>
              <th style="min-width:120px">PLANTINGDATE</th>
              <th style="min-width:100px">JOBTYPE</th>
              <th style="min-width:150px">JOBTYPEDESC</th>
              <th style="min-width:80px">TYPE</th>
              <th style="min-width:120px">JOBGROUPCODE</th>
              <th style="min-width:100px">JOBCODE</th>
              <th style="min-width:150px">JOBDESC</th>
              <th style="min-width:80px">UOM</th>
              <th style="min-width:80px">UMP</th>
              <th style="min-width:120px">HECTPLANTED</th>
              <th style="min-width:120px">MANDAYS_HI</th>
              <th style="min-width:120px">MANDAYS_SHI</th>
              <th style="min-width:120px">HK_PER_HA_HI</th>
              <th style="min-width:120px">HK_PER_HA_SHI</th>
              <th style="min-width:120px">PRODUKSI_HI</th>
              <th style="min-width:120px">PRODUKSI_SHI</th>
              <th style="min-width:100px">COST_HI</th>
              <th style="min-width:100px">COST_SHI</th>
              <th style="min-width:100px">PREMI_HI</th>
              <th style="min-width:100px">PREMI_SHI</th>
              <th style="min-width:120px">ADDCOST_HI</th>
              <th style="min-width:120px">ADDCOST_SHI</th>
              <th style="min-width:110px">Aksi</th>
'''
content = re.sub(r'<thead.*?</thead>', f'<thead><tr>{new_th}</tr></thead>', content, flags=re.DOTALL)

# Update form modal body for 26 columns
new_form = '''
        <div class="form-group"><label>SITECODE</label><input type="text" id="f_sitecode"></div>
        <div class="form-group"><label>TDATE</label><input type="date" id="f_tdate"></div>
        <div class="form-group"><label>AFDCODE</label><input type="text" id="f_afdcode"></div>
        <div class="form-group"><label>LOCATION</label><input type="text" id="f_location"></div>
        <div class="form-group"><label>PLANTINGDATE</label><input type="number" id="f_plantingdate"></div>
        <div class="form-group"><label>JOBTYPE</label><input type="text" id="f_jobtype"></div>
        <div class="form-group"><label>JOBTYPEDESC</label><input type="text" id="f_jobtypedesc"></div>
        <div class="form-group"><label>TYPE</label><input type="text" id="f_type"></div>
        <div class="form-group"><label>JOBGROUPCODE</label><input type="text" id="f_jobgroupcode"></div>
        <div class="form-group"><label>JOBCODE</label><input type="text" id="f_jobcode"></div>
        <div class="form-group"><label>JOBDESC</label><input type="text" id="f_jobdesc"></div>
        <div class="form-group"><label>UOM</label><input type="text" id="f_uom"></div>
        
        <div class="form-divider">Data Angka</div>
        <div class="form-group"><label>UMP</label><input type="number" step="0.0001" id="f_ump"></div>
        <div class="form-group"><label>HECTPLANTED</label><input type="number" step="0.0001" id="f_hectplanted"></div>
        <div class="form-group"><label>MANDAYS_HI</label><input type="number" step="0.0001" id="f_mandays_hi"></div>
        <div class="form-group"><label>MANDAYS_SHI</label><input type="number" step="0.0001" id="f_mandays_shi"></div>
        <div class="form-group"><label>HK_PER_HA_HI</label><input type="number" step="0.0001" id="f_hk_per_ha_hi"></div>
        <div class="form-group"><label>HK_PER_HA_SHI</label><input type="number" step="0.0001" id="f_hk_per_ha_shi"></div>
        <div class="form-group"><label>PRODUKSI_HI</label><input type="number" step="0.0001" id="f_produksi_hi"></div>
        <div class="form-group"><label>PRODUKSI_SHI</label><input type="number" step="0.0001" id="f_produksi_shi"></div>
        <div class="form-group"><label>COST_HI</label><input type="number" step="0.0001" id="f_cost_hi"></div>
        <div class="form-group"><label>COST_SHI</label><input type="number" step="0.0001" id="f_cost_shi"></div>
        <div class="form-group"><label>PREMI_HI</label><input type="number" step="0.0001" id="f_premi_hi"></div>
        <div class="form-group"><label>PREMI_SHI</label><input type="number" step="0.0001" id="f_premi_shi"></div>
        <div class="form-group"><label>ADDCOST_HI</label><input type="number" step="0.0001" id="f_addcost_hi"></div>
        <div class="form-group"><label>ADDCOST_SHI</label><input type="number" step="0.0001" id="f_addcost_shi"></div>
'''
content = re.sub(r'<div class="form-grid">.*?</div>\s*</div>\s*<div class="modal-footer">', 
                 f'<div class="form-grid">{new_form}</div></div><div class="modal-footer">', 
                 content, flags=re.DOTALL)

# Javascript rendering
new_render_js = """
  tbody.innerHTML = paginated.map(r => `
    <tr>
      <td>${r.sitecode||''}</td>
      <td>${r.tdate||''}</td>
      <td>${r.afdcode||''}</td>
      <td>${r.location||''}</td>
      <td>${r.plantingdate||''}</td>
      <td>${r.jobtype||''}</td>
      <td>${r.jobtypedesc||''}</td>
      <td>${r.type||''}</td>
      <td>${r.jobgroupcode||''}</td>
      <td>${r.jobcode||''}</td>
      <td>${r.jobdesc||''}</td>
      <td>${r.uom||''}</td>
      <td>${r.ump||''}</td>
      <td>${r.hectplanted||''}</td>
      <td>${r.mandays_hi||''}</td>
      <td>${r.mandays_shi||''}</td>
      <td>${r.hk_per_ha_hi||''}</td>
      <td>${r.hk_per_ha_shi||''}</td>
      <td>${r.produksi_hi||''}</td>
      <td>${r.produksi_shi||''}</td>
      <td>${r.cost_hi||''}</td>
      <td>${r.cost_shi||''}</td>
      <td>${r.premi_hi||''}</td>
      <td>${r.premi_shi||''}</td>
      <td>${r.addcost_hi||''}</td>
      <td>${r.addcost_shi||''}</td>
      <td>
        <button class="action-btn edit-btn" onclick="openEdit(${r.id})">✏️</button>
        <button class="action-btn delete-btn" onclick="openDelete(${r.id})">🗑️</button>
      </td>
    </tr>
  `).join('');
"""
content = re.sub(r'tbody\.innerHTML = paginated\.map.*?join\(\'\'\);', new_render_js, content, flags=re.DOTALL)


with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print('Done')
