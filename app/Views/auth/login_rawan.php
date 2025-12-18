<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Rawan | VULNERABLE</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* TEMA GELAP / MERAH UNTUK INDIKATOR BAHAYA */
        :root { --primary: #ef4444; --accent: #f87171; --dark: #0f172a; --glass: rgba(30, 10, 10, 0.85); --glass-border: rgba(239, 68, 68, 0.3); }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background: #1a0505; height: 100vh; display: flex; overflow: hidden; }
        
        .visual-side { flex: 1.2; background: linear-gradient(135deg, #000000 0%, #2a0505 100%); position: relative; display: flex; flex-direction: column; justify-content: center; padding: 4rem; color: white; overflow: hidden; }
        .visual-side::before { content: ''; position: absolute; top: -20%; left: -20%; width: 80%; height: 80%; background: radial-gradient(circle, rgba(239,68,68,0.2) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; filter: blur(60px); }
        .visual-side h1 { font-size: 4rem; font-weight: 700; line-height: 1.1; margin-bottom: 1rem; position: relative; z-index: 10; color: #fca5a5; }
        .visual-side p { font-size: 1.2rem; opacity: 0.8; max-width: 80%; line-height: 1.6; position: relative; z-index: 10; color: #fecaca; }
        .highlight { color: var(--primary); text-shadow: 0 0 20px red; }
        
        .form-side { flex: 1; display: flex; align-items: center; justify-content: center; background: #0f0202; position: relative; }
        .glass-card { width: 100%; max-width: 420px; padding: 3rem; background: var(--glass); backdrop-filter: blur(20px); border: 1px solid var(--glass-border); border-radius: 24px; box-shadow: 0 20px 40px rgba(255,0,0,0.1); }
        
        .form-title { font-size: 2rem; font-weight: 600; color: #ef4444; margin-bottom: 0.5rem; }
        .form-subtitle { color: #9ca3af; margin-bottom: 2rem; font-size: 0.95rem; }
        
        .input-group { margin-bottom: 1.5rem; }
        .input-group label { display: block; margin-bottom: 0.5rem; color: #fca5a5; font-size: 0.9rem; font-weight: 500; }
        .input-group input { width: 100%; padding: 1rem; border: 2px solid #450a0a; border-radius: 12px; font-size: 1rem; transition: all 0.3s ease; background: #2a0a0a; color: white; }
        .input-group input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2); }
        
        .btn-login { width: 100%; padding: 1rem; background: var(--primary); color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(239, 68, 68, 0.4); background: #dc2626; }
        
        .alert { padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.9rem; background: #450a0a; color: #fecaca; border: 1px solid #7f1d1d; }
        .demo-link { display: block; text-align: center; margin-top: 1.5rem; color: #6b7280; font-size: 0.85rem; text-decoration: none; }
        .demo-link:hover { color: #3b82f6; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="visual-side">
        <h1>LOGIN <br><span class="highlight">VULNERABLE</span></h1>
        <p>Mode Rawan: Menggunakan Raw SQL & Concatenation String.</p>
        <p style="margin-top:1rem; font-size:0.9rem; color:#ef4444;">💀 Target Demo: SQL Injection Bypass</p>
    </div>
    <div class="form-side">
        <div class="glass-card">
            <h2 class="form-title">⚠️ MODE RAWAN</h2>
            <p class="form-subtitle">Form ini rentan terhadap serangan injeksi.</p>

            <?php if(session()->getFlashdata('msg')): ?>
                <div class="alert">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/proses_rawan') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="input-group">
                    <label>Username (Inject Here)</label>
                    <input type="text" name="nama_user" placeholder="Coba: Admin' #" required autofocus>
                </div>

                <div class="input-group">
                    <label>Password (Ignored)</label>
                    <input type="password" name="password" placeholder="Diabaikan saat bypass...">
                </div>

                <button type="submit" class="btn-login">Login (Unsafe) &rarr;</button>

                <a href="/auth/login" class="demo-link">🛡️ Kembali ke Login Aman</a>
            </form>
        </div>
    </div>
</body>
</html>