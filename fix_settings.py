import os

master_path = 'd:/deteksi_anomali/anomali_app/resources/views/admin/master.blade.php'
settings_path = 'd:/deteksi_anomali/anomali_app/resources/views/admin/settings.blade.php'

with open(master_path, 'r', encoding='utf-8') as f:
    content = f.read()

main_start = content.find('<main class="content">') + len('<main class="content">')
header = content[:main_start]

# find end of main content
footer_start = content.find('</div>\n\n<!-- MODAL: ADD/EDIT -->')
if footer_start == -1:
    footer_start = content.find('</div>\n\n<div class="toast-container"')

footer = content[footer_start:]

# remove script block
js_start = footer.find('<script>')
js_end = footer.find('</script>') + len('</script>')
footer = footer[:js_start] + '<script>\nfunction showToast(m,t){}\n</script>\n' + footer[js_end:]

settings_content = """
    <div class="page-header">
      <h1>⚙️ Konfigurasi Sistem</h1>
      <p>Pengaturan global aplikasi, integrasi pihak ketiga, dan bot notifikasi.</p>
    </div>

    @if(session('success'))
    <div style="background:rgba(56,189,130,0.1); border:1px solid var(--accent); color:var(--accent-l); padding:16px 20px; border-radius:12px; margin-bottom:24px; font-weight:600; display:flex; align-items:center; gap:12px;">
      <span>✅</span> {{ session('success') }}
    </div>
    @endif

    <div class="card" style="background:var(--bg-card); border:1px solid var(--border); border-radius:var(--radius); max-width:700px; padding:32px;">
      <div style="margin-bottom:24px; padding-bottom:16px; border-bottom:1px solid var(--border);">
        <h3 style="font-size:18px; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
          <span style="color:#0088cc; font-size:24px;">💬</span> Integrasi Telegram Bot
        </h3>
        <p style="font-size:13px; color:var(--text-2); line-height:1.6;">
          Masukkan kredensial Telegram Bot Anda di bawah ini. Sistem akan otomatis mengirimkan pesan peringatan ke Chat ID tujuan setiap kali ada data <strong>Norma Rawat</strong> yang disimpan/diimpor dengan persentase realisasi <strong>Over Normal (&gt; 105%)</strong>.
        </p>
      </div>

      <form action="{{ route('settings.store') }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom:20px;">
          <label for="telegram_receiver_name" style="margin-bottom:8px; display:block; font-size:12px; font-weight:600; color:var(--text-2); text-transform:uppercase;">Nama Penerima</label>
          <input type="text" id="telegram_receiver_name" name="telegram_receiver_name" value="{{ $settings['telegram_receiver_name'] ?? '' }}" placeholder="Contoh: Bpk. Budi (Kepala Kebun)" style="width:100%; background:rgba(255,255,255,0.06); border:1px solid var(--border); border-radius:10px; padding:10px 14px; color:var(--text-1); outline:none;" />
          <span style="font-size:11px; color:var(--text-3); margin-top:6px; display:block;">Nama orang yang akan disapa oleh bot.</span>
        </div>

        <div class="form-group" style="margin-bottom:32px;">
          <label for="telegram_chat_id" style="margin-bottom:8px; display:block; font-size:12px; font-weight:600; color:var(--text-2); text-transform:uppercase;">ID Telegram (Chat ID)</label>
          <input type="text" id="telegram_chat_id" name="telegram_chat_id" value="{{ $settings['telegram_chat_id'] ?? '' }}" placeholder="Contoh: 123456789 atau -1001234567890 (Grup)" style="width:100%; background:rgba(255,255,255,0.06); border:1px solid var(--border); border-radius:10px; padding:10px 14px; color:var(--text-1); outline:none;" />
          <span style="font-size:11px; color:var(--text-3); margin-top:6px; display:block;">ID pengguna, grup, atau channel yang akan menerima notifikasi. Gunakan <a href="https://t.me/userinfobot" target="_blank" style="color:var(--accent);">@userinfobot</a> untuk mengetahui ID Anda.</span>
        </div>
        
        <div class="form-group" style="margin-bottom:20px;">
          <label for="telegram_bot_token" style="margin-bottom:8px; display:block; font-size:12px; font-weight:600; color:var(--text-2); text-transform:uppercase;">Token Bot Telegram (opsional)</label>
          <input type="text" id="telegram_bot_token" name="telegram_bot_token" value="{{ $settings['telegram_bot_token'] ?? '' }}" placeholder="Biarkan kosong jika sudah diatur oleh admin" style="width:100%; background:rgba(255,255,255,0.06); border:1px solid var(--border); border-radius:10px; padding:10px 14px; color:var(--text-1); outline:none;" />
          <span style="font-size:11px; color:var(--text-3); margin-top:6px; display:block;">Dapatkan dari <a href="https://t.me/BotFather" target="_blank" style="color:var(--accent);">@BotFather</a> di Telegram.</span>
        </div>

        <div style="display:flex; justify-content:flex-end;">
          <button type="submit" style="background:linear-gradient(135deg,var(--accent),var(--accent-d)); color:#fff; border:none; border-radius:10px; padding:12px 24px; font-weight:600; cursor:pointer;">💾 Simpan Konfigurasi</button>
        </div>
      </form>
    </div>
"""

new_file = header + '\n' + settings_content + '\n' + footer
new_file = new_file.replace('Home &rsaquo; <span>Master Data Norma</span>', 'Home &rsaquo; <span>Konfigurasi</span>')

with open(settings_path, 'w', encoding='utf-8') as f:
    f.write(new_file)

print("Done")
