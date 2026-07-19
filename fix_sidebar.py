import re

sidebar_correct = '''  <nav class="sidebar-nav">
    <div class="nav-section-label">Navigasi</div>
    <a href="{{ route('dashboard') }}" class="nav-item">
      <span class="icon">📊</span> Dashboard Overview
    </a>
    <a href="{{ route('master.index') }}" class="nav-item {{ request()->routeIs('master.index') ? 'active' : '' }}">
      <span class="icon">📋</span> Master Data Norma
    </a>
    <a href="{{ route('rawat.index') }}" class="nav-item {{ request()->routeIs('rawat.index') ? 'active' : '' }}">
      <span class="icon">🌱</span> Data Norma Rawat
    </a>
    <div class="nav-section-label" style="margin-top:12px">Laporan</div>
    <a href="#" class="nav-item"><span class="icon">📈</span> Analisis Anggaran</a>
    <a href="#" class="nav-item"><span class="icon">🔍</span> Deteksi Anomali</a>
    <a href="#" class="nav-item"><span class="icon">🗓️</span> Rencana Kerja</a>
    <div class="nav-section-label" style="margin-top:12px">Pengaturan</div>
    <a href="#" class="nav-item"><span class="icon">⚙️</span> Konfigurasi</a>
    <a href="#" class="nav-item"><span class="icon">👥</span> Pengguna</a>
  </nav>'''

files = [
    r'D:\deteksi_anomali\anomali_app\resources\views\admin\master.blade.php',
    r'D:\deteksi_anomali\anomali_app\resources\views\admin\norma_rawat.blade.php'
]

for f in files:
    with open(f, 'r', encoding='utf-8') as file:
        content = file.read()
    
    content = re.sub(r'<nav class="sidebar-nav">.*?</nav>', sidebar_correct, content, flags=re.DOTALL)
    
    with open(f, 'w', encoding='utf-8') as file:
        file.write(content)

print('Fixed sidebars')
