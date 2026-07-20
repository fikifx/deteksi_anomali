<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ANOMALI - System Overview</title>
  <style>
    :root {
      --bg: #0b1220;
      --panel: #111a2e;
      --panel2: #0e1626;
      --border: #1f2c47;
      --text: #e6edf7;
      --muted: #8a97b3;
      --accent: #3b82f6;
      --green: #22c55e;
      --amber: #f59e0b;
      --red: #ef4444;
      --purple: #8b5cf6;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Roboto, Arial, sans-serif;
      background: linear-gradient(160deg, #070c17, #0b1220 40%, #0c1424);
      color: var(--text);
      padding: 28px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 22px;
      flex-wrap: wrap;
      gap: 12px;
    }

    .title-block h1 {
      font-size: 22px;
      font-weight: 700;
      letter-spacing: .5px;
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .title-block p {
      color: var(--muted);
      font-size: 12.5px;
      margin-top: 4px;
      max-width: 560px;
    }

    .live-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(34, 197, 94, 0.12);
      border: 1px solid rgba(34, 197, 94, 0.35);
      color: var(--green);
      font-size: 11px;
      font-weight: 600;
      padding: 5px 10px;
      border-radius: 20px;
    }

    .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--green);
      animation: pulse 1.6s infinite;
    }

    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(34, 197, 94, .6);
      }

      70% {
        box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
      }

      100% {
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
      }
    }

    .clock {
      font-size: 11px;
      color: var(--muted);
      text-align: right;
    }

    .clock span {
      color: var(--text);
      font-weight: 600;
      font-size: 13px;
    }

    .hint {
      font-size: 11px;
      color: #5b6a8a;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .flow-panel {
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 20px 18px 26px;
      margin-bottom: 22px;
      position: relative;
      overflow: hidden;
    }

    .flow-panel::before {
      content: "";
      position: absolute;
      top: -40%;
      right: -10%;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(59, 130, 246, .15), transparent 70%);
    }

    .panel-label {
      font-size: 11px;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 14px;
      font-weight: 600;
    }

    .flow-row {
      display: flex;
      align-items: stretch;
      gap: 0;
      overflow-x: auto;
      padding-bottom: 6px;
    }

    .flow-step {
      background: var(--panel2);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 14px 16px;
      min-width: 168px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 6px;
      position: relative;
      cursor: pointer;
      transition: transform .15s, border-color .15s;
    }

    .flow-step:hover {
      transform: translateY(-3px);
      border-color: #3b82f6;
    }

    .flow-step .icon {
      width: 34px;
      height: 34px;
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      margin-bottom: 4px;
    }

    .flow-step h4 {
      font-size: 13px;
      font-weight: 700;
    }

    .flow-step p {
      font-size: 11px;
      color: var(--muted);
      line-height: 1.4;
    }

    .flow-step .tap {
      font-size: 9.5px;
      color: #3b82f6;
      margin-top: 2px;
      font-weight: 600;
    }

    .arrow {
      display: flex;
      align-items: center;
      justify-content: center;
      color: #33456e;
      font-size: 20px;
      padding: 0 6px;
      flex-shrink: 0;
    }

    .icon-blue {
      background: rgba(59, 130, 246, .15);
      color: var(--accent);
    }

    .icon-purple {
      background: rgba(139, 92, 246, .15);
      color: var(--purple);
    }

    .icon-amber {
      background: rgba(245, 158, 11, .15);
      color: var(--amber);
    }

    .icon-red {
      background: rgba(239, 68, 68, .15);
      color: var(--red);
    }

    .icon-green {
      background: rgba(34, 197, 94, .15);
      color: var(--green);
    }

    .grid {
      display: grid;
      grid-template-columns: 1.15fr 1fr;
      gap: 18px;
      margin-bottom: 18px;
    }

    .col {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    .card {
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 18px;
    }

    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
    }

    .kpi {
      background: var(--panel2);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px 14px;
      cursor: pointer;
      transition: transform .15s, border-color .15s;
    }

    .kpi:hover {
      transform: translateY(-2px);
      border-color: #3b82f6;
    }

    .kpi .label {
      font-size: 10.5px;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    .kpi .value {
      font-size: 22px;
      font-weight: 700;
      margin-top: 4px;
    }

    .kpi .delta {
      font-size: 11px;
      margin-top: 3px;
      font-weight: 600;
    }

    .up {
      color: var(--red);
    }

    .down {
      color: var(--green);
    }

    .chart-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .chart-title h3 {
      font-size: 13.5px;
      font-weight: 700;
    }

    .legend {
      display: flex;
      gap: 14px;
      font-size: 11px;
      color: var(--muted);
    }

    .legend span {
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .legend i {
      width: 8px;
      height: 8px;
      border-radius: 2px;
      display: inline-block;
    }

    svg .pt {
      cursor: pointer;
    }

    .alert-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
      max-height: 340px;
      overflow-y: auto;
    }

    .alert {
      display: flex;
      gap: 10px;
      align-items: flex-start;
      background: var(--panel2);
      border: 1px solid var(--border);
      border-left: 3px solid var(--red);
      border-radius: 8px;
      padding: 10px 12px;
      cursor: pointer;
      transition: transform .15s, border-color .15s;
    }

    .alert:hover {
      transform: translateX(3px);
      border-color: #3b82f6;
    }

    .alert.warn {
      border-left-color: var(--amber);
    }

    .alert.ok {
      border-left-color: var(--green);
    }

    .alert.grey {
      border-left-color: #9ca3af;
    }

    .alert .a-icon {
      font-size: 15px;
      margin-top: 1px;
    }

    .alert .a-body b {
      font-size: 12.5px;
    }

    .alert .a-body p {
      font-size: 11px;
      color: var(--muted);
      margin-top: 2px;
    }

    .alert .a-time {
      font-size: 10px;
      color: #5b6a8a;
      white-space: nowrap;
      margin-left: auto;
    }

    .status-row {
      display: flex;
      gap: 18px;
      margin-top: 4px;
      flex-wrap: wrap;
    }

    .status-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 11.5px;
      color: var(--muted);
    }

    .status-item .sd {
      width: 8px;
      height: 8px;
      border-radius: 50%;
    }

    table.roles {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
    }

    table.roles th {
      text-align: left;
      color: var(--muted);
      font-weight: 600;
      font-size: 10.5px;
      text-transform: uppercase;
      letter-spacing: .4px;
      padding-bottom: 8px;
      border-bottom: 1px solid var(--border);
    }

    table.roles td {
      padding: 9px 4px;
      border-bottom: 1px solid var(--border);
    }

    table.roles tr.rowclick {
      cursor: pointer;
    }

    table.roles tr.rowclick:hover td {
      color: #fff;
    }

    .tag {
      font-size: 10px;
      padding: 2px 8px;
      border-radius: 6px;
      font-weight: 600;
    }

    .tag-blue {
      background: rgba(59, 130, 246, .15);
      color: var(--accent);
    }

    .tag-amber {
      background: rgba(245, 158, 11, .15);
      color: var(--amber);
    }

    .tag-green {
      background: rgba(34, 197, 94, .15);
      color: var(--green);
    }

    footer {
      text-align: center;
      color: #4b5877;
      font-size: 10.5px;
      margin-top: 10px;
    }

    /* ===== MODAL ===== */
    .overlay {
      position: fixed;
      inset: 0;
      background: rgba(3, 7, 15, 0.72);
      backdrop-filter: blur(2px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 50;
      padding: 20px;
    }

    .overlay.show {
      display: flex;
    }

    .modal::-webkit-scrollbar {
      display: none;
    }

    .modal {
      -ms-overflow-style: none;  /* IE and Edge */
      scrollbar-width: none;  /* Firefox */
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 16px;
      max-width: 480px;
      width: 100%;
      max-height: 85vh;
      overflow-y: auto;
      padding: 22px;
      position: relative;
      animation: pop .18s ease-out;
    }

    @keyframes pop {
      from {
        transform: scale(.95);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .modal .close {
      position: absolute;
      top: 14px;
      right: 16px;
      cursor: pointer;
      color: var(--muted);
      font-size: 18px;
      background: none;
      border: none;
    }

    .modal .close:hover {
      color: #fff;
    }

    .modal h2 {
      font-size: 16px;
      margin-bottom: 4px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .modal .sub {
      font-size: 11.5px;
      color: var(--muted);
      margin-bottom: 16px;
    }

    .mrow {
      display: flex;
      justify-content: space-between;
      padding: 8px 0;
      border-bottom: 1px solid var(--border);
      font-size: 12.5px;
    }

    .mrow span:first-child {
      color: var(--muted);
    }

    .mrow span:last-child {
      font-weight: 600;
    }

    .mbar-wrap {
      margin-top: 14px;
    }

    .mbar {
      height: 8px;
      border-radius: 4px;
      background: #1f2c47;
      overflow: hidden;
      margin-top: 5px;
    }

    .mbar i {
      display: block;
      height: 100%;
      border-radius: 4px;
    }

    .mfoot {
      margin-top: 16px;
      font-size: 11.5px;
      color: var(--muted);
      line-height: 1.5;
      background: var(--panel2);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 10px 12px;
    }

    .modal .status-pill {
      display: inline-block;
      font-size: 10.5px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 20px;
      margin-bottom: 2px;
    }

    /* ===== RESPONSIVE / MOBILE ===== */
    @media (max-width: 860px) {
      body {
        padding: 16px;
      }

      .header {
        flex-direction: column;
      }

      .clock {
        text-align: left;
      }

      .title-block h1 {
        font-size: 18px;
      }

      .title-block p {
        font-size: 12px;
        max-width: 100%;
      }

      .flow-row {
        flex-direction: column;
        overflow-x: visible;
      }

      .flow-step {
        min-width: 100%;
      }

      .arrow {
        transform: rotate(90deg);
        padding: 2px 0;
        justify-content: center;
      }

      .grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }

      .kpi-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
      }

      .kpi {
        padding: 10px 8px;
      }

      .kpi .value {
        font-size: 18px;
      }

      .kpi .label {
        font-size: 9px;
      }

      .kpi .delta {
        font-size: 9.5px;
      }

      .chart-title {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
      }

      table.roles {
        font-size: 11px;
      }

      table.roles th:nth-child(3),
      table.roles td:nth-child(3) {
        display: none;
      }

      .alert-list {
        max-height: none;
      }
    }

    @media (max-width: 480px) {
      .kpi-grid {
        grid-template-columns: 1fr 1fr;
      }

      .kpi-grid .kpi:last-child {
        grid-column: span 2;
      }

      .title-block h1 {
        font-size: 16px;
      }

      .live-badge {
        font-size: 10px;
        padding: 4px 8px;
      }

      svg {
        height: 150px !important;
      }

      .modal {
        padding: 18px;
      }
    }
  </style>
</head>

<body>

  @php
    $countAman = 0;
    $countWaspada = 0;
    $countOver = 0;
    $countKosong = 0;

    if (isset($rawatData) && $rawatData->count() > 0) {
      foreach ($rawatData as $rawat) {
        $mandays_shi = (float) ($rawat->mandays_shi ?? 0);
        $produksi_shi = (float) ($rawat->produksi_shi ?? 0);
        $realisasi = $produksi_shi > 0 ? $mandays_shi / $produksi_shi : 0;

        $master = isset($masterNorma) ? $masterNorma->firstWhere('item_kerja', $rawat->jobdesc) : null;
        $standar = $master && $master->datar_norma ? (float) $master->datar_norma : 0;

        $persen = 0;
        if ($standar > 0) {
          $persen = round(($realisasi / $standar) * 100, 1);
        }

        if (empty($rawat->jobdesc) && empty($rawat->tdate)) {
          $countKosong++;
        } else {
          if ($standar == 0) {
            $countKosong++;
          } elseif ($persen <= 100) {
            $countAman++;
          } elseif ($persen <= 105) {
            $countWaspada++;
          } else {
            $countOver++;
          }
        }
      }
    }

    $polyStandar = "";
    $polyRealisasi = "";
    $polyFill = "";
    $circlesHtml = "";

    if (isset($rawatData) && $rawatData->count() > 0) {
      $chartItems = $rawatData->whereNotNull('jobdesc')->take(15)->reverse()->values();
      $numPoints = $chartItems->count();
      $maxVal = 0.01;

      $chartDataArr = [];
      foreach ($chartItems as $index => $rawat) {
        $mandays_shi = (float) ($rawat->mandays_shi ?? 0);
        $produksi_shi = (float) ($rawat->produksi_shi ?? 0);
        $real = $produksi_shi > 0 ? $mandays_shi / $produksi_shi : 0;

        $master = isset($masterNorma) ? $masterNorma->firstWhere('item_kerja', $rawat->jobdesc) : null;
        $std = $master && $master->datar_norma ? (float) $master->datar_norma : 0;

        if ($real > $maxVal)
          $maxVal = $real;
        if ($std > $maxVal)
          $maxVal = $std;

        $chartDataArr[] = [
          'real' => $real,
          'std' => $std,
          'jobdesc' => $rawat->jobdesc ?? '-',
          'afd' => $rawat->afdcode ?? '-',
          'waktu' => $rawat->tdate ? \Carbon\Carbon::parse($rawat->tdate)->translatedFormat('d M Y') : 'Hari ini',
        ];
      }

      $maxVal = $maxVal * 1.15; // 15% headroom

      if ($numPoints > 1) {
        $stepX = 560 / ($numPoints - 1);
        $polyFill .= "0,190 ";

        foreach ($chartDataArr as $i => $d) {
          $x = $i * $stepX;
          $yStd = 150 - ($d['std'] / $maxVal * 120);
          $yReal = 150 - ($d['real'] / $maxVal * 120);

          $polyStandar .= "$x,$yStd ";
          $polyRealisasi .= "$x,$yReal ";
          $polyFill .= "$x,$yReal ";

          $isOver = $d['std'] > 0 && $d['real'] > ($d['std'] * 1.05);
          $isLast = ($i == $numPoints - 1);
          $persen = $d['std'] > 0 ? round(($d['real'] / $d['std']) * 100, 1) : 0;

          if ($isOver || $isLast) {
            $color = $isOver ? '#ef4444' : '#3b82f6';
            $r = $isLast ? 7 : 6;
            $anim = $isLast ? '<animate attributeName="r" values="6;9;6" dur="1.4s" repeatCount="indefinite"/>' : '';

            $waktuSafe = htmlspecialchars($d['waktu'], ENT_QUOTES);
            $afdSafe = htmlspecialchars("Afdeling " . $d['afd'], ENT_QUOTES);
            $jobSafe = htmlspecialchars($d['jobdesc'], ENT_QUOTES);

            $circlesHtml .= "<circle class=\"pt\" cx=\"$x\" cy=\"$yReal\" r=\"$r\" fill=\"$color\" onclick=\"openPoint('$waktuSafe','$afdSafe','$jobSafe', $persen)\">$anim</circle>";
          }
        }
        $polyFill .= "560,190";
      }
    }
  @endphp
  <div class="header">
    <div class="title-block">
      <h1>🧭 Sistem Deteksi Dini Cost &amp; Norma <span class="live-badge"><span class="dot"></span>LIVE
          MONITORING</span></h1>
      <p>Pemantauan realisasi cost dan norma kerja secara real-time, deteksi anomali otomatis, serta klarifikasi
        penyebab over budget untuk mendukung pengambilan keputusan Kepala Kebun &amp; Asisten Afdeling.</p>
    </div>
    <div style="display:flex; gap:16px; align-items:center;">
      <div class="clock" style="text-align:right">Update terakhir<br><span>{{ date('d M Y, H:i') }} WIB</span></div>
      @auth
        <a href="{{ route('master.index') }}" class="nav-item {{ request()->routeIs('master.index') ? 'active' : '' }}">
      <span class="icon">📋</span> Master Data Norma
    </a>
    <a href="{{ route('budget.index') }}" class="nav-item {{ request()->routeIs('budget.index') ? 'active' : '' }}">
      <span class="icon">💰</span> Master Budget
    </a>
      @else
        <a href="{{ route('login') }}"
          style="background:transparent; border:1px solid var(--accent); color:var(--accent); text-decoration:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600;">Login
          Admin</a>
      @endauth
    </div>
  </div>

  <div class="hint">👉 Semua kartu, langkah alur, dan alert di bawah ini bisa diklik untuk melihat detail data .
  </div>


  <div class="grid">
    <div class="col">
      <!-- KPI -->
      <div class="card">
        <div class="panel-label">Ringkasan Real-time</div>
        <div class="kpi-grid">
          <div class="kpi" onclick="openKpi('aman')">
            <div class="label">Status Aman</div>
            <div class="value" style="color:var(--green)">{{ $countAman }}</div>
            <div class="delta down">▼ Realisasi &le; 100%</div>
          </div>
          <div class="kpi" onclick="openKpi('waspada')">
            <div class="label">Status Waspada</div>
            <div class="value" style="color:var(--amber)">{{ $countWaspada }}</div>
            <div class="delta up">▲ 101% - 105%</div>
          </div>
          <div class="kpi" onclick="openKpi('over')">
            <div class="label">Over Normal</div>
            <div class="value" style="color:var(--red)">{{ $countOver }}</div>
            <div class="delta up">▲ &gt; 105%</div>
          </div>
          <div class="kpi" onclick="openKpi('kosong')">
            <div class="label">Tanpa Status</div>
            <div class="value" style="color:var(--muted)">{{ $countKosong }}</div>
            <div class="delta down">▼ Data Kosong</div>
          </div>
        </div>
      </div>

      <!-- CHART -->
      <div class="card">
        <div class="chart-title">
          <h3>Tren Realisasi Cost vs Budget (30 Hari Terakhir)</h3>
          <div class="legend">
            <span><i style="background:#3b82f6"></i>Realisasi</span>
            <span><i style="background:#f59e0b"></i>Budget</span>
          </div>
        </div>
        <svg viewBox="0 0 560 190" width="100%" height="190">
          <g stroke="#1f2c47" stroke-width="1">
            <line x1="0" y1="30" x2="560" y2="30" />
            <line x1="0" y1="70" x2="560" y2="70" />
            <line x1="0" y1="110" x2="560" y2="110" />
            <line x1="0" y1="150" x2="560" y2="150" />
          </g>
          <polyline fill="none" stroke="#f59e0b" stroke-width="2" stroke-dasharray="5,4"
            points="{!! trim($polyStandar) !!}"></polyline>
          <polygon fill="rgba(59,130,246,0.15)" points="{!! trim($polyFill) !!}"></polygon>
          <polyline fill="none" stroke="#3b82f6" stroke-width="2.5" points="{!! trim($polyRealisasi) !!}"></polyline>
          {!! $circlesHtml !!}
        </svg>
        <div class="status-row">
          <div class="status-item"><span class="sd" style="background:#ef4444"></span>Klik titik merah untuk lihat
            detail anomali</div>
          <div class="status-item"><span class="sd" style="background:#3b82f6"></span>Data terkini diperbarui otomatis
          </div>
        </div>
      </div>

      <!-- TABEL PERAN -->
      <div class="card">
        <div class="panel-label">Peran Pengguna dalam Sistem</div>
        <table class="roles">
          <tr>
            <th>Peran</th>
            <th>Fungsi Utama</th>
            <th>Akses</th>
          </tr>
          <tr class="rowclick" onclick="openRole('asisten')">
            <td>Asisten Afdeling</td>
            <td>Menerima alert, memberi klarifikasi awal</td>
            <td><span class="tag tag-blue">Input &amp; Respon</span></td>
          </tr>
          <tr class="rowclick" onclick="openRole('kakebun')">
            <td>Kepala Kebun</td>
            <td>Memantau afdeling, menyetujui tindakan</td>
            <td><span class="tag tag-amber">Monitoring</span></td>
          </tr>
          <tr class="rowclick" onclick="openRole('manajemen')">
            <td>Manajemen</td>
            <td>Melihat rekap indikator keberhasilan</td>
            <td><span class="tag tag-green">Dashboard</span></td>
          </tr>
        </table>
      </div>
    </div>

    <div class="col">
      <!-- ALERT FEED -->
      <div class="card">
        <div class="chart-title">
          <h3>Live Alert Feed</h3>
          <span class="live-badge"><span class="dot"></span>streaming</span>
        </div>
        <div class="alert-list" id="alertList"></div>
      </div>

      <!-- STATUS SISTEM & KETERANGAN -->
      <div class="card" style="flex:1;">
        <div class="panel-label">Keterangan Warna & Status Komponen</div>

        <!-- Legend Warna -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
          <div class="status-item"><span class="sd" style="background:#22c55e"></span><b>Aman</b> (&le; 100%)</div>
          <div class="status-item"><span class="sd" style="background:#f59e0b"></span><b>Netral</b> (101% - 105%)</div>
          <div class="status-item"><span class="sd" style="background:#ef4444"></span><b>Over Normal</b> (&gt; 105%)
          </div>
          <div class="status-item"><span class="sd" style="background:#9ca3af"></span><b>Kosong</b> (0%)</div>
        </div>

        <div style="height:1px; background:var(--border); margin-bottom:16px;"></div>

        <!-- Status Komponen -->
        <div style="display:flex;flex-direction:column;gap:10px;">
          <div class="status-item"><span class="sd" style="background:#22c55e"></span>Koneksi Data Sumber
            (ERP/Operasional) — Normal</div>
          <div class="status-item"><span class="sd" style="background:#22c55e"></span>AI Analysis Engine — Berjalan,
            latensi rendah</div>
          <div class="status-item"><span class="sd" style="background:#22c55e"></span>Modul Notifikasi (Alert ke User) —
            Aktif</div>
        </div>
      </div>
    </div>
  </div>

  <div class="grid">
    <div class="col">
      <div class="card">
        <div class="chart-title">
          <h3>💰 Master Budget (Bulan Ini)</h3>
          <button onclick="openAllBudget()" style="background:rgba(59, 130, 246, 0.1); border:1px solid rgba(59, 130, 246, 0.3); color:#3b82f6; font-size:11px; cursor:pointer; font-weight:600; display:flex; align-items:center; gap:4px; padding:4px 8px; border-radius:6px; transition:0.2s;">
             👁️ Lihat Semua Budget
          </button>
        </div>
        <div style="font-size:32px; font-weight:700; color:var(--accent); margin:16px 0;">
          Rp {{ number_format($juneBudget ?? 0, 0, ',', '.') }}
        </div>
        <p style="font-size:13px; color:var(--muted); line-height:1.5;">
          Total alokasi budget (Master Budget) untuk seluruh aktivitas perawatan norma di bulan ini. Data ini tersinkronisasi otomatis dari database master.
        </p>
      </div>
    </div>
    
    <div class="col">
      <div class="card">
        <div class="chart-title">
          <h3>📊 Realisasi vs Sisa Budget</h3>
        </div>
        
        @php
            $budget = $juneBudget ?? 0;
            $real = $totalRealisasi ?? 0;
            $sisa = $sisaBudget ?? 0;
            $persenReal = $budget > 0 ? min(100, round(($real / $budget) * 100)) : 0;
            $persenSisa = 100 - $persenReal;
        @endphp
        
        <div style="display:flex; align-items:center; gap:24px; margin-top:16px;">
            <!-- Visual Bar / Donut alternative -->
            <div style="flex:1;">
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:13px;">
                    <span style="color:var(--text)">Realisasi ({{ $persenReal }}%)</span>
                    <strong style="color:var(--red)">Rp {{ number_format($real, 0, ',', '.') }}</strong>
                </div>
                <div style="height:12px; background:var(--panel2); border-radius:6px; overflow:hidden; border:1px solid var(--border); margin-bottom:16px;">
                    <div style="height:100%; width:{{ $persenReal }}%; background:var(--red);"></div>
                </div>
                
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:13px;">
                    <span style="color:var(--text)">Sisa Budget ({{ $persenSisa }}%)</span>
                    <strong style="color:var(--green)">Rp {{ number_format($sisa, 0, ',', '.') }}</strong>
                </div>
                <div style="height:12px; background:var(--panel2); border-radius:6px; overflow:hidden; border:1px solid var(--border);">
                    <div style="height:100%; width:{{ $persenSisa }}%; background:var(--green);"></div>
                </div>
            </div>
        </div>
        
      </div>
    </div>
  </div>

  <footer>Gambaran sistem ANOMALI — ilustrasi konsep monitoring real-time untuk keperluan presentasi. Seluruh data
    bersifat dummy.</footer>

  <!-- MODAL -->
  <div class="overlay" id="overlay" onclick="closeModalBg(event)">
    <div class="modal" id="modal"></div>
  </div>

  <script>
    // ===== DATA DUMMY / REAL DATA =====
    const masterBudgetData = @json($masterBudget ?? []);
    
    const alerts = [
      @if(isset($rawatData) && $rawatData->count() > 0)
        @foreach($rawatData as $index => $rawat)
              @php
                $mandays_shi = (float) ($rawat->mandays_shi ?? 0);
                $produksi_shi = (float) ($rawat->produksi_shi ?? 0);
                $realisasi = 0;
                if ($produksi_shi > 0) {
                  $realisasi = $mandays_shi / $produksi_shi;
                }
                $master = isset($masterNorma) ? $masterNorma->firstWhere('item_kerja', $rawat->jobdesc) : null;
                $standar = $master && $master->datar_norma ? (float) $master->datar_norma : 0;

                $fluktuasi = 0;
                if ($standar > 0) {
                  $fluktuasi = (($realisasi - $standar) / $standar) * 100;
                }

                $persen = 0;
                if ($standar > 0) {
                  $persen = round(($realisasi / $standar) * 100, 1);
                }

                if (empty($rawat->jobdesc) && empty($rawat->tdate)) {
                  $statusText = 'Tidak Ada Data';
                  $color = '#9ca3af'; // abu-abu
                  $icon = '⚪';
                  $cls = 'grey';
                } else {
                  if ($standar == 0) {
                    $statusText = 'Tanpa Status';
                    $color = '#9ca3af';
                    $icon = '⚪';
                    $cls = 'grey';
                  } elseif ($persen <= 100) {
                    $statusText = 'Aman';
                    $color = '#22c55e'; // hijau
                    $icon = '🟢';
                    $cls = 'ok';
                  } elseif ($persen <= 105) {
                    $statusText = 'Netral / Waspada';
                    $color = '#f59e0b'; // orange
                    $icon = '🟠';
                    $cls = 'warn';
                  } else {
                    $statusText = 'Over Normal';
                    $color = '#ef4444'; // merah
                    $icon = '🔴';
                    $cls = '';
                  }
                }
                $tdate = $rawat->tdate ? \Carbon\Carbon::parse($rawat->tdate)->translatedFormat('d M Y') : '-';
              @endphp
              {
            id: {{ $index + 1 }},
            icon: "{{ $icon }}",
            cls: "{{ $cls }}",
            title: {!! json_encode("Afdeling " . ($rawat->afdcode ?? '-') . " — " . ($rawat->location ?? '-')) !!},
            desc: {!! json_encode(($rawat->jobdesc ?? 'Data Pekerjaan') . " <br><span style='color:" . $color . "; font-weight:600;'>Status: " . $statusText . " (" . $persen . "%)</span>") !!},
            time: {!! json_encode($tdate) !!},
            detail: {
              status: {!! json_encode($statusText) !!},
              statusColor: "{{ $color }}",
              persen: {{ $persen }},
              pic: {!! json_encode("Asisten Afdeling " . ($rawat->afdcode ?? '-')) !!},
              jobdesc: {!! json_encode($rawat->jobdesc ?? '-') !!},
              mandays_shi: "{{ fmod($mandays_shi, 1) == 0 ? intval($mandays_shi) : number_format($mandays_shi, 2, '.', '') }}",
              produksi_shi: "{{ fmod($produksi_shi, 1) == 0 ? intval($produksi_shi) : number_format($produksi_shi, 2, '.', '') }}",
              realisasi_val: "{{ fmod($realisasi, 1) == 0 ? intval($realisasi) : number_format($realisasi, 2, '.', '') }}",
              standar_val: "{{ fmod($standar, 1) == 0 ? intval($standar) : number_format($standar, 2, '.', '') }}",
              fluktuasi_val: "{{ number_format($fluktuasi, 2, '.', '') }}",
              catatan: "Data terakhir dari sistem ERP."
            }
          }{{ $loop->last ? '' : ',' }}
        @endforeach
      @else
        {
          id: 1, icon: "🔴", cls: "", title: "Afdeling III — Biaya Pupuk", desc: "Realisasi 118% dari budget bulanan.", time: "2 mnt lalu",
          detail: { status: "Belum Diklarifikasi", statusColor: "#ef4444", budget: "Rp 42.000.000", realisasi: "Rp 49.560.000", persen: 118, pic: "Asisten Afdeling III", catatan: "Kenaikan dipicu pembelian pupuk di luar jadwal rutin akibat kondisi tanah. Menunggu klarifikasi resmi dari Asisten Afdeling." }
        },
        {
          id: 2, icon: "🟠", cls: "warn", title: "Afdeling VII — Norma Panen", desc: "Produktivitas per HK di bawah standar 3 hari berturut-turut.", time: "18 mnt lalu",
          detail: { status: "Dalam Peninjauan", statusColor: "#f59e0b", budget: "1.2 ton/HK (standar)", realisasi: "0.95 ton/HK", persen: 79, pic: "Kepala Kebun", catatan: "Kemungkinan disebabkan curah hujan tinggi minggu ini. Tim lapangan sedang melakukan pengecekan." }
        },
        {
          id: 3, icon: "🔴", cls: "", title: "Afdeling V — Biaya Pemeliharaan", desc: "Deviasi signifikan terdeteksi.", time: "41 mnt lalu",
          detail: { status: "Belum Diklarifikasi", statusColor: "#ef4444", budget: "Rp 65.000.000", realisasi: "Rp 80.600.000", persen: 124, pic: "Asisten Afdeling V", catatan: "Notifikasi telah dikirim ke Kepala Kebun. Menunggu tindak lanjut dalam 24 jam." }
        },
        {
          id: 4, icon: "🟢", cls: "ok", title: "Afdeling I — Biaya Angkut", desc: "Klarifikasi selesai: keterlambatan pembayaran vendor.", time: "1 jam lalu",
          detail: { status: "Selesai Diklarifikasi", statusColor: "#22c55e", budget: "Rp 30.000.000", realisasi: "Rp 31.200.000", persen: 104, pic: "Asisten Afdeling I", catatan: "Penyebab: keterlambatan pembayaran ke vendor angkut. Sudah ditindaklanjuti dan dijadwalkan ulang." }
        },
        {
          id: 5, icon: "🟠", cls: "warn", title: "Afdeling IX — Norma Semprot", desc: "Konsumsi bahan di atas rata-rata historis.", time: "2 jam lalu",
          detail: { status: "Dalam Peninjauan", statusColor: "#f59e0b", budget: "850 ml/ha (standar)", realisasi: "930 ml/ha", persen: 109, pic: "Asisten Afdeling IX", catatan: "Perlu pengecekan lapangan untuk memastikan dosis sesuai SOP." }
        },
        {
          id: 6, icon: "🟢", cls: "ok", title: "Afdeling II — Biaya Umum", desc: "Kembali sesuai budget setelah tindakan korektif minggu lalu.", time: "3 jam lalu",
          detail: { status: "Selesai Diklarifikasi", statusColor: "#22c55e", budget: "Rp 18.000.000", realisasi: "Rp 17.400.000", persen: 97, pic: "Kepala Kebun", catatan: "Tindakan korektif minggu lalu berhasil menurunkan biaya ke batas normal." }
        }
      @endif
];

    const flowData = {
      input: { title: "📥 Data Input", sub: "Sumber data yang ditarik otomatis oleh sistem", rows: [["Sumber data", "ERP Operasional Kebun"], ["Frekuensi tarik data", "Setiap 15 menit"], ["Cakupan", "128 Afdeling"], ["Jenis data", "Realisasi cost, norma kerja, budget, standar"]], note: "Data mentah divalidasi otomatis sebelum masuk ke AI Analysis Engine untuk memastikan konsistensi format dan satuan." },
      ai: { title: "🤖 AI Analysis Engine", sub: "Model yang membandingkan realisasi vs standar", rows: [["Metode", "Perbandingan pola statistik + ambang batas dinamis"], ["Waktu proses rata-rata", "3.2 detik / afdeling"], ["Data yang diproses hari ini", "128 afdeling"], ["Akurasi deteksi (uji coba)", "~92%"]], note: "Engine berjalan kontinu di background, membandingkan setiap transaksi baru dengan histori dan budget yang berlaku." },
      detect: { title: "⚠️ Deteksi Anomali", sub: "Kasus yang ditandai sistem sebagai potensi over budget", rows: [["Anomali aktif", "14 kasus"], ["Kategori terbanyak", "Biaya Pemeliharaan (5 kasus)"], ["Rata-rata deviasi", "+16% dari budget"], ["Waktu deteksi", "Rata-rata 6 hari lebih awal dari akhir periode"]], note: "Anomali diberi skor prioritas berdasarkan besar deviasi dan dampak terhadap total budget afdeling." },
      notif: { title: "🔔 Notifikasi & Alert", sub: "Distribusi peringatan ke pengguna terkait", rows: [["Terkirim hari ini", "14 notifikasi"], ["Kanal", "Dashboard + Email"], ["Rata-rata waktu respon", "27 menit"], ["Penerima", "Asisten Afdeling & Kepala Kebun terkait"]], note: "Notifikasi otomatis terkirim begitu anomali terdeteksi, tanpa menunggu akhir periode pelaporan." },
      action: { title: "✅ Klarifikasi & Tindakan", sub: "Progres penyelesaian kasus anomali", rows: [["Sudah diklarifikasi", "9 dari 14 kasus"], ["Rata-rata waktu klarifikasi", "4.5 jam"], ["Tindakan korektif tercatat", "6 kasus"], ["Kasus menunggu tindak lanjut", "5 kasus"]], note: "Setiap klarifikasi dan tindakan korektif tercatat sebagai riwayat untuk evaluasi indikator keberhasilan." }
    };

    const kpiData = {
      aman: { title: "🟢 Status Aman", sub: "Pekerjaan dengan realisasi di bawah atau sama dengan standar", rows: [["Kriteria", "Realisasi \u2264 100% dari standar"], ["Tindakan", "Lanjutkan operasional normal"], ["Prioritas", "Rendah"]], note: "Biaya / norma untuk pekerjaan ini terkendali dan berada di batas aman." },
      waspada: { title: "🟠 Status Waspada / Netral", sub: "Pekerjaan dengan indikasi sedikit melewati standar", rows: [["Kriteria", "Realisasi 101% - 105% dari standar"], ["Tindakan", "Perlu pemantauan tambahan"], ["Prioritas", "Menengah"]], note: "Kemungkinan disebabkan fluktuasi harga atau kondisi lapangan ringan." },
      over: { title: "🔴 Over Normal", sub: "Pekerjaan melebihi batas wajar", rows: [["Kriteria", "Realisasi > 105% dari standar"], ["Tindakan", "Wajib klarifikasi asisten afdeling"], ["Prioritas", "Tinggi"]], note: "Anomali terdeteksi! Memerlukan klarifikasi segera untuk mengendalikan budget." },
      kosong: { title: "⚪ Tanpa Status", sub: "Pekerjaan tanpa master standar", rows: [["Kriteria", "Standar (Master) = 0 atau data tidak lengkap"], ["Tindakan", "Update data master norma"], ["Prioritas", "Menengah"]], note: "Fluktuasi tidak dapat dihitung karena tidak ada pembanding di tabel master data." }
    };

    const roleData = {
      asisten: { title: "👷 Asisten Afdeling", sub: "Peran di lapangan", rows: [["Tanggung jawab", "Menerima alert & memberi klarifikasi awal"], ["Akses sistem", "Input & Respon"], ["Rata-rata kasus ditangani/bulan", "5-8 kasus"], ["SLA klarifikasi", "Maks. 8 jam"]], note: "Asisten Afdeling adalah pihak pertama yang merespon notifikasi anomali di lapangan." },
      kakebun: { title: "🧑‍💼 Kepala Kebun", sub: "Peran pengawasan wilayah", rows: [["Tanggung jawab", "Memantau seluruh afdeling & menyetujui tindakan"], ["Akses sistem", "Monitoring & Approval"], ["Jumlah afdeling diawasi", "± 12 afdeling"], ["Eskalasi", "Kasus > 8 jam belum diklarifikasi"]], note: "Kepala Kebun menerima eskalasi otomatis untuk kasus yang belum ditindaklanjuti tepat waktu." },
      manajemen: { title: "🏢 Manajemen", sub: "Peran evaluasi & strategis", rows: [["Tanggung jawab", "Melihat rekap indikator keberhasilan"], ["Akses sistem", "Dashboard Eksekutif"], ["Frekuensi review", "Mingguan & bulanan"], ["Fokus", "Tren kepatuhan budget & efektivitas tindakan"]], note: "Manajemen menggunakan data agregat untuk evaluasi tata kelola cost secara menyeluruh." }
    };

    function renderAlerts() {
      const list = document.getElementById('alertList');
      list.innerHTML = alerts.map(a => `
    <div class="alert ${a.cls}" onclick="openAlert(${a.id})">
      <div class="a-icon">${a.icon}</div>
      <div class="a-body"><b>${a.title}</b><p>${a.desc}</p></div>
      <div class="a-time">${a.time}</div>
    </div>`).join('');
    }
    
    alerts.sort((a, b) => {
      const aVal = (a.detail && a.detail.fluktuasi_val !== undefined) ? parseFloat(a.detail.fluktuasi_val) : (a.detail && a.detail.persen ? a.detail.persen : -9999);
      const bVal = (b.detail && b.detail.fluktuasi_val !== undefined) ? parseFloat(b.detail.fluktuasi_val) : (b.detail && b.detail.persen ? b.detail.persen : -9999);
      return bVal - aVal;
    });
    
    renderAlerts();

    function showModal(html) {
      document.getElementById('modal').innerHTML = html;
      document.getElementById('overlay').classList.add('show');
    }
    function closeModal() { document.getElementById('overlay').classList.remove('show'); }
    function closeModalBg(e) { if (e.target.id === 'overlay') closeModal(); }

    function buildRows(rows) {
      return rows.map(r => `<div class="mrow"><span>${r[0]}</span><span>${r[1]}</span></div>`).join('');
    }

    const moneyFmt = v => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(v);

    function openAlert(id) {
      const a = alerts.find(x => x.id === id);
      const d = a.detail;
      
      const hkPrice = 158680;
      const normalBudget = parseFloat(d.standar_val) * parseFloat(d.produksi_shi) * hkPrice;
      const realisasiBudget = parseFloat(d.realisasi_val) * parseFloat(d.produksi_shi) * hkPrice;
      const selisih = realisasiBudget - normalBudget;

      showModal(`
    <button class="close" onclick="closeModal()">✕</button>
    <h2 style="font-size:16px; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
      👁️ Detail Fluktuasi & Analisa Keuangan
    </h2>
    
    <div style="background:var(--panel2); padding:16px; border-radius:12px; border:1px solid var(--border); margin-bottom:16px;">
      <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
        <span style="color:var(--muted); font-size:12px;">JOBDESC</span>
        <strong style="color:var(--text)">${d.jobdesc}</strong>
      </div>
      <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
        <span style="color:var(--muted); font-size:12px;">MANDAYS_SHI</span>
        <strong style="color:var(--text)">${d.mandays_shi}</strong>
      </div>
      <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
        <span style="color:var(--muted); font-size:12px;">PRODUKSI_SHI (Hektar)</span>
        <strong style="color:var(--text)">${d.produksi_shi}</strong>
      </div>
    </div>
    
    <div style="background:var(--panel2); padding:16px; border-radius:12px; border:1px solid var(--border); margin-bottom:16px;">
      <h4 style="font-size:13px; margin-bottom:10px; color:var(--muted);">Rumus Perhitungan:</h4>
      <p style="font-size:13px; color:var(--text); margin-bottom:8px;">
        <strong>Realisasi:</strong> MANDAYS_SHI / PRODUKSI_SHI<br>
        = ${d.mandays_shi} / ${d.produksi_shi} <br>
        = <span style="color:var(--green)">${d.realisasi_val}</span>
      </p>
      <p style="font-size:13px; color:var(--text); margin-bottom:8px;">
        <strong>Norma Standar (Master Datar):</strong><br>
        = <span style="color:var(--accent)">${d.standar_val}</span>
      </p>
      <hr style="border-color:var(--border); margin:12px 0;">
      <p style="font-size:13px; color:var(--text); line-height:1.6">
        <strong>Fluktuasi:</strong> ((Realisasi - Standar) / Standar) * 100% <br>
        = ((${d.realisasi_val} - ${d.standar_val}) / ${d.standar_val}) * 100% <br>
        = <strong>${d.fluktuasi_val}%</strong>
      </p>
    </div>

    <div style="background:var(--panel2); padding:16px; border-radius:12px; border:1px solid var(--border); margin-bottom:16px;">
      <h4 style="font-size:13px; margin-bottom:10px; color:var(--muted);">Analisa Keuangan:</h4>
      
      <p style="font-size:13px; color:var(--text); margin-bottom:8px;">
        <strong>Budget Normal:</strong> (Norma ${d.standar_val} x ${d.produksi_shi} Ha x Rp 158.680)<br>
        = <span style="color:var(--accent)">${moneyFmt(normalBudget)}</span>
      </p>
      
      <p style="font-size:13px; color:var(--text); margin-bottom:8px;">
        <strong>Budget Realisasi:</strong> (Realisasi ${d.realisasi_val} x ${d.produksi_shi} Ha x Rp 158.680)<br>
        = <span style="color:#ef4444">${moneyFmt(realisasiBudget)}</span>
      </p>
      
      <hr style="border-color:var(--border); margin:12px 0;">
      <p style="font-size:13px; color:var(--text); line-height:1.6">
        <strong>${selisih > 0 ? 'Over Budget / Rugi' : 'Hemat Budget'}:</strong> <br>
        = <strong style="color:${selisih > 0 ? '#ef4444' : '#22c55e'}">${moneyFmt(Math.abs(selisih))}</strong>
      </p>
    </div>

    <div style="text-align:center; margin-top:20px;">
      <div style="font-size:11px; color:var(--muted); text-transform:uppercase; margin-bottom:8px;">KESIMPULAN STATUS</div>
      <div style="display:inline-block; padding:8px 16px; border-radius:20px; font-weight:600; font-size:13px; background:${d.statusColor}22; color:${d.statusColor}; border:1px solid ${d.statusColor}55;">
        ${d.status}
      </div>
    </div>
    
    <div id="aiAnalysisContainer" style="display:none; margin-top:20px; padding:16px; background:rgba(66, 133, 244, 0.05); border:1px solid rgba(155, 114, 203, 0.4); border-radius:12px;">
        <div id="aiAnalysisText" style="font-size:13px; color:var(--text); line-height:1.6;">
           <button id="btnAiTrigger" class="btn btn-primary" style="width:100%; padding:10px; font-size:13px; border-radius:8px; display:flex; align-items:center; justify-content:center; gap:8px;" onclick="triggerGemini(this, '${d.jobdesc}', '${moneyFmt(normalBudget)}', '${moneyFmt(realisasiBudget)}', ${selisih})">
              🤖 Analisa dengan AI
           </button>
        </div>
    </div>
  `);

      if (d.status.toLowerCase().includes('over normal') || selisih > 0) {
          document.getElementById('aiAnalysisContainer').style.display = 'block';
      }
    }

    async function triggerGemini(btn, jobdesc, budgetNormal, budgetRealisasi, selisih) {
        btn.innerHTML = "⏳ Menganalisa...";
        btn.disabled = true;
        btn.style.opacity = "0.7";
        await fetchGeminiAnalysis(jobdesc, budgetNormal, budgetRealisasi, selisih);
    }

    async function fetchGeminiAnalysis(jobdesc, budgetNormal, budgetRealisasi, selisih) {
        let text = "";
        let absSelisih = Math.abs(selisih);
        
        if (selisih > 0) {
            text += `Berdasarkan analisa pada pekerjaan <strong>${jobdesc}</strong>, ditemukan indikasi inefisiensi atau pemborosan karena pengeluaran aktual melebihi standar normal dengan kerugian sebesar <strong>${moneyFmt(absSelisih)}</strong>.<br><br>`;
            text += `<strong>Saran Evaluasi & Tindakan:</strong><br>`;
            text += `1. <strong>Audit Tenaga Kerja:</strong> Evaluasi ulang rasio jumlah pekerja (Mandays) terhadap hasil produksi di lapangan. Kemungkinan ada pekerja yang kurang produktif atau target luasan (hektar) yang tidak tercapai pada hari tersebut.<br>`;
            text += `2. <strong>Faktor Eksternal:</strong> Segera periksa kondisi blok kebun (apakah medan sulit, curah hujan tinggi, atau alat kerja kurang memadai) yang menyebabkan penyelesaian pekerjaan menjadi lebih lambat dari norma standar.`;
        } else if (selisih < 0) {
            text += `Berdasarkan analisa pada pekerjaan <strong>${jobdesc}</strong>, performa kerja tergolong sangat efisien. Pengeluaran berhasil ditekan dan menghemat budget sebesar <strong>${moneyFmt(absSelisih)}</strong> dari standar normal.<br><br>`;
            text += `<strong>Saran Evaluasi & Tindakan:</strong><br>`;
            text += `1. Pertahankan ritme kerja dan komposisi regu ini untuk pekerjaan serupa di blok lain.<br>`;
            text += `2. Pastikan penghematan ini tidak mengorbankan kualitas pekerjaan (misalnya pemupukan atau panen yang tidak tuntas). Jika kualitas tetap terjaga, berikan apresiasi kepada mandor/pekerja.`;
        } else {
            text += `Pekerjaan <strong>${jobdesc}</strong> berjalan tepat sesuai dengan norma dan budget standar. Tidak ada kerugian maupun penghematan ekstra.<br><br>`;
            text += `<strong>Saran:</strong> Terus pantau konsistensi pekerjaan ini di hari-hari berikutnya.`;
        }
        
        document.getElementById('aiAnalysisText').innerHTML = text;
    }

    function openFlow(key) {
      const d = flowData[key];
      showModal(`
    <button class="close" onclick="closeModal()">✕</button>
    <h2>${d.title}</h2>
    <div class="sub">${d.sub}</div>
    ${buildRows(d.rows)}
    <div class="mfoot">${d.note}</div>
  `);
    }

    function openKpi(key) {
      const d = kpiData[key];
      showModal(`
    <button class="close" onclick="closeModal()">✕</button>
    <h2>${d.title}</h2>
    <div class="sub">${d.sub}</div>
    ${buildRows(d.rows)}
    <div class="mfoot">${d.note}</div>
  `);
    }

    function openRole(key) {
      const d = roleData[key];
      showModal(`
    <button class="close" onclick="closeModal()">✕</button>
    <h2>${d.title}</h2>
    <div class="sub">${d.sub}</div>
    ${buildRows(d.rows)}
    <div class="mfoot">${d.note}</div>
  `);
    }

    function openPoint(waktu, afdeling, kategori, persen) {
      const barColor = persen > 105 ? '#ef4444' : (persen > 100 ? '#f59e0b' : '#22c55e');
      showModal(`
    <button class="close" onclick="closeModal()">✕</button>
    <h2>📍 Titik Data — ${waktu}</h2>
    <div class="sub">${afdeling} · ${kategori}</div>
    <div class="mrow"><span>Persentase realisasi vs budget</span><span>${persen}%</span></div>
    <div class="mbar"><i style="width:${Math.min(persen, 140) / 1.4}%;background:${barColor}"></i></div>
    <div class="mfoot">Klik titik lain pada grafik untuk membandingkan tren anomali di hari yang berbeda.</div>
  `);
    }

    function openAllBudget() {
        const monthNames = ["", "JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];
        
        let rows = masterBudgetData.map(b => {
            let dateObj = new Date(b.bulan);
            let monthName = monthNames[dateObj.getMonth() + 1];
            let displayMonth = monthName ? (monthName.toUpperCase() + ' ' + dateObj.getFullYear()) : (b.bulan || '-');
            return `
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:12px; font-size:12px; font-weight:600; color:var(--text);">${displayMonth}</td>
                    <td style="padding:12px; font-size:12px; color:var(--muted);">${parseFloat(b.jumlah_hk).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    <td style="padding:12px; font-size:12px; font-weight:600; color:var(--accent);">${moneyFmt(b.budget_bulan_rp)}</td>
                </tr>
            `;
        }).join('');

        showModal(`
            <button class="close" onclick="closeModal()">✕</button>
            <h2 style="font-size:16px; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
                💰 Master Budget Keseluruhan
            </h2>
            <div style="max-height: 450px; overflow-y: auto; padding-right:4px;">
                <table style="width:100%; border-collapse:collapse; text-align:left;">
                    <thead style="position:sticky; top:0; background:var(--panel); z-index:1;">
                        <tr style="background:var(--panel2); color:var(--muted);">
                            <th style="padding:12px; font-size:11px; text-transform:uppercase;">Bulan</th>
                            <th style="padding:12px; font-size:11px; text-transform:uppercase;">Jumlah HK</th>
                            <th style="padding:12px; font-size:11px; text-transform:uppercase;">Budget Bulan (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows || '<tr><td colspan="3" style="text-align:center; padding:20px; color:var(--muted)">Belum ada data budget</td></tr>'}
                    </tbody>
                </table>
            </div>
        `);
    }
  </script>
</body>

</html>