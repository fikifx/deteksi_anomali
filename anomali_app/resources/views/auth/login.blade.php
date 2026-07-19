<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login – Deteksi Anomali</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg-deep: #0a0f1a;
      --bg-card: rgba(15,25,45,0.85);
      --border: rgba(56,189,130,0.18);
      --border-h: rgba(56,189,130,0.45);
      --accent: #38bd82;
      --accent-d: #25a06a;
      --accent-l: #5ee8a8;
      --text-1: #e8f5ef;
      --text-2: #8ab8a0;
      --text-3: #4d7a62;
      --danger: #ff5c6a;
      --radius: 14px;
    }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg-deep);
      color: var(--text-1);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-image:
        radial-gradient(ellipse 80% 60% at 20% -10%, rgba(56,189,130,0.12) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 80% 110%, rgba(79,195,247,0.07) 0%, transparent 60%);
    }
    .login-container {
      width: 100%;
      max-width: 420px;
      padding: 40px;
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      backdrop-filter: blur(20px);
      box-shadow: 0 16px 48px rgba(0,0,0,0.4);
    }
    .logo-container {
      text-align: center;
      margin-bottom: 30px;
    }
    .logo-icon {
      width: 60px;
      height: 60px;
      border-radius: 16px;
      background: linear-gradient(135deg, var(--accent), var(--accent-d));
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      margin-bottom: 16px;
      box-shadow: 0 4px 20px rgba(56,189,130,0.35);
    }
    .logo-container h1 {
      font-size: 22px;
      font-weight: 800;
      color: var(--text-1);
    }
    .logo-container p {
      font-size: 13px;
      color: var(--text-2);
      margin-top: 6px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-2);
      margin-bottom: 8px;
    }
    .form-group input {
      width: 100%;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px 16px;
      color: var(--text-1);
      font-size: 14px;
      font-family: inherit;
      transition: .2s;
      outline: none;
    }
    .form-group input:focus {
      border-color: var(--border-h);
      background: rgba(56,189,130,0.06);
    }
    .btn {
      width: 100%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      padding: 14px 18px;
      border-radius: 10px;
      border: none;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      font-family: inherit;
      transition: .2s;
      background: linear-gradient(135deg, var(--accent), var(--accent-d));
      color: #fff;
      box-shadow: 0 4px 14px rgba(56,189,130,0.3);
      margin-top: 10px;
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(56,189,130,0.45);
    }
    .error-msg {
      background: rgba(255,92,106,0.1);
      color: var(--danger);
      border: 1px solid rgba(255,92,106,0.2);
      padding: 12px;
      border-radius: 10px;
      font-size: 13px;
      margin-bottom: 20px;
      text-align: center;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      font-size: 13px;
      color: var(--text-3);
      text-decoration: none;
      transition: .2s;
    }
    .back-link:hover {
      color: var(--accent);
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="logo-container">
      <div class="logo-icon">🌴</div>
      <h1>Deteksi Anomali</h1>
      <p>Masuk ke Panel Administrator</p>
    </div>

    @if($errors->any())
      <div class="error-msg">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@anomali.com" autofocus />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required placeholder="••••••••" />
      </div>
      <button type="submit" class="btn">🚀 Login Sekarang</button>
    </form>

    <a href="{{ route('dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
  </div>

</body>
</html>
