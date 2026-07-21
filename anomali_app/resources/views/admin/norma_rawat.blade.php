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
    
    .table-wrap th.sticky-col { position: sticky; left: 0; z-index: 12; background: rgba(10,15,26,1); border-right: 1px solid var(--border); }
    .table-wrap td.sticky-col { position: sticky; left: 0; z-index: 10; background: var(--bg-card); border-right: 1px solid var(--border); }
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
    .search-box { position:relative; width:200px; }
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
    
    .badge-success { background: rgba(34,197,94,0.15); color: #22c55e; border: 1px solid rgba(34,197,94,0.4); }
    .badge-danger { background: rgba(239,68,68,0.15); color: #ef4444; border: 1px solid rgba(239,68,68,0.4); }
    .badge-info { background: rgba(59,130,246,0.15); color: #3b82f6; border: 1px solid rgba(59,130,246,0.4); }
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
    <div class="breadcrumb">Home &rsaquo; <span>Data Norma Rawat</span></div>
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
      <h1>📋 Data Norma Rawat Kerja</h1>
      <p>Manajemen norma kerja per topografi untuk monitoring anggaran perkebunan kelapa sawit</p>
    </div>

    <div class="stats-grid">
      <div class="stat-card green">
        <span class="icon">📋</span>
        <div class="label">Total Data</div>
        <div class="value" id="statTotal">0</div>
        <div class="sub">Item kerja terdaftar</div>
      </div>
      <div class="stat-card blue">
        <span class="icon">🌱</span>
        <div class="label">Status Tanaman</div>
        <div class="value" id="statStatus">0</div>
        <div class="sub">Kategori umur tanaman</div>
      </div>
      <div class="stat-card purple">
        <span class="icon">📝</span>
        <div class="label">Item Kerja Unik</div>
        <div class="value" id="statItems">0</div>
        <div class="sub">Jenis pekerjaan berbeda</div>
      </div>
      @if(auth()->user()->role == 'Asisten Afdeling')
      <div class="stat-card orange" style="cursor:pointer" onclick="filterBelumKlarifikasi()">
        <span class="icon">⚠️</span>
        <div class="label">Belum di Klarifikasi</div>
        <div class="value" style="font-size:30px; margin:8px 0 4px;" id="statKlarifikasi">0</div>
        <div class="sub">Status Over Norma</div>
      </div>
      @else
      <div class="stat-card orange">
        <span class="icon">📊</span>
        <div class="label">Terakhir Update</div>
        <div class="value" style="font-size:16px;margin-top:14px" id="statDate">–</div>
        <div class="sub">Waktu sinkronisasi data</div>
      </div>
      @endif
    </div>

    <div class="table-card">
      <div class="toolbar">
        <div class="toolbar-left">
          <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Cari data..." oninput="applyFilter()" />
          </div>
          <select class="filter-select" id="filterStatus" style="width: 130px;" onchange="applyFilter()">
            <option value="">Status</option>
          </select>
          <select class="filter-select" id="filterRows" onchange="applyFilter()">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="0">Semua</option>
          </select>
        </div>
        <div class="toolbar-right">
          <button class="btn btn-import" onclick="openImport()">📥 Impor</button>
          <a href="{{ route('rawat.export') }}" class="btn btn-excel" style="text-decoration:none">📥 Export</a>
          <button class="btn btn-primary" onclick="openAdd()">＋ Tambah</button>
        </div>
      </div>

      <div class="table-wrap">
        <table id="masterTable">
          <thead><tr>
              <th style="min-width:50px" class="sticky-col">No</th>
              <th style="min-width:100px">SITECODE</th>
              <th style="min-width:100px">TDATE</th>
              <th style="min-width:100px">AFDCODE</th>
              <th style="min-width:100px">LOCATION</th>
              <th style="min-width:120px">PLANTINGDATE</th>
              <th style="min-width:100px">JOBTYPE</th>
              <th style="min-width:150px">JOBTYPEDESC</th>
              <th style="min-width:80px">TYPE</th>
              <th style="min-width:120px">JOBGROUPCODE</th>
              <th style="min-width:100px">JOBCODE</th>
              <th style="min-width:150px">JOBDESC</th>
              <th style="min-width:80px">UOM</th>
              <th style="min-width:80px">UMP</th>
              <th style="min-width:120px">HECTPLANTED</th>
              <th style="min-width:120px">MANDAYS_HI</th>
              <th style="min-width:120px">MANDAYS_SHI</th>
              <th style="min-width:120px">HK_PER_HA_HI</th>
              <th style="min-width:120px">HK_PER_HA_SHI</th>
              <th style="min-width:120px">PRODUKSI_HI</th>
              <th style="min-width:120px">PRODUKSI_SHI</th>
              <th style="min-width:100px">COST_HI</th>
              <th style="min-width:100px">COST_SHI</th>
              <th style="min-width:100px">PREMI_HI</th>
              <th style="min-width:100px">PREMI_SHI</th>
              <th style="min-width:120px">ADDCOST_HI</th>
              <th style="min-width:120px">ADDCOST_SHI</th>
              <th style="min-width:150px">STATUS</th>
              <th style="min-width:200px">KLARIFIKASI</th>
              <th style="min-width:110px">Aksi</th>
</tr></thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>

      <div class="pagination-bar">
        <div class="pagination-info" id="paginationInfo">Menampilkan 0 data</div>
        <div class="pagination-btns" id="paginationBtns"></div>
      </div>
    </div>
  </main>
</div>

<!-- MODAL: ADD/EDIT -->
<div class="modal-overlay" id="formModal">
  <div class="modal">
    <div class="modal-header">
      <h3 id="formModalTitle">Tambah Data Norma</h3>
      <button class="modal-close" onclick="closeFormModal()">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>SITECODE</label><input type="text" id="f_sitecode"></div>
        <div class="form-group"><label>TDATE</label><input type="date" id="f_tdate"></div>
        <div class="form-group"><label>AFDCODE</label><input type="text" id="f_afdcode"></div>
        <div class="form-group"><label>LOCATION</label><input type="text" id="f_location"></div>
        <div class="form-group"><label>PLANTINGDATE</label><input type="number" id="f_plantingdate"></div>
        <div class="form-group"><label>JOBTYPE</label><input type="text" id="f_jobtype"></div>
        <div class="form-group"><label>JOBTYPEDESC</label><input type="text" id="f_jobtypedesc"></div>
        <div class="form-group"><label>TYPE</label><input type="text" id="f_type"></div>
        <div class="form-group"><label>JOBGROUPCODE</label><input type="text" id="f_jobgroupcode"></div>
        <div class="form-group"><label>JOBCODE</label><input type="text" id="f_jobcode"></div>
        <div class="form-group"><label>JOBDESC</label>
          <select id="f_jobdesc">
            <option value="">-- Pilih Item Kerja --</option>
            @foreach($masterItems as $item)
              <option value="{{ $item }}">{{ $item }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group"><label>UOM</label><input type="text" id="f_uom"></div>
        
        <div class="form-divider">Data Angka</div>
        <div class="form-group"><label>UMP</label><input type="number" step="0.0001" id="f_ump"></div>
        <div class="form-group"><label>HECTPLANTED</label><input type="number" step="0.0001" id="f_hectplanted"></div>
        <div class="form-group"><label>MANDAYS_HI</label><input type="number" step="0.0001" id="f_mandays_hi"></div>
        <div class="form-group"><label>MANDAYS_SHI</label><input type="number" step="0.0001" id="f_mandays_shi"></div>
        <div class="form-group"><label>HK_PER_HA_HI</label><input type="number" step="0.0001" id="f_hk_per_ha_hi"></div>
        <div class="form-group"><label>HK_PER_HA_SHI</label><input type="number" step="0.0001" id="f_hk_per_ha_shi"></div>
        <div class="form-group"><label>PRODUKSI_HI</label><input type="number" step="0.0001" id="f_produksi_hi"></div>
        <div class="form-group"><label>PRODUKSI_SHI</label><input type="number" step="0.0001" id="f_produksi_shi"></div>
        <div class="form-group"><label>COST_HI</label><input type="number" step="0.0001" id="f_cost_hi"></div>
        <div class="form-group"><label>COST_SHI</label><input type="number" step="0.0001" id="f_cost_shi"></div>
        <div class="form-group"><label>PREMI_HI</label><input type="number" step="0.0001" id="f_premi_hi"></div>
        <div class="form-group"><label>PREMI_SHI</label><input type="number" step="0.0001" id="f_premi_shi"></div>
        <div class="form-group"><label>ADDCOST_HI</label><input type="number" step="0.0001" id="f_addcost_hi"></div>
        <div class="form-group"><label>ADDCOST_SHI</label><input type="number" step="0.0001" id="f_addcost_shi"></div>
</div></div><div class="modal-footer">
      <button class="btn btn-outline" onclick="closeFormModal()">Batal</button>
      <button class="btn btn-primary" onclick="submitForm()" id="formSubmitBtn">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL: DELETE -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal confirm-modal" style="max-width:440px">
    <div class="modal-header">
      <h3>🗑️ Hapus Data</h3>
      <button class="modal-close" onclick="closeDeleteModal()">✕</button>
    </div>
    <div class="modal-body">
      <p style="color:var(--text-2);font-size:14px;line-height:1.8">
        Apakah Anda yakin ingin menghapus item ini?<br/>
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

<!-- MODAL: IMPORT -->
<div class="modal-overlay" id="importModal">
  <div class="modal" style="max-width:520px">
    <div class="modal-header">
      <h3>📥 Import Data dari Excel</h3>
      <button class="modal-close" onclick="closeImportModal()">✕</button>
    </div>
    <form action="{{ route('rawat.import') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
        <div style="margin-bottom:15px">
          <input type="file" id="importFile" name="file" accept=".xlsx,.xls,.csv" required style="width:100%; padding:10px; border:1px dashed var(--border); border-radius:8px;" />
        </div>
        
        <div style="margin-top:16px;padding:14px;background:rgba(56,189,130,0.06);border-radius:10px;border:1px solid var(--border)">
          <p style="font-size:12px;color:var(--text-2);line-height:1.9">
            <strong style="color:var(--accent)">Format Excel yang didukung:</strong><br/>
            Sama persis dengan format saat Anda menekan tombol Export Excel.<br/>
            <em style="color:var(--text-3)">Baris header akan dilewati otomatis.</em>
          </p>
        </div>
        <div style="margin-top:12px;display:flex;align-items:center;gap:10px">
          <input type="checkbox" id="importReplace" name="replace" value="true" style="accent-color:var(--accent);width:16px;height:16px" />
          <label for="importReplace" style="font-size:13px;color:var(--text-2);cursor:pointer">
            Ganti semua data yang ada (Truncate tabel)
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="closeImportModal()">Batal</button>
        <button type="submit" class="btn btn-primary">📥 Mulai Import</button>
      </div>
    </form>
  </div>
</div>


<!-- MODAL: DETAIL -->
<div class="modal-overlay" id="detailModal">
  <div class="modal" style="max-width:550px">
    <div class="modal-header">
      <h3 id="detailTitle">👁️ Detail Fluktuasi Norma</h3>
      <button class="modal-close" onclick="closeDetailModal()">✕</button>
    </div>
    <div class="modal-body" style="padding-top:10px;">
      <div id="detailContent"></div>
    </div>
  </div>
</div>

</div>

<!-- MODAL: KLARIFIKASI -->
<div class="modal-overlay" id="klarifikasiModal">
  <div class="modal" style="max-width:500px">
    <div class="modal-header">
      <h3>💬 Klarifikasi Over Norma</h3>
      <button class="modal-close" onclick="closeKlarifikasiModal()">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-group full">
        <label>Keterangan / Klarifikasi</label>
        <textarea id="f_klarifikasi" rows="5" style="background:rgba(255,255,255,0.06); border:1px solid var(--border); border-radius:10px; padding:10px 14px; color:var(--text-1); font-size:13.5px; font-family:inherit; outline:none; transition:.2s; width:100%; resize:vertical;"></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeKlarifikasiModal()">Batal</button>
      <button class="btn btn-primary" onclick="submitKlarifikasi()" id="klarifikasiSubmitBtn">💾 Simpan</button>
    </div>
  </div>
</div>

<div class="toast-container" id="toastContainer"></div>

<script>

// ========== DATA STORE ==========

let masterData = {!! $data->toJson() !!};
let masterNormaData = {!! $masterNormaData->toJson() !!};


let filteredData = [];
let currentPage = 1;
let editingId = null;
let deleteTargetId = null;
let pendingImportData = [];

document.addEventListener('DOMContentLoaded', () => {
  updateFilterDropdown();
  applyFilter();
  updateStats();
});

function saveToStorage() {
  updateStats();
}


function calcStatus(r) {
  let realisasi = 0;
  if(r.produksi_shi && r.produksi_shi > 0) {
    realisasi = r.mandays_shi / r.produksi_shi;
  }
  const master = masterNormaData.find(m => m.item_kerja === r.jobdesc);
  const standar = master && master.datar_norma ? parseFloat(master.datar_norma) : 0;
  
  let fluktuasi = 0;
  if (standar > 0) {
    fluktuasi = ((realisasi - standar) / standar) * 100;
  }
  
  let statusText = 'Normal';
  let badgeCls = 'badge-success';
  if (fluktuasi > 100) {
    statusText = 'Over Norma';
    badgeCls = 'badge-danger';
  } else if (fluktuasi < 0) {
    statusText = 'Di Bawah Norma';
    badgeCls = 'badge-info';
  }
  if (!standar) {
    statusText = 'N/A';
    badgeCls = 'badge-tmtua';
  }
  return { statusText, badgeCls, fluktuasi, realisasi, standar };
}

// ========== FILTER ==========
function applyFilter() {
  const q = document.getElementById('searchInput').value.toLowerCase().trim();
  const s = document.getElementById('filterStatus').value;
  filteredData = masterData.filter(r => {
    const st = calcStatus(r);
    const matchQ = !q || (r.jobdesc||'').toLowerCase().includes(q) || (r.sitecode||'').toLowerCase().includes(q) || (r.location||'').toLowerCase().includes(q);
    const matchS = !s || st.statusText === s;
    
    let matchKlarifikasi = true;
    if (typeof isFilterBelumKlarifikasi !== 'undefined' && isFilterBelumKlarifikasi) {
        matchKlarifikasi = (st.fluktuasi > 100 && !r.klarifikasi);
    }
    
    return matchQ && matchS && matchKlarifikasi;
  });
  currentPage = 1;
  renderTable();
  updateStats();
}

function updateFilterDropdown() {
  const sel = document.getElementById('filterStatus');
  const cur = sel.value;
  const statuses = ['Over Norma', 'Normal', 'Di Bawah Norma', 'N/A'];
  sel.innerHTML = '<option value="">Status</option>' +
    statuses.map(s => `<option value="${s}" ${s===cur?'selected':''}>${s}</option>`).join('');
}

// ========== RENDER ==========
function renderTable() {
  const perPage = parseInt(document.getElementById('filterRows').value)||0;
  const total = filteredData.length;
  const totalPages = perPage ? Math.ceil(total/perPage) : 1;
  const start = perPage ? (currentPage-1)*perPage : 0;
  const end   = perPage ? Math.min(start+perPage, total) : total;
  const page  = filteredData.slice(start, end);
  const tbody = document.getElementById('tableBody');

  if (!page.length) {
    tbody.innerHTML = `<tr><td colspan="12"><div class="empty-state">
      <div class="icon">📭</div><h3>Tidak ada data</h3>
      <p>Coba ubah filter atau tambahkan data baru</p>
    </div></td></tr>`;
    document.getElementById('paginationInfo').textContent = 'Tidak ada data';
    document.getElementById('paginationBtns').innerHTML = '';
    return;
  }

  const fmt = v => (v===null||v===undefined||v==='') ? '<span style="color:var(--text-3)">–</span>'
    : `<span class="num-cell">${!isNaN(Number(v)) ? numFmt(Number(v)) : v}</span>`;
  const fmtA = v => (v===null||v===undefined||v==='') ? '<span style="color:var(--text-3)">–</span>'
    : `<span class="num-cell accent">${!isNaN(Number(v)) ? numFmt(Number(v)) : v}</span>`;

        tbody.innerHTML = page.map((r, i) => {
    
    const st = calcStatus(r);
    const statusCol = `<span class="badge-status ${st.badgeCls}">${st.statusText}</span><br><small style="color:var(--text-3);font-size:10px">${st.fluktuasi.toFixed(1)}%</small>`;

    return `<tr>
      <td class="sticky-col" style="text-align:center">${start + i + 1}</td>
      <td>${r.sitecode||'-'}</td>
      <td style="white-space:nowrap">${r.tdate||'-'}</td>
      <td>${r.afdcode||'-'}</td>
      <td>${r.location||'-'}</td>
      <td>${r.plantingdate||'-'}</td>
      <td>${r.jobtype||'-'}</td>
      <td>${r.jobtypedesc||'-'}</td>
      <td>${r.type||'-'}</td>
      <td>${r.jobgroupcode||'-'}</td>
      <td>${r.jobcode||'-'}</td>
      <td>${r.jobdesc||'-'}</td>
      <td>${r.uom||'-'}</td>
      <td>${fmt(r.ump)}</td>
      <td>${fmt(r.hectplanted)}</td>
      <td>${fmt(r.mandays_hi)}</td>
      <td>${fmt(r.mandays_shi)}</td>
      <td>${fmt(r.hk_per_ha_hi)}</td>
      <td>${fmt(r.hk_per_ha_shi)}</td>
      <td>${fmt(r.produksi_hi)}</td>
      <td>${fmt(r.produksi_shi)}</td>
      <td>${fmt(r.cost_hi)}</td>
      <td>${fmt(r.cost_shi)}</td>
      <td>${fmt(r.premi_hi)}</td>
      <td>${fmt(r.premi_shi)}</td>
      <td>${fmt(r.addcost_hi)}</td>
      <td>${fmt(r.addcost_shi)}</td>
      <td>${statusCol}</td>
      <td style="white-space:normal;text-align:left;font-size:12px;line-height:1.4">${r.klarifikasi || '<em style="color:var(--text-3)">Belum ada klarifikasi</em>'}</td>
      <td><div style="display:flex;gap:6px;justify-content:center">
        <button class="btn btn-primary" style="padding:5px 8px;font-size:11px" onclick="openDetail(${r.id})" title="Lihat Detail">👁️ Detail</button>
        @if(auth()->user()->role == 'Asisten Afdeling')
          ${st.fluktuasi > 100 ? `<button class="btn" style="background:rgba(255,179,71,0.12); color:var(--warning); border:1px solid rgba(255,179,71,0.22); padding:6px 12px; font-size:12px;" onclick="openKlarifikasi(${r.id})" title="Klarifikasi">💬</button>` : ''}
        @else
          <button class="btn btn-edit-sm" onclick="openEdit(${r.id})" title="Edit">✏️</button>
          <button class="btn btn-danger-sm" onclick="openDelete(${r.id})" title="Hapus">🗑️</button>
        @endif
      </div></td>
    </tr>`;
  }).join('');

  document.getElementById('paginationInfo').textContent =
    `Menampilkan ${start+1}–${end} dari ${total} data`;

  const pb = document.getElementById('paginationBtns');
  if (!perPage || totalPages<=1) { pb.innerHTML=''; return; }
  let btns = `<button class="page-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}>‹</button>`;
  pageRange(currentPage, totalPages).forEach(p => {
    btns += p==='...'
      ? `<button class="page-btn" disabled>…</button>`
      : `<button class="page-btn ${p===currentPage?'active':''}" onclick="goPage(${p})">${p}</button>`;
  });
  btns += `<button class="page-btn" onclick="goPage(${currentPage+1})" ${currentPage===totalPages?'disabled':''}>›</button>`;
  pb.innerHTML = btns;
}

function numFmt(v) {
  const n = Number(v);
  if (isNaN(n)) return v;
  if (Number.isInteger(n)) return n.toString();
  return n.toFixed(2);
}
function pageRange(cur, total) {
  if (total<=7) return Array.from({length:total},(_,i)=>i+1);
  const p=[];
  if(cur<=4){for(let i=1;i<=5;i++)p.push(i);p.push('...');p.push(total);}
  else if(cur>=total-3){p.push(1);p.push('...');for(let i=total-4;i<=total;i++)p.push(i);}
  else{p.push(1);p.push('...');for(let i=cur-1;i<=cur+1;i++)p.push(i);p.push('...');p.push(total);}
  return p;
}
function goPage(p) {
  const perPage = parseInt(document.getElementById('filterRows').value)||0;
  const total = filteredData.length;
  const totalPages = perPage ? Math.ceil(total/perPage) : 1;
  if(p<1||p>totalPages) return;
  currentPage=p; renderTable();
}

function updateStats() {
  document.getElementById('statTotal').textContent = masterData.length;
  document.getElementById('statStatus').textContent = new Set(masterData.map(r=>r.jobtype).filter(Boolean)).size;
  document.getElementById('statItems').textContent = new Set(masterData.map(r=>r.jobdesc).filter(Boolean)).size;
  
  const elKlarifikasi = document.getElementById('statKlarifikasi');
  if(elKlarifikasi) {
    const countBelumKlarifikasi = masterData.filter(r => {
      const st = calcStatus(r);
      return st.fluktuasi > 100 && !r.klarifikasi;
    }).length;
    elKlarifikasi.textContent = countBelumKlarifikasi;
  }
}

let isFilterBelumKlarifikasi = false;
function filterBelumKlarifikasi() {
  isFilterBelumKlarifikasi = !isFilterBelumKlarifikasi;
  applyFilter();
}


function closeDetailModal() {
  document.getElementById('detailModal').classList.remove('open');
}

function openDetail(id) {
  const r = masterData.find(x => x.id === id);
  if(!r) return;
  
  let realisasi = 0;
  if(r.produksi_shi && r.produksi_shi > 0) {
    realisasi = r.mandays_shi / r.produksi_shi;
  }
  
  const master = masterNormaData.find(m => m.item_kerja === r.jobdesc);
  const standar = master && master.datar_norma ? parseFloat(master.datar_norma) : 0;
  
  let fluktuasi = 0;
  if (standar > 0) {
    fluktuasi = ((realisasi - standar) / standar) * 100;
  }
  
  let statusText = 'Normal';
  let badgeCls = 'badge-success';
  if (fluktuasi > 100) {
    statusText = 'Over Norma';
    badgeCls = 'badge-danger';
  } else if (fluktuasi < 0) {
    statusText = 'Di Bawah Norma';
    badgeCls = 'badge-info';
  }
  if (!standar) {
      statusText = 'N/A';
      badgeCls = 'badge-tmtua';
  }
  
  const content = `
    <div style="background:var(--bg-deep); padding:16px; border-radius:12px; border:1px solid var(--border); margin-bottom:16px;">
      <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
        <span style="color:var(--text-3); font-size:12px;">JOBDESC</span>
        <strong style="color:var(--text-1)">${r.jobdesc || '-'}</strong>
      </div>
      <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
        <span style="color:var(--text-3); font-size:12px;">MANDAYS_SHI</span>
        <strong style="color:var(--text-1)">${numFmt(r.mandays_shi || 0)}</strong>
      </div>
      <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
        <span style="color:var(--text-3); font-size:12px;">PRODUKSI_SHI</span>
        <strong style="color:var(--text-1)">${numFmt(r.produksi_shi || 0)}</strong>
      </div>
    </div>
    
    <div style="background:var(--bg-deep); padding:16px; border-radius:12px; border:1px solid var(--border); margin-bottom:16px;">
      <h4 style="font-size:13px; margin-bottom:10px; color:var(--text-2);">Rumus Perhitungan:</h4>
      <p style="font-size:13px; color:var(--text-1); margin-bottom:8px;">
        <strong>Realisasi:</strong> MANDAYS_SHI / PRODUKSI_SHI<br>
        = ${numFmt(r.mandays_shi || 0)} / ${numFmt(r.produksi_shi || 0)} <br>
        = <span style="color:var(--accent-l)">${realisasi.toFixed(2)}</span>
      </p>
      <p style="font-size:13px; color:var(--text-1); margin-bottom:8px;">
        <strong>Norma Standar (Master Datar):</strong><br>
        = <span style="color:var(--info)">${standar.toFixed(2)}</span>
      </p>
      <hr style="border-color:var(--border); margin:12px 0;">
      <p style="font-size:13px; color:var(--text-1); line-height:1.6">
        <strong>Fluktuasi:</strong> ((Realisasi - Standar) / Standar) * 100% <br>
        = ((${realisasi.toFixed(2)} - ${standar.toFixed(2)}) / ${standar.toFixed(2)}) * 100% <br>
        = <strong>${fluktuasi.toFixed(2)}%</strong>
      </p>
    </div>
    
    <div style="text-align:center; padding:12px;">
      <div style="font-size:12px; color:var(--text-3); margin-bottom:6px;">KESIMPULAN STATUS</div>
      <span class="badge-status ${badgeCls}" style="font-size:16px; padding:6px 16px;">${statusText}</span>
    </div>
  `;
  document.getElementById('detailContent').innerHTML = content;
  document.getElementById('detailModal').classList.add('open');
}

// ========== CRUD: ADD/EDIT ==========

function openAdd() {
  editingId=null;
  document.getElementById('formModalTitle').textContent='➕ Tambah Data Norma';
  document.getElementById('formSubmitBtn').textContent='💾 Simpan';
  
  const fields = [
    'f_sitecode','f_tdate','f_afdcode','f_location','f_plantingdate',
    'f_jobtype','f_jobtypedesc','f_type','f_jobgroupcode','f_jobcode',
    'f_jobdesc','f_uom','f_ump','f_hectplanted','f_mandays_hi',
    'f_mandays_shi','f_hk_per_ha_hi','f_hk_per_ha_shi','f_produksi_hi',
    'f_produksi_shi','f_cost_hi','f_cost_shi','f_premi_hi','f_premi_shi',
    'f_addcost_hi','f_addcost_shi'
  ];
  
  fields.forEach(id=>{
    const el=document.getElementById(id);
    if(el) el.value='';
  });
  
  document.getElementById('formModal').classList.add('open');
}


function openEdit(id) {
  const row = masterData.find(r=>r.id===id);
  if(!row) return;
  editingId=id;
  document.getElementById('formModalTitle').textContent='✏️ Edit Data Norma';
  document.getElementById('formSubmitBtn').textContent='💾 Update';
  
  document.getElementById('f_sitecode').value = row.sitecode||'';
  document.getElementById('f_tdate').value = row.tdate||'';
  document.getElementById('f_afdcode').value = row.afdcode||'';
  document.getElementById('f_location').value = row.location||'';
  document.getElementById('f_plantingdate').value = row.plantingdate||'';
  document.getElementById('f_jobtype').value = row.jobtype||'';
  document.getElementById('f_jobtypedesc').value = row.jobtypedesc||'';
  document.getElementById('f_type').value = row.type||'';
  document.getElementById('f_jobgroupcode').value = row.jobgroupcode||'';
  document.getElementById('f_jobcode').value = row.jobcode||'';
  document.getElementById('f_jobdesc').value = row.jobdesc||'';
  document.getElementById('f_uom').value = row.uom||'';
  document.getElementById('f_ump').value = row.ump??'';
  document.getElementById('f_hectplanted').value = row.hectplanted??'';
  document.getElementById('f_mandays_hi').value = row.mandays_hi??'';
  document.getElementById('f_mandays_shi').value = row.mandays_shi??'';
  document.getElementById('f_hk_per_ha_hi').value = row.hk_per_ha_hi??'';
  document.getElementById('f_hk_per_ha_shi').value = row.hk_per_ha_shi??'';
  document.getElementById('f_produksi_hi').value = row.produksi_hi??'';
  document.getElementById('f_produksi_shi').value = row.produksi_shi??'';
  document.getElementById('f_cost_hi').value = row.cost_hi??'';
  document.getElementById('f_cost_shi').value = row.cost_shi??'';
  document.getElementById('f_premi_hi').value = row.premi_hi??'';
  document.getElementById('f_premi_shi').value = row.premi_shi??'';
  document.getElementById('f_addcost_hi').value = row.addcost_hi??'';
  document.getElementById('f_addcost_shi').value = row.addcost_shi??'';
  
  document.getElementById('formModal').classList.add('open');
}


function closeFormModal() {
  document.getElementById('formModal').classList.remove('open');
  editingId=null;
}



async function submitForm() {
  const sitecode = document.getElementById('f_sitecode').value.trim();
  const location = document.getElementById('f_location').value.trim();
  if(!sitecode) { showToast('error','SITECODE wajib diisi!'); return; }
  
  const parseFloatSafe = (val) => {
     const p = parseFloat(val);
     return isNaN(p) ? null : p;
  };

  const obj = {
    sitecode: sitecode,
    tdate: document.getElementById('f_tdate').value||null,
    afdcode: document.getElementById('f_afdcode').value,
    location: location,
    plantingdate: parseInt(document.getElementById('f_plantingdate').value)||null,
    jobtype: document.getElementById('f_jobtype').value,
    jobtypedesc: document.getElementById('f_jobtypedesc').value,
    type: document.getElementById('f_type').value,
    jobgroupcode: document.getElementById('f_jobgroupcode').value,
    jobcode: document.getElementById('f_jobcode').value,
    jobdesc: document.getElementById('f_jobdesc').value,
    uom: document.getElementById('f_uom').value,
    ump: parseFloatSafe(document.getElementById('f_ump').value),
    hectplanted: parseFloatSafe(document.getElementById('f_hectplanted').value),
    mandays_hi: parseFloatSafe(document.getElementById('f_mandays_hi').value),
    mandays_shi: parseFloatSafe(document.getElementById('f_mandays_shi').value),
    hk_per_ha_hi: parseFloatSafe(document.getElementById('f_hk_per_ha_hi').value),
    hk_per_ha_shi: parseFloatSafe(document.getElementById('f_hk_per_ha_shi').value),
    produksi_hi: parseFloatSafe(document.getElementById('f_produksi_hi').value),
    produksi_shi: parseFloatSafe(document.getElementById('f_produksi_shi').value),
    cost_hi: parseFloatSafe(document.getElementById('f_cost_hi').value),
    cost_shi: parseFloatSafe(document.getElementById('f_cost_shi').value),
    premi_hi: parseFloatSafe(document.getElementById('f_premi_hi').value),
    premi_shi: parseFloatSafe(document.getElementById('f_premi_shi').value),
    addcost_hi: parseFloatSafe(document.getElementById('f_addcost_hi').value),
    addcost_shi: parseFloatSafe(document.getElementById('f_addcost_shi').value)
  };

  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const url = editingId ? '/norma-rawat/' + editingId : '/norma-rawat';
  const method = editingId ? 'PUT' : 'POST';

  const btn = document.getElementById('formSubmitBtn');
  const originalText = btn.innerHTML;
  btn.innerHTML = '⏳ Menyimpan...';
  btn.disabled = true;

  try {
    const res = await fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
      },
      body: JSON.stringify(obj)
    });
    if(res.ok) {
      showToast('success', editingId ? 'Data berhasil diperbarui ✓' : 'Data berhasil ditambahkan ✓');
      setTimeout(() => window.location.reload(), 1000);
    } else {
      showToast('error', 'Gagal menyimpan data');
      btn.innerHTML = originalText;
      btn.disabled = false;
    }
  } catch(e) {
    showToast('error', 'Terjadi kesalahan sistem');
    btn.innerHTML = originalText;
    btn.disabled = false;
  }
}


// ========== CRUD: DELETE ==========
function openDelete(id) {
  const row = masterData.find(r=>r.id===id);
  if(!row) return;
  deleteTargetId=id;
  document.getElementById('deleteItemName').textContent=`${row.sitecode} - ${row.location}`;
  document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('open'); deleteTargetId=null; }

async function confirmDelete() {
  if(!deleteTargetId) return;
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  
  const btn = document.getElementById('deleteSubmitBtn');
  const originalText = btn.innerHTML;
  btn.innerHTML = '⏳ Menghapus...';
  btn.disabled = true;
  
  try {
    const res = await fetch('/norma-rawat/' + deleteTargetId, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
      }
    });
    if(res.ok) {
      showToast('info', 'Data berhasil dihapus');
      setTimeout(() => location.reload(), 1000);
    } else {
      showToast('error', 'Gagal menghapus data');
      btn.innerHTML = originalText;
      btn.disabled = false;
    }
  } catch(e) {
    showToast('error', 'Terjadi kesalahan sistem');
    btn.innerHTML = originalText;
    btn.disabled = false;
  }
}

// ========== EXPORT ==========
function exportExcel() {
  if(!masterData.length) { showToast('error','Tidak ada data untuk diekspor'); return; }
  const wb = XLSX.utils.book_new();
  const rows = [
    ['Status Umur Tanaman','Item Kerja','Topografi','','','','','','','',''],
    ['','','Datar','','','Roling 1','','','Roling 2 / Rendahan','',''],
    ['','','Norma (Hk/Ha)','Rotasi Kerja','N x R (Hk/Ha)','Norma (Hk/Ha)','Rotasi Kerja','N x R (Hk/Ha)','Norma (Hk/Ha)','Rotasi Kerja','N x R (Hk/Ha)'],
    ...masterData.map(r=>[
      r.status_umur,r.item_kerja,
      r.datar_norma,r.datar_rotasi,r.datar_nxr,
      r.roling1_norma,r.roling1_rotasi,r.roling1_nxr,
      r.roling2_norma,r.roling2_rotasi,r.roling2_nxr
    ])
  ];
  const ws = XLSX.utils.aoa_to_sheet(rows);
  ws['!cols']=[{wch:18},{wch:30},{wch:12},{wch:10},{wch:12},{wch:12},{wch:10},{wch:12},{wch:12},{wch:10},{wch:12}];
  XLSX.utils.book_append_sheet(wb, ws, 'Master Norma');
  const fname = `master_norma_sawit_${new Date().toISOString().slice(0,10)}.xlsx`;
  XLSX.writeFile(wb, fname);
  showToast('success',`File "${fname}" berhasil diunduh`);
}

// ========== IMPORT ==========
function openImport() {
  document.getElementById('importModal').classList.add('open');
}
function closeImportModal() { document.getElementById('importModal').classList.remove('open'); }

// ========== TOAST ==========
function showToast(type,msg) {
  const icons={success:'✅',error:'❌',info:'ℹ️'};
  const c=document.getElementById('toastContainer');
  const t=document.createElement('div');
  t.className=`toast ${type}`;
  t.innerHTML=`<span class="toast-icon">${icons[type]||'•'}</span><span>${msg}</span>`;
  c.appendChild(t);
  setTimeout(()=>{t.style.transition='opacity .4s';t.style.opacity='0';setTimeout(()=>t.remove(),400);},3500);
}

// ========== KLARIFIKASI ==========
function openKlarifikasi(id) {
  const row = masterData.find(r=>r.id===id);
  if(!row) return;
  editingId = id;
  document.getElementById('f_klarifikasi').value = row.klarifikasi || '';
  document.getElementById('klarifikasiModal').classList.add('open');
}
function closeKlarifikasiModal() {
  document.getElementById('klarifikasiModal').classList.remove('open');
  editingId = null;
}
async function submitKlarifikasi() {
  const klarifikasi = document.getElementById('f_klarifikasi').value.trim();
  if(!klarifikasi) { showToast('error', 'Klarifikasi wajib diisi!'); return; }
  
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const btn = document.getElementById('klarifikasiSubmitBtn');
  const originalText = btn.innerHTML;
  btn.innerHTML = '⏳ Menyimpan...';
  btn.disabled = true;

  try {
    const res = await fetch('/norma-rawat/' + editingId, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ klarifikasi: klarifikasi })
    });
    if(res.ok) {
      showToast('success', 'Klarifikasi berhasil disimpan');
      setTimeout(() => location.reload(), 1000);
    } else {
      showToast('error', 'Gagal menyimpan klarifikasi');
      btn.innerHTML = originalText;
      btn.disabled = false;
    }
  } catch(e) {
    showToast('error', 'Terjadi kesalahan sistem');
    btn.innerHTML = originalText;
    btn.disabled = false;
  }
}

// Close on overlay click
['formModal','deleteModal','importModal','klarifikasiModal'].forEach(id=>{
  document.getElementById(id).addEventListener('click',function(e){
    if(e.target===this) this.classList.remove('open');
  });
});
</script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    showToast('success', '{{ session('success') }}');
});
</script>
@endif
@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    showToast('error', '{{ session('error') }}');
});
</script>
@endif

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
