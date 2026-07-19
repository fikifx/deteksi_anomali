import os

settings_path = 'd:/deteksi_anomali/anomali_app/resources/views/admin/settings.blade.php'
users_path = 'd:/deteksi_anomali/anomali_app/resources/views/admin/users.blade.php'

with open(settings_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace main page header and strings
content = content.replace('⚙️ Konfigurasi Sistem', '👥 Manajemen Pengguna')
content = content.replace('Pengaturan integrasi pihak ketiga, dan daftar penerima notifikasi Telegram.', 'Kelola data pengguna, akses login, dan penugasan peran (Role).')
content = content.replace('Home &rsaquo; <span>Konfigurasi Telegram</span>', 'Home &rsaquo; <span>Manajemen Pengguna</span>')

# Remove the Token Form config section
start = content.find('<!-- MAIN CONFIG -->')
end = content.find('<!-- TABLE CARD -->')
if start != -1 and end != -1:
    content = content[:start] + content[end:]

# Replace stats
content = content.replace('Akun telegram terdaftar', 'Total akun pengguna')
content = content.replace('Total Penerima', 'Total Pengguna')
content = content.replace('{{ count($telegramUsers) }}', '{{ count($users) }}')
content = content.replace('Status Bot', 'Admin Aktif')
content = content.replace("{{ !empty($settings['telegram_bot_token']) ? 'Aktif' : 'Tidak Aktif' }}", "{{ $users->where('role','Manajemen')->count() }}")
content = content.replace('Integrasi API Telegram', 'Akun manajemen / admin')

# Replace table columns
content = content.replace('<th class="left">Nama Penerima</th>\n              <th class="left">Chat ID Telegram</th>', 
    '<th class="left">Nama Lengkap</th>\n              <th class="left">Email Login</th>\n              <th class="left">Role Akses</th>')

content = content.replace('Tidak ada penerima', 'Tidak ada pengguna')
content = content.replace('Belum ada data penerima notifikasi yang ditambahkan.', 'Belum ada data pengguna.')
content = content.replace('dari ${filteredData.length} penerima', 'dari ${filteredData.length} pengguna')
content = content.replace('➕ Tambah Penerima', '➕ Tambah Pengguna')
content = content.replace('✏️ Edit Penerima', '✏️ Edit Pengguna')
content = content.replace('🗑️ Hapus Penerima', '🗑️ Hapus Pengguna')
content = content.replace('apakah Anda yakin ingin menghapus penerima ini?', 'Apakah Anda yakin ingin menghapus pengguna ini?')

# Form inputs
old_form = """<div class="form-group" style="margin-bottom:16px;">
            <label>Nama Penerima</label>
            <input type="text" id="fName" placeholder="Contoh: Bpk. Budi" />
          </div>
          <div class="form-group">
            <label>Chat ID Telegram</label>
            <input type="text" id="fChatId" placeholder="Contoh: 123456789" />
            <span style="font-size:11px; color:var(--text-3); margin-top:6px; display:block;">Gunakan <a href="https://t.me/userinfobot" target="_blank" style="color:var(--accent);">@userinfobot</a> untuk mengetahui ID Anda. <strong>Penting:</strong> Pastikan penerima sudah memulai obrolan dengan <a href="http://t.me/AnomaliCost_bot" target="_blank" style="color:#4fc3f7;font-weight:600;">@AnomaliCost_bot</a>.</span>
          </div>"""

new_form = """<div class="form-group" style="margin-bottom:16px;">
            <label>Nama Lengkap</label>
            <input type="text" id="fName" placeholder="Contoh: Bpk. Budi" />
          </div>
          <div class="form-group" style="margin-bottom:16px;">
            <label>Email Akses</label>
            <input type="email" id="fEmail" placeholder="Contoh: budi@anomali.com" />
          </div>
          <div class="form-group" style="margin-bottom:16px;">
            <label>Password Login</label>
            <input type="password" id="fPassword" placeholder="Minimal 6 karakter" />
            <span style="font-size:11px; color:var(--text-3); margin-top:6px; display:block;" id="pwHint">Kosongkan jika tidak ingin mengubah password (saat Edit).</span>
          </div>
          <div class="form-group">
            <label>Hak Akses (Role)</label>
            <select id="fRole" class="filter-select" style="width:100%">
              <option value="Asisten Afdeling">Asisten Afdeling</option>
              <option value="Kepala Kebun">Kepala Kebun</option>
              <option value="Manajemen">Manajemen</option>
            </select>
          </div>"""

content = content.replace(old_form, new_form)

# JS variables
content = content.replace("let userData = {!! isset($telegramUsers) ? $telegramUsers->toJson() : '[]' !!};", 
                          "let userData = {!! isset($users) ? $users->toJson() : '[]' !!};")

# Search logic
content = content.replace('(r.name && r.name.toLowerCase().includes(s)) || (r.chat_id && r.chat_id.toLowerCase().includes(s))',
                          '(r.name && r.name.toLowerCase().includes(s)) || (r.email && r.email.toLowerCase().includes(s)) || (r.role && r.role.toLowerCase().includes(s))')

# JS Table row
old_row = """      <tr>
        <td class="left" style="font-weight:600; color:#fff;">${r.name}</td>
        <td class="left" style="font-family:monospace; color:var(--info);">${r.chat_id}</td>
        <td>
          <div style="display:flex;align-items:center;justify-content:center;gap:6px">
            <button class="btn-edit-sm" onclick="openEdit(${r.id})">✏️ Edit</button>
            <button class="btn-danger-sm" onclick="openDelete(${r.id}, '${r.name}')">🗑️ Hapus</button>
          </div>
        </td>
      </tr>"""

new_row = """      <tr>
        <td class="left" style="font-weight:600; color:#fff;">${r.name}</td>
        <td class="left" style="color:var(--text-2);">${r.email}</td>
        <td class="left">
          <span style="padding:4px 10px; border-radius:100px; font-size:11px; font-weight:600; background:rgba(255,255,255,0.1); color:var(--text-1);">
            ${r.role === 'Manajemen' ? '👑 Manajemen' : (r.role === 'Kepala Kebun' ? '👨‍💼 Kepala Kebun' : '🧑‍🌾 Asisten')}
          </span>
        </td>
        <td>
          <div style="display:flex;align-items:center;justify-content:center;gap:6px">
            <button class="btn-edit-sm" onclick="openEdit(${r.id})">✏️ Edit</button>
            <button class="btn-danger-sm" onclick="openDelete(${r.id}, '${r.name}')">🗑️ Hapus</button>
          </div>
        </td>
      </tr>"""

content = content.replace(old_row, new_row)

# openAdd
content = content.replace("document.getElementById('fChatId').value = '';",
                          "document.getElementById('fEmail').value = ''; document.getElementById('fPassword').value = ''; document.getElementById('fRole').value = 'Asisten Afdeling';")

# openEdit
content = content.replace("document.getElementById('fChatId').value = row.chat_id;",
                          "document.getElementById('fEmail').value = row.email; document.getElementById('fPassword').value = ''; document.getElementById('fRole').value = row.role;")

# submitForm variables
content = content.replace("const chat_id = document.getElementById('fChatId').value.trim();",
                          "const email = document.getElementById('fEmail').value.trim(); const password = document.getElementById('fPassword').value.trim(); const role = document.getElementById('fRole').value;")

content = content.replace("if(!name || !chat_id) return showToast('Nama dan Chat ID wajib diisi!', 'error');",
                          "if(!name || !email) return showToast('Nama dan Email wajib diisi!', 'error');\n  if(!editingId && !password) return showToast('Password wajib diisi untuk user baru!', 'error');")

content = content.replace("const payload = { name, chat_id };",
                          "const payload = { name, email, role };\n  if(password) payload.password = password;")

content = content.replace("`/telegram-users/${editingId}` : '/telegram-users'",
                          "`/users/${editingId}` : '/users'")

content = content.replace("`/telegram-users/${deletingId}`",
                          "`/users/${deletingId}`")

content = content.replace("document.getElementById('tokenForm').addEventListener('submit', function() {\n    const btn = document.getElementById('btnSaveToken');\n    btn.innerHTML = '⏳ Menyimpan...';\n    btn.disabled = true;\n});", "")

with open(users_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("Created users.blade.php")
