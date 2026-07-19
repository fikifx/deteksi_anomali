import os
import re

files = [
    r'D:\deteksi_anomali\anomali_app\resources\views\admin\master.blade.php',
    r'D:\deteksi_anomali\anomali_app\resources\views\dashboard.blade.php',
    r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php'
]

link = '''      <a href="{{ route('rawat.index') }}" class="nav-item {{ request()->routeIs('rawat.index') ? 'active' : '' }}">
        <span class="nav-icon">🌱</span>
        Data Norma Rawat
      </a>'''

for fpath in files:
    with open(fpath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if 'Data Norma Rawat' not in content:
        content = re.sub(r'(<a href="\{\{ route\(\'master\.index\'\)\}\}".*?</a>)', 
                         r'\1\n' + link, 
                         content, flags=re.DOTALL)
        
        content = content.replace(
            '''<a href="{{ route('master.index') }}" class="nav-item active">''',
            '''<a href="{{ route('master.index') }}" class="nav-item {{ request()->routeIs('master.index') ? 'active' : '' }}">'''
        )
        content = content.replace(
            '''<a href="{{ route('master.index') }}" class="nav-item">''',
            '''<a href="{{ route('master.index') }}" class="nav-item {{ request()->routeIs('master.index') ? 'active' : '' }}">'''
        )

        with open(fpath, 'w', encoding='utf-8') as f:
            f.write(content)
print('Updated sidebars')
