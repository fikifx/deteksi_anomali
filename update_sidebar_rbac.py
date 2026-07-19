import os

files = [
    'd:/deteksi_anomali/anomali_app/resources/views/dashboard.blade.php',
    'd:/deteksi_anomali/anomali_app/resources/views/admin/master.blade.php',
    'd:/deteksi_anomali/anomali_app/resources/views/admin/norma_rawat.blade.php',
    'd:/deteksi_anomali/anomali_app/resources/views/admin/settings.blade.php'
]

new_nav = """  <nav class="sidebar-nav">
    <div class="nav-section-label">Navigasi</div>
    @if(auth()->user()->role != 'Asisten Afdeling')
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <span class="icon">📊</span> Dashboard Overview
    </a>
    @endif
    
    <a href="{{ route('master.index') }}" class="nav-item {{ request()->routeIs('master.index') ? 'active' : '' }}">
      <span class="icon">📋</span> Master Data Norma
    </a>
    <a href="{{ route('rawat.index') }}" class="nav-item {{ request()->routeIs('rawat.index') ? 'active' : '' }}">
      <span class="icon">🌱</span> Data Norma Rawat
    </a>

    @if(auth()->user()->role != 'Asisten Afdeling')
    <div class="nav-section-label" style="margin-top:12px">Pengaturan</div>
    
    @if(auth()->user()->role == 'Manajemen')
    <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.index') ? 'active' : '' }}">
      <span class="icon">⚙️</span> Konfigurasi
    </a>
    @endif
    
    <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
      <span class="icon">👥</span> Pengguna
    </a>
    @endif
  </nav>"""

for file_path in files:
    if not os.path.exists(file_path):
        continue
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # find <nav class="sidebar-nav"> ... </nav>
    start = content.find('<nav class="sidebar-nav">')
    end = content.find('</nav>', start) + len('</nav>')
    
    if start != -1 and end != -1:
        content = content[:start] + new_nav + content[end:]
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated {os.path.basename(file_path)}")

print("Done")
