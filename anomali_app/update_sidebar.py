import os
import glob

files = [
    'resources/views/dashboard.blade.php',
    'resources/views/admin/master.blade.php',
    'resources/views/admin/norma_rawat.blade.php',
    'resources/views/admin/master_budget.blade.php',
    'resources/views/admin/settings.blade.php',
    'resources/views/admin/users.blade.php'
]

link_str = '''
    <a href="{{ route('master.index') }}" class="nav-item {{ request()->routeIs('master.index') ? 'active' : '' }}">
      <span class="icon">📋</span> Master Data Norma
    </a>
    <a href="{{ route('budget.index') }}" class="nav-item {{ request()->routeIs('budget.index') ? 'active' : '' }}">
      <span class="icon">💰</span> Master Budget
    </a>
'''

for file in files:
    if os.path.exists(file):
        with open(file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Replace the Master Data Norma link with both links
        import re
        content = re.sub(r'<a href="\{\{\s*route\(\'master\.index\'\)\s*\}\}".*?</a>', link_str.strip(), content, flags=re.DOTALL)
        
        with open(file, 'w', encoding='utf-8') as f:
            f.write(content)
