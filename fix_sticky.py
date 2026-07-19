import re

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# CSS adjustments for sticky column
css_rules = '''
    .table-wrap th.sticky-col { position: sticky; left: 0; z-index: 12; background: rgba(10,15,26,1); border-right: 1px solid var(--border); }
    .table-wrap td.sticky-col { position: sticky; left: 0; z-index: 10; background: var(--bg-card); border-right: 1px solid var(--border); }
'''
content = content.replace('/* TABLE CARD */', css_rules + '/* TABLE CARD */')

# Add No column to thead
content = re.sub(r'(<tr>\s*<th style="min-width:100px">SITECODE</th>)', 
                 r'<tr>\n              <th style="min-width:50px" class="sticky-col">No</th>\n              <th style="min-width:100px">SITECODE</th>', 
                 content)

# Update tbody rendering logic
new_render = '''  tbody.innerHTML = page.map((r, i) => {
    return `<tr>
      <td class="sticky-col" style="text-align:center">${start + i + 1}</td>
      <td>${r.sitecode||'-'}</td>'''

content = re.sub(r'tbody\.innerHTML = page\.map\(r => \{\s*return `<tr>\s*<td>\$\{r\.sitecode\|\|\'-\'\}</td>', new_render, content, flags=re.DOTALL)

with open(r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Added sticky No column')
