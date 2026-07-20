<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Master – Monitoring Anggaran Perkebunan Sawit</title>
  <meta name="description" content="Halaman admin profesional untuk monitoring dan manajemen anggaran norma kerja perkebunan kelapa sawit. CRUD, import, dan export data Excel." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg-deep: #0a0f1a;
      --bg-card: rgba(15,25,45,0.85);
      --bg-glass: rgba(20,35,65,0.60);
      --border: rgba(56,189,130,0.18);
      --border-h: rgba(56,189,130,0.45);
      --accent: #38bd82;
      --accent-d: #25a06a;
      --accent-l: #5ee8a8;
      --text-1: #e8f5ef;
      --text-2: #8ab8a0;
      --text-3: #4d7a62;
      --danger: #ff5c6a;
      --warning: #ffb347;
      --info: #4fc3f7;
      --purple: #a78bfa;
      --radius: 14px;
      --shadow: 0 8px 32px rgba(0,0,0,0.45);
    }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg-deep);
      color: var(--text-1);
      min-height: 100vh;
      background-image:
        radial-gradient(ellipse 80% 60% at 20% -10%, rgba(56,189,130,0.12) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 80% 110%, rgba(79,195,247,0.07) 0%, transparent 60%);
    }
    /* SIDEBAR */
    .sidebar {
      position: fixed; left:0; top:0; bottom:0; width:260px;
      background: var(--bg-card);
      border-right: 1px solid var(--border);
      backdrop-filter: blur(20px);
      display:flex; flex-direction:column;
      z-index:100;
    }
    .sidebar-logo { padding:28px 24px 20px; border-bottom:1px solid var(--border); }
    .logo-icon {
      width:44px; height:44px; border-radius:12px;
      background:linear-gradient(135deg,var(--accent),var(--accent-d));
      display:flex; align-items:center; justify-content:center;
      font-size:22px; margin-bottom:12px;
      box-shadow:0 4px 16px rgba(56,189,130,0.35);
    }
    .sidebar-logo h2 { font-size:15px; font-weight:700; color:var(--text-1); line-height:1.3; }
    .sidebar-logo p  { font-size:11px; color:var(--text-2); margin-top:3px; }
    .sidebar-nav { flex:1; padding:16px 12px; overflow-y:auto; }
    .nav-section-label {
      font-size:10px; font-weight:600; text-transform:uppercase;
      letter-spacing:1.2px; color:var(--text-3); padding:8px 12px 6px;
    }
    .nav-item {
      display:flex; align-items:center; gap:12px;
      padding:11px 14px; border-radius:10px; margin-bottom:2px;
      cursor:pointer; font-size:13.5px; font-weight:500;
      color:var(--text-2); transition:.2s; text-decoration:none;
    }
    .nav-item:hover { background:rgba(56,189,130,0.1); color:var(--text-1); }
    .nav-item.active {
      background:linear-gradient(90deg,rgba(56,189,130,0.22),rgba(56,189,130,0.05));
      color:var(--accent-l); border-left:3px solid var(--accent); padding-left:11px;
    }
    .nav-item .icon { width:18px; text-align:center; font-size:15px; }
    .sidebar-footer { padding:16px 24px; border-top:1px solid var(--border); font-size:11px; color:var(--text-3); }
    /* MAIN */
    .main-wrap { margin-left:260px; min-height:100vh; display:flex; flex-direction:column; }
    /* TOPBAR */
    .topbar {
      position:sticky; top:0; z-index:90;
      background:rgba(10,15,26,0.9); backdrop-filter:blur(16px);
      border-bottom:1px solid var(--border);
      padding:0 32px; height:64px;
      display:flex; align-items:center; justify-content:space-between;
    }
    .breadcrumb { display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-2); }
    .breadcrumb span { color:var(--accent); font-weight:600; }
    .topbar-right { display:flex; align-items:center; gap:12px; }
    .badge-dot { width:8px; height:8px; border-radius:50%; background:var(--accent); animation:pulse-dot 2s infinite; }
    @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }
    .avatar {
      width:36px; height:36px; border-radius:10px;
      background:linear-gradient(135deg,var(--accent),var(--accent-d));
      display:flex;align-items:center;justify-content:center;
      font-weight:700; font-size:14px; color:#fff; cursor:pointer;
    }
    /* CONTENT */
    .content { flex:1; padding:28px 32px; }
    .page-header { margin-bottom:24px; }
    .page-header h1 { font-size:26px; font-weight:800; color:var(--text-1); }
    .page-header p  { font-size:13px; color:var(--text-2); margin-top:4px; }
    /* STAT CARDS */
    .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
    .stat-card {
      background:var(--bg-card); border:1px solid var(--border);
      border-radius:var(--radius); padding:20px 22px;
      backdrop-filter:blur(12px); position:relative; overflow:hidden; transition:.25s;
    }
    .stat-card::before {
      content:''; position:absolute; top:0;left:0;right:0;
      height:3px; border-radius:var(--radius) var(--radius) 0 0;
    }
    .stat-card.green::before { background:linear-gradient(90deg,var(--accent),var(--accent-l)); }
    .stat-card.blue::before  { background:linear-gradient(90deg,var(--info),#81d4fa); }
    .stat-card.purple::before{ background:linear-gradient(90deg,var(--purple),#c4b5fd); }
    .stat-card.orange::before{ background:linear-gradient(90deg,var(--warning),#ffd580); }
    .stat-card:hover { border-color:var(--border-h); transform:translateY(-2px); box-shadow:var(--shadow); }
    .stat-card .label { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.9px; color:var(--text-3); }
    .stat-card .value { font-size:30px; font-weight:800; margin:8px 0 4px; }
    .stat-card.green .value { color:var(--accent-l); }
    .stat-card.blue .value  { color:var(--info); }
    .stat-card.purple .value{ color:var(--purple); }
    .stat-card.orange .value{ color:var(--warning); }
    .stat-card .sub { font-size:12px; color:var(--text-2); }
    .stat-card .icon { position:absolute; top:18px; right:18px; font-size:28px; opacity:.15; }
    /* TABLE CARD */
    .table-card {
      background:var(--bg-card); border:1px solid var(--border);
      border-radius:var(--radius); backdrop-filter:blur(16px); overflow:hidden;
    }
    /* TOOLBAR */
    .toolbar {
      padding:18px 22px; border-bottom:1px solid var(--border);
      display:flex; align-items:center; gap:12px; flex-wrap:wrap;
    }
    .toolbar-left { display:flex; align-items:center; gap:10px; flex:1; flex-wrap:wrap; }
    .toolbar-right { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
    .search-box { position:relative; width:280px; }
    .search-box input {
      width:100%; background:rgba(255,255,255,0.06); border:1px solid var(--border);
      border-radius:10px; padding:9px 12px 9px 38px;
      color:var(--text-1); font-size:13px; font-family:inherit; transition:.2s; outline:none;
    }
    .search-box input:focus { border-color:var(--border-h); background:rgba(56,189,130,0.06); }
    .search-box input::placeholder { color:var(--text-3); }
    .search-icon { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--text-3); font-size:14px; }
    .filter-select {
      background:rgba(255,255,255,0.06); border:1px solid var(--border);
      border-radius:10px; padding:9px 12px;
      color:var(--text-1); font-size:13px; font-family:inherit; outline:none; cursor:pointer; transition:.2s;
    }
    .filter-select:focus { border-color:var(--border-h); }
    .filter-select option { background:#0f1928; }
    .btn {
      display:inline-flex; align-items:center; gap:7px;
      padding:9px 18px; border-radius:10px; border:none;
      font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; transition:.2s; white-space:nowrap;
    }
    .btn-primary {
      background:linear-gradient(135deg,var(--accent),var(--accent-d));
      color:#fff; box-shadow:0 4px 14px rgba(56,189,130,0.3);
    }
    .btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(56,189,130,0.45); }
    .btn-outline { background:transparent; color:var(--text-2); border:1px solid var(--border); }
    .btn-outline:hover { border-color:var(--border-h); color:var(--text-1); background:rgba(56,189,130,0.06); }
    .btn-excel { background:rgba(33,115,70,0.2); color:#5ee8a8; border:1px solid rgba(56,189,130,0.3); }
    .btn-excel:hover { background:rgba(33,115,70,0.35); border-color:var(--accent); }
    .btn-import { background:rgba(79,195,247,0.12); color:var(--info); border:1px solid rgba(79,195,247,0.25); }
    .btn-import:hover { background:rgba(79,195,247,0.22); }
    .btn-danger-sm {
      background:rgba(255,92,106,0.1); color:var(--danger);
      border:1px solid rgba(255,92,106,0.2); padding:6px 12px; font-size:12px;
    }
    .btn-danger-sm:hover { background:rgba(255,92,106,0.22); }
    .btn-edit-sm {
      background:rgba(167,139,250,0.1); color:var(--purple);
      border:1px solid rgba(167,139,250,0.2); padding:6px 12px; font-size:12px;
    }
    .btn-edit-sm:hover { background:rgba(167,139,250,0.22); }
    /* TABLE */
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:13px; }
    thead th {
      background:rgba(10,15,26,0.6); padding:12px 16px; text-align:center;
      font-size:11px; font-weight:700; text-transform:uppercase;
      letter-spacing:.8px; color:var(--text-3); border-bottom:1px solid var(--border);
      white-space:nowrap;
    }
    thead th.left { text-align:left; }
    thead .th-group {
      background:rgba(56,189,130,0.06); font-size:11px; font-weight:700;
      color:var(--accent); padding:8px 16px; border-bottom:1px solid var(--border);
    }
    tbody tr { border-bottom:1px solid rgba(56,189,130,0.07); transition:.15s; }
    tbody tr:hover { background:rgba(56,189,130,0.05); }
    tbody tr:last-child { border-bottom:none; }
    td { padding:11px 16px; vertical-align:middle; text-align:center; color:var(--text-2); }
    td.left { text-align:left; }
    .badge-status {
      display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px;
      font-size:11px; font-weight:600;
      background:rgba(56,189,130,0.12); color:var(--accent-l); border:1px solid rgba(56,189,130,0.22);
      white-space:nowrap;
    }
    .badge-tbm { background:rgba(79,195,247,0.12); color:var(--info); border-color:rgba(79,195,247,0.22); }
    .badge-tm  { background:rgba(167,139,250,0.12); color:var(--purple); border-color:rgba(167,139,250,0.22); }
    .badge-tmtua { background:rgba(255,179,71,0.12); color:var(--warning); border-color:rgba(255,179,71,0.22); }
    .num-cell { color:var(--text-1); font-weight:600; font-variant-numeric:tabular-nums; }
    .num-cell.accent { color:var(--accent-l); }
    /* PAGINATION */
    .pagination-bar {
      padding:14px 22px; border-top:1px solid var(--border);
      display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;
    }
    .pagination-info { font-size:12px; color:var(--text-3); }
    .pagination-btns { display:flex; align-items:center; gap:6px; }
    .page-btn {
      width:32px; height:32px; border-radius:8px; border:1px solid var(--border);
      background:transparent; color:var(--text-2); font-size:13px;
      cursor:pointer; display:flex;align-items:center;justify-content:center;
      transition:.15s; font-family:inherit;
    }
    .page-btn:hover { border-color:var(--border-h); color:var(--text-1); }
    .page-btn.active { background:linear-gradient(135deg,var(--accent),var(--accent-d)); color:#fff; border-color:transparent; }
    .page-btn:disabled { opacity:.3; cursor:not-allowed; }
    /* MODAL */
    .modal-overlay {
      position:fixed; inset:0; z-index:1000; background:rgba(5,10,20,0.8);
      backdrop-filter:blur(8px); display:none; align-items:center; justify-content:center;
      animation:fadeIn .2s;
    }
    .modal-overlay.open { display:flex; }
    @keyframes fadeIn { from{opacity:0} to{opacity:1} }
    .modal {
      background:linear-gradient(145deg,#0f1e38,#0a1528);
      border:1px solid var(--border-h); border-radius:18px;
      width:min(92vw,780px); max-height:90vh; overflow-y:auto;
      box-shadow:0 24px 80px rgba(0,0,0,0.6); animation:slideUp .25s;
    }
    @keyframes slideUp { from{transform:translateY(24px);opacity:0} to{transform:translateY(0);opacity:1} }
    .modal-header {
      padding:22px 28px 18px; border-bottom:1px solid var(--border);
      display:flex; align-items:center; justify-content:space-between;
    }
    .modal-header h3 { font-size:18px; font-weight:700; }
    .modal-close {
      width:34px;height:34px;border-radius:9px;border:1px solid var(--border);
      background:transparent;color:var(--text-2);font-size:18px;
      cursor:pointer;display:flex;align-items:center;justify-content:center; transition:.15s;
    }
    .modal-close:hover { border-color:var(--danger);color:var(--danger); }
    .modal-body { padding:24px 28px; }
    .modal-footer { padding:16px 28px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:10px; }
    /* FORM */
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { font-size:12px; font-weight:600; color:var(--text-2); text-transform:uppercase; letter-spacing:.7px; }
    .form-group input, .form-group select {
      background:rgba(255,255,255,0.06); border:1px solid var(--border);
      border-radius:10px; padding:10px 14px;
      color:var(--text-1); font-size:13.5px; font-family:inherit; outline:none; transition:.2s;
    }
    .form-group input:focus, .form-group select:focus {
      border-color:var(--border-h); background:rgba(56,189,130,0.06);
      box-shadow:0 0 0 3px rgba(56,189,130,0.1);
    }
    .form-group select option { background:#0f1928; }
    .form-divider {
      grid-column:1/-1; padding:8px 0 4px;
      font-size:11px; font-weight:700; text-transform:uppercase;
      letter-spacing:1px; color:var(--text-3); border-bottom:1px solid var(--border);
    }
    /* TOAST */
    .toast-container { position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; }
    .toast {
      background:var(--bg-card); border:1px solid var(--border-h); border-radius:12px;
      padding:14px 20px; display:flex;align-items:center;gap:12px;
      font-size:13.5px; font-weight:500;
      box-shadow:0 8px 32px rgba(0,0,0,0.4); backdrop-filter:blur(12px);
      animation:slideIn .3s ease; min-width:260px; max-width:380px;
    }
    @keyframes slideIn { from{transform:translateX(60px);opacity:0} to{transform:translateX(0);opacity:1} }
    .toast.success .toast-icon { color:var(--accent); }
    .toast.error .toast-icon { color:var(--danger); }
    .toast.info .toast-icon { color:var(--info); }
    /* CONFIRM MODAL */
    .confirm-modal { background:linear-gradient(145deg,#1a0f1e,#120a1a); border-color:rgba(255,92,106,0.3); }
    .confirm-modal .modal-header h3 { color:var(--danger); }
    /* IMPORT */
    .import-zone {
      border:2px dashed var(--border); border-radius:14px; padding:32px;
      text-align:center; cursor:pointer; transition:.2s;
    }
    .import-zone:hover { border-color:var(--accent); background:rgba(56,189,130,0.04); }
    .import-zone.dragover { border-color:var(--accent-l); background:rgba(56,189,130,0.08); }
    .import-zone .zone-icon { font-size:40px; margin-bottom:12px; opacity:.6; }
    .import-zone p { font-size:14px; color:var(--text-2); }
    .import-zone span { font-size:12px; color:var(--text-3); margin-top:6px; display:block; }
    .progress-bar-wrap { background:rgba(255,255,255,0.07); border-radius:100px; height:6px; overflow:hidden; margin:12px 0; }
    .progress-bar { height:100%; border-radius:100px; background:linear-gradient(90deg,var(--accent),var(--accent-l)); transition:width .4s; }
    /* EMPTY */
    .empty-state { padding:60px 32px; text-align:center; }
    .empty-state .icon { font-size:48px; margin-bottom:16px; opacity:.4; }
    .empty-state h3 { font-size:17px; font-weight:600; color:var(--text-2); }
    .empty-state p  { font-size:13px; color:var(--text-3); margin-top:6px; }
    /* SCROLLBAR */
    ::-webkit-scrollbar { width:6px; height:6px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:rgba(56,189,130,0.2); border-radius:100px; }
    ::-webkit-scrollbar-thumb:hover { background:rgba(56,189,130,0.4); }
    @media(max-width:1100px) { .stats-grid { grid-template-columns:repeat(2,1fr); } }
    
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

  </style>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="sidebar-overlay" onclick="toggleSidebar()"></div>
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🌴</div>
    <h2>Anomali Sawit</h2>
    <p>Budget Monitoring System</p>
  </div>
      <nav class="sidebar-nav">
    <div class="nav-section-label">Navigasi</div>
    @if(auth()->user()->role != 'Asisten Afdeling')
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <span class="icon">📊</span> Dashboard Overview
    </a>
    @endif
    
    <a href="{{ route('master.index') }}" class="nav-item {{ request()->routeIs('master.index') ? 'active' : '' }}">
      <span class="icon">📋</span> Master Data Norma
    </a>
    <a href="{{ route('budget.index') }}" class="nav-item {{ request()->routeIs('budget.index') ? 'active' : '' }}">
      <span class="icon">💰</span> Master Budget
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
  </nav>
  <div class="sidebar-footer">v1.0.0 &nbsp;·&nbsp; © 2025 Anomali Sawit</div>
</aside>

<div class="main-wrap">
  <header class="topbar">
    <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>
    <div class="breadcrumb">Home &rsaquo; <span>Manajemen Pengguna</span></div>
    <div class="topbar-right">
      <div class="badge-dot"></div>
      <div style="font-size:12px;color:var(--text-2)">{{ Auth::user()->name ?? 'Admin' }}</div>
      <form action="{{ route('logout') }}" method="POST" style="margin:0">
        @csrf
        <button type="submit" class="avatar" style="border:none; cursor:pointer;" title="Logout">🚪</button>
      </form>
    </div>
  </header>

  <main class="content">

    <div class="page-header">
      <h1>👥 Manajemen Pengguna</h1>
      <p>Kelola data pengguna, akses login, dan penugasan peran (Role).</p>
    </div>

    @if(session('success'))
    <div style="background:rgba(56,189,130,0.1); border:1px solid var(--accent); color:var(--accent-l); padding:16px 20px; border-radius:12px; margin-bottom:24px; font-weight:600; display:flex; align-items:center; gap:12px;">
      <span>✅</span> {{ session('success') }}
    </div>
    @endif

    <div class="stats-grid" style="grid-template-columns:repeat(2,1fr);">
      <div class="stat-card blue">
        <span class="icon">💬</span>
        <div class="label">Total Pengguna</div>
        <div class="value" id="statTotal">{{ count($users) }}</div>
        <div class="sub">Total akun pengguna</div>
      </div>
      <div class="stat-card green">
        <span class="icon">🤖</span>
        <div class="label">Admin Aktif</div>
        <div class="value" style="font-size:24px; margin-top:10px;">{{ $users->where('role','Manajemen')->count() }}</div>
        <div class="sub">Akun manajemen / admin</div>
      </div>
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
              <th class="left">Nama Lengkap</th>
              <th class="left">Email Login</th>
              <th class="left">Role Akses</th>
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
          <h3 id="formModalTitle">➕ Tambah Pengguna</h3>
          <button class="modal-close" onclick="closeFormModal()">✕</button>
        </div>
        <div class="modal-body">
          <div class="form-group" style="margin-bottom:16px;">
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
          <h3>🗑️ Hapus Pengguna</h3>
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

</div>
<div class="toast-container" id="toastContainer"></div>

<script>
let userData = {!! isset($users) ? $users->toJson() : '[]' !!};
let filteredData = [];
let currentPage = 1;
const perPage = 10;
let editingId = null;
let deletingId = null;

function applyFilter() {
  const s = document.getElementById('searchInput').value.toLowerCase();
  filteredData = userData.filter(r => {
    return (r.name && r.name.toLowerCase().includes(s)) || (r.email && r.email.toLowerCase().includes(s)) || (r.role && r.role.toLowerCase().includes(s));
  });
  currentPage = 1;
  renderTable();
}

function renderTable() {
  const tbody = document.getElementById('tableBody');
  tbody.innerHTML = '';
  
  if(filteredData.length === 0) {
    tbody.innerHTML = '<tr><td colspan="3"><div class="empty-state"><div class="icon">📬</div><h3>Tidak ada pengguna</h3><p>Belum ada data pengguna.</p></div></td></tr>';
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
      </tr>
    `;
  });
  tbody.innerHTML = html;
  
  document.getElementById('paginationInfo').textContent = `Menampilkan ${start+1}-${Math.min(end, filteredData.length)} dari ${filteredData.length} pengguna`;
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
  document.getElementById('formModalTitle').textContent = '➕ Tambah Pengguna';
  document.getElementById('fName').value = '';
  document.getElementById('fEmail').value = ''; document.getElementById('fPassword').value = ''; document.getElementById('fRole').value = 'Asisten Afdeling';
  document.getElementById('formModal').classList.add('open');
}

function openEdit(id) {
  const row = userData.find(r => r.id === id);
  if(!row) return;
  editingId = id;
  document.getElementById('formModalTitle').textContent = '✏️ Edit Pengguna';
  document.getElementById('fName').value = row.name;
  document.getElementById('fEmail').value = row.email; document.getElementById('fPassword').value = ''; document.getElementById('fRole').value = row.role;
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
  const email = document.getElementById('fEmail').value.trim(); const password = document.getElementById('fPassword').value.trim(); const role = document.getElementById('fRole').value;
  if(!name || !email) return showToast('Nama dan Email wajib diisi!', 'error');
  if(!editingId && !password) return showToast('Password wajib diisi untuk user baru!', 'error');

  const payload = { name, email, role };
  if(password) payload.password = password;
  const url = editingId ? `/users/${editingId}` : '/users';
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

  fetch(`/users/${deletingId}`, {
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



// init
applyFilter();
</script>

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

</body>
</html>
