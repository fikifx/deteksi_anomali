import os

master_path = 'd:/deteksi_anomali/anomali_app/resources/views/admin/master.blade.php'
settings_path = 'd:/deteksi_anomali/anomali_app/resources/views/admin/settings.blade.php'

with open(master_path, 'r', encoding='utf-8') as f:
    content = f.read()

main_start = content.find('<main class="content">') + len('<main class="content">')
header = content[:main_start]

footer_start = content.find('</div>\n\n<!-- MODAL: ADD/EDIT -->')
if footer_start == -1:
    footer_start = content.find('</div>\n\n<div class="toast-container"')

# Extract only the toast container from footer
toast_html = '\n</div>\n<div class="toast-container" id="toastContainer"></div>\n'

settings_content = """
    <div class="page-header">
      <h1>⚙️ Konfigurasi Sistem</h1>
      <p>Pengaturan integrasi pihak ketiga, dan daftar penerima notifikasi Telegram.</p>
    </div>

    @if(session('success'))
    <div style="background:rgba(56,189,130,0.1); border:1px solid var(--accent); color:var(--accent-l); padding:16px 20px; border-radius:12px; margin-bottom:24px; font-weight:600; display:flex; align-items:center; gap:12px;">
      <span>✅</span> {{ session('success') }}
    </div>
    @endif

    <div class="stats-grid" style="grid-template-columns:repeat(2,1fr);">
      <div class="stat-card blue">
        <span class="icon">💬</span>
        <div class="label">Total Penerima</div>
        <div class="value" id="statTotal">{{ count($telegramUsers) }}</div>
        <div class="sub">Akun telegram terdaftar</div>
      </div>
      <div class="stat-card green">
        <span class="icon">🤖</span>
        <div class="label">Status Bot</div>
        <div class="value" style="font-size:24px; margin-top:10px;">{{ !empty($settings['telegram_bot_token']) ? 'Aktif' : 'Tidak Aktif' }}</div>
        <div class="sub">Integrasi API Telegram</div>
      </div>
    </div>

    <!-- MAIN CONFIG -->
    <div class="card" style="background:var(--bg-card); border:1px solid var(--border); border-radius:var(--radius); padding:24px; margin-bottom:24px;">
      <h3 style="font-size:16px; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
        <span style="color:#0088cc; font-size:20px;">🤖</span> Konfigurasi Token Bot
      </h3>
      <form action="{{ route('settings.store') }}" method="POST" style="display:flex; gap:16px; align-items:flex-end;" id="tokenForm">
        @csrf
        <div class="form-group" style="flex:1;">
          <label for="telegram_bot_token" style="margin-bottom:8px; display:block; font-size:12px; font-weight:600; color:var(--text-2); text-transform:uppercase;">Token Bot Telegram (Dari @BotFather)</label>
          <input type="text" id="telegram_bot_token" name="telegram_bot_token" value="{{ $settings['telegram_bot_token'] ?? '' }}" placeholder="Contoh: 1234567890:ABCdefGHIjklMNOpqrsTUVwxyz..." style="width:100%; background:rgba(255,255,255,0.06); border:1px solid var(--border); border-radius:10px; padding:10px 14px; color:var(--text-1); outline:none;" />
        </div>
        <button type="submit" id="btnSaveToken" style="background:rgba(255,255,255,0.1); color:#fff; border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-weight:600; cursor:pointer; height:42px;">💾 Simpan Token</button>
      </form>
    </div>

    <!-- TABLE CARD -->
    <div class="table-card">
      <div class="toolbar">
        <div class="toolbar-left">
          <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Cari nama atau ID..." oninput="applyFilter()" />
          </div>
        </div>
        <div class="toolbar-right">
          <button class="btn btn-primary" onclick="openAdd()">＋ Tambah Penerima</button>
        </div>
      </div>

      <div class="table-wrap">
        <table id="userTable">
          <thead>
            <tr>
              <th class="left">Nama Penerima</th>
              <th class="left">Chat ID Telegram</th>
              <th style="width:120px;">Aksi</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>
      
      <div class="pagination-bar">
        <div class="pagination-info" id="paginationInfo">Menampilkan 0 data</div>
        <div class="pagination-btns" id="paginationBtns"></div>
      </div>
    </div>

    <!-- MODAL: ADD/EDIT -->
    <div class="modal-overlay" id="formModal">
      <div class="modal" style="max-width:480px">
        <div class="modal-header">
          <h3 id="formModalTitle">➕ Tambah Penerima</h3>
          <button class="modal-close" onclick="closeFormModal()">✕</button>
        </div>
        <div class="modal-body">
          <div class="form-group" style="margin-bottom:16px;">
            <label>Nama Penerima</label>
            <input type="text" id="fName" placeholder="Contoh: Bpk. Budi" />
          </div>
          <div class="form-group">
            <label>Chat ID Telegram</label>
            <input type="text" id="fChatId" placeholder="Contoh: 123456789" />
            <span style="font-size:11px; color:var(--text-3); margin-top:6px; display:block;">Gunakan <a href="https://t.me/userinfobot" target="_blank" style="color:var(--accent);">@userinfobot</a> untuk mengetahui ID Anda. <strong>Penting:</strong> Pastikan penerima sudah memulai obrolan dengan <a href="http://t.me/AnomaliCost_bot" target="_blank" style="color:#4fc3f7;font-weight:600;">@AnomaliCost_bot</a>.</span>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline" onclick="closeFormModal()">Batal</button>
          <button class="btn btn-primary" onclick="submitForm()" id="formSubmitBtn">💾 Simpan</button>
        </div>
      </div>
    </div>

    <!-- MODAL: DELETE -->
    <div class="modal-overlay" id="deleteModal">
      <div class="modal confirm-modal" style="max-width:440px">
        <div class="modal-header">
          <h3>🗑️ Hapus Penerima</h3>
          <button class="modal-close" onclick="closeDeleteModal()">✕</button>
        </div>
        <div class="modal-body">
          <p style="color:var(--text-2);font-size:14px;line-height:1.8">
            Apakah Anda yakin ingin menghapus penerima ini?<br/>
            <strong id="deleteItemName" style="color:var(--text-1)"></strong><br/><br/>
            <span style="color:var(--danger);font-size:12.5px">⚠️ Tindakan ini tidak dapat dibatalkan.</span>
          </p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
          <button class="btn" style="background:var(--danger);color:#fff" onclick="confirmDelete()" id="deleteSubmitBtn">🗑️ Hapus</button>
        </div>
      </div>
    </div>
"""

custom_js = """
<script>
let userData = {!! isset($telegramUsers) ? $telegramUsers->toJson() : '[]' !!};
let filteredData = [];
let currentPage = 1;
const perPage = 10;
let editingId = null;
let deletingId = null;

function applyFilter() {
  const s = document.getElementById('searchInput').value.toLowerCase();
  filteredData = userData.filter(r => {
    return (r.name && r.name.toLowerCase().includes(s)) || (r.chat_id && r.chat_id.toLowerCase().includes(s));
  });
  currentPage = 1;
  renderTable();
}

function renderTable() {
  const tbody = document.getElementById('tableBody');
  tbody.innerHTML = '';
  
  if(filteredData.length === 0) {
    tbody.innerHTML = '<tr><td colspan="3"><div class="empty-state"><div class="icon">📬</div><h3>Tidak ada penerima</h3><p>Belum ada data penerima notifikasi yang ditambahkan.</p></div></td></tr>';
    document.getElementById('paginationInfo').textContent = 'Menampilkan 0 data';
    document.getElementById('paginationBtns').innerHTML = '';
    return;
  }

  const start = (currentPage - 1) * perPage;
  const end = start + perPage;
  const pageData = filteredData.slice(start, end);

  let html = '';
  pageData.forEach(r => {
    html += `
      <tr>
        <td class="left" style="font-weight:600; color:#fff;">${r.name}</td>
        <td class="left" style="font-family:monospace; color:var(--info);">${r.chat_id}</td>
        <td>
          <div style="display:flex;align-items:center;justify-content:center;gap:6px">
            <button class="btn-edit-sm" onclick="openEdit(${r.id})">✏️ Edit</button>
            <button class="btn-danger-sm" onclick="openDelete(${r.id}, '${r.name}')">🗑️ Hapus</button>
          </div>
        </td>
      </tr>
    `;
  });
  tbody.innerHTML = html;
  
  document.getElementById('paginationInfo').textContent = `Menampilkan ${start+1}-${Math.min(end, filteredData.length)} dari ${filteredData.length} penerima`;
  renderPagination();
}

function renderPagination() {
  const totalPages = Math.ceil(filteredData.length / perPage);
  const cont = document.getElementById('paginationBtns');
  if(totalPages <= 1) { cont.innerHTML=''; return; }

  let html = `<button class="page-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}>&lsaquo;</button>`;
  for(let i=1; i<=totalPages; i++) {
    html += `<button class="page-btn ${currentPage===i?'active':''}" onclick="goPage(${i})">${i}</button>`;
  }
  html += `<button class="page-btn" onclick="goPage(${currentPage+1})" ${currentPage===totalPages?'disabled':''}>&rsaquo;</button>`;
  cont.innerHTML = html;
}

function goPage(p) {
  const totalPages = Math.ceil(filteredData.length / perPage);
  if(p<1 || p>totalPages) return;
  currentPage = p;
  renderTable();
}

function openAdd() {
  editingId = null;
  document.getElementById('formModalTitle').textContent = '➕ Tambah Penerima';
  document.getElementById('fName').value = '';
  document.getElementById('fChatId').value = '';
  document.getElementById('formModal').classList.add('open');
}

function openEdit(id) {
  const row = userData.find(r => r.id === id);
  if(!row) return;
  editingId = id;
  document.getElementById('formModalTitle').textContent = '✏️ Edit Penerima';
  document.getElementById('fName').value = row.name;
  document.getElementById('fChatId').value = row.chat_id;
  document.getElementById('formModal').classList.add('open');
}

function closeFormModal() { document.getElementById('formModal').classList.remove('open'); }

function openDelete(id, name) {
  deletingId = id;
  document.getElementById('deleteItemName').textContent = name;
  document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('open'); }

function showToast(msg, type='success') {
  const container = document.getElementById('toastContainer');
  const toast = document.createElement('div');
  toast.className = 'toast ' + type;
  const icon = type==='success' ? '✅' : '❌';
  toast.innerHTML = `<div class="toast-icon">${icon}</div><div>${msg}</div>`;
  container.appendChild(toast);
  setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
}

function submitForm() {
  const name = document.getElementById('fName').value.trim();
  const chat_id = document.getElementById('fChatId').value.trim();
  if(!name || !chat_id) return showToast('Nama dan Chat ID wajib diisi!', 'error');

  const payload = { name, chat_id };
  const url = editingId ? `/telegram-users/${editingId}` : '/telegram-users';
  const method = editingId ? 'PUT' : 'POST';

  const btn = document.getElementById('formSubmitBtn');
  const originalText = btn.innerHTML;
  btn.innerHTML = '⏳ Menyimpan...';
  btn.disabled = true;

  fetch(url, {
    method: method,
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify(payload)
  }).then(r => r.json()).then(res => {
    if(res.success) {
      showToast('Data berhasil disimpan!', 'success');
      setTimeout(() => location.reload(), 800);
    } else {
      showToast('Terjadi kesalahan', 'error');
      btn.innerHTML = originalText;
      btn.disabled = false;
    }
  }).catch(()=>{
    showToast('Gagal terhubung ke server','error');
    btn.innerHTML = originalText;
    btn.disabled = false;
  });
}

function confirmDelete() {
  if(!deletingId) return;
  const btn = document.getElementById('deleteSubmitBtn');
  const originalText = btn.innerHTML;
  btn.innerHTML = '⏳ Menghapus...';
  btn.disabled = true;

  fetch(`/telegram-users/${deletingId}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
  }).then(r => r.json()).then(res => {
    if(res.success) {
      showToast('Data berhasil dihapus!', 'success');
      setTimeout(() => location.reload(), 800);
    } else {
      showToast('Terjadi kesalahan', 'error');
      btn.innerHTML = originalText;
      btn.disabled = false;
    }
  }).catch(()=>{
    showToast('Gagal terhubung ke server','error');
    btn.innerHTML = originalText;
    btn.disabled = false;
  });
}

document.getElementById('tokenForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnSaveToken');
    btn.innerHTML = '⏳ Menyimpan...';
    btn.disabled = true;
});

// init
applyFilter();
</script>
</body>
</html>
"""

new_file = header + '\n' + settings_content + toast_html + custom_js
new_file = new_file.replace('Home &rsaquo; <span>Master Data Norma</span>', 'Home &rsaquo; <span>Konfigurasi Telegram</span>')

with open(settings_path, 'w', encoding='utf-8') as f:
    f.write(new_file)

print("Done building admin.settings view")
