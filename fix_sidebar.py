import os
import re

files = [
    'd:/deteksi_anomali/anomali_app/resources/views/admin/master.blade.php',
    'd:/deteksi_anomali/anomali_app/resources/views/admin/norma_rawat.blade.php',
    'd:/deteksi_anomali/anomali_app/resources/views/admin/settings.blade.php',
    'd:/deteksi_anomali/anomali_app/resources/views/admin/users.blade.php'
]

css_to_add = """
    /* MOBILE RESPONSIVE SIDEBAR */
    .mobile-menu-btn {
      display: none;
      background: none; border: none; color: var(--text-1); font-size: 24px; cursor: pointer;
      margin-right: 12px;
    }
    .sidebar-overlay {
      position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(2px);
      z-index: 95; display: none; opacity: 0; transition: opacity 0.3s;
    }
    .sidebar-overlay.show { display: block; opacity: 1; }
    
    @media(max-width:768px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .main-wrap { margin-left: 0; }
      .mobile-menu-btn { display: block; }
      .form-grid { grid-template-columns: 1fr; }
      .content { padding: 16px; }
      .topbar { padding: 0 16px; }
    }
"""

js_to_add = """
<script>
  function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    if (sidebar.classList.contains('show')) {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    } else {
      sidebar.classList.add('show');
      overlay.classList.add('show');
    }
  }
</script>
"""

for file_path in files:
    if not os.path.exists(file_path):
        continue
        
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
        
    # Prevent duplicate additions
    if 'MOBILE RESPONSIVE SIDEBAR' in content:
        print(f"Skipping {os.path.basename(file_path)} (already applied)")
        continue

    # 1. Add CSS
    # find the existing media query and replace/append
    content = content.replace('@media(max-width:768px) { .main-wrap { margin-left:0; } .form-grid { grid-template-columns:1fr; } .content { padding:16px; } }', css_to_add)
    
    # 2. Add Overlay before sidebar
    content = content.replace('<aside class="sidebar">', '<div class="sidebar-overlay" onclick="toggleSidebar()"></div>\n<aside class="sidebar">')
    
    # 3. Add mobile button in topbar
    content = content.replace('<div class="breadcrumb">', '<button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>\n    <div class="breadcrumb">')
    
    # 4. Add JS at the end before </body>
    content = content.replace('</body>', js_to_add + '\n</body>')
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print(f"Fixed {os.path.basename(file_path)}")
