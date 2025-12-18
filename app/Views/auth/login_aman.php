<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aman | THE PULSE</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* CSS ASLI ANDA (SAYA PERTAHANKAN SEMUANYA) */
        :root { --primary: #2563eb; --accent: #3b82f6; --dark: #0f172a; --glass: rgba(255, 255, 255, 0.7); --glass-border: rgba(255, 255, 255, 0.5); }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background: #f8fafc; height: 100vh; display: flex; overflow: hidden; }
        .visual-side { flex: 1.2; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); position: relative; display: flex; flex-direction: column; justify-content: center; padding: 4rem; color: white; overflow: hidden; }
        .visual-side::before { content: ''; position: absolute; top: -20%; left: -20%; width: 80%; height: 80%; background: radial-gradient(circle, rgba(37,99,235,0.4) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; filter: blur(60px); }
        .visual-side h1 { font-size: 4rem; font-weight: 700; line-height: 1.1; margin-bottom: 1rem; position: relative; z-index: 10; }
        .visual-side p { font-size: 1.2rem; opacity: 0.8; max-width: 80%; line-height: 1.6; position: relative; z-index: 10; }
        .highlight { color: var(--accent); }
        .form-side { flex: 1; display: flex; align-items: center; justify-content: center; background: #f1f5f9; position: relative; }
        .glass-card { width: 100%; max-width: 420px; padding: 3rem; background: var(--glass); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid var(--glass-border); border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); animation: floatUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1); }
        .form-title { font-size: 2rem; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem; }
        .form-subtitle { color: #64748b; margin-bottom: 2rem; font-size: 0.95rem; }
        .input-group { margin-bottom: 1.5rem; }
        .input-group label { display: block; margin-bottom: 0.5rem; color: #334155; font-size: 0.9rem; font-weight: 500; }
        .input-group input { width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; transition: all 0.3s ease; background: rgba(255,255,255,0.8); }
        .input-group input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
        .btn-login { width: 100%; padding: 1rem; background: var(--primary); color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2); background: #1d4ed8; }
        .alert { padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.9rem; background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        @keyframes floatUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Tambahan Link Demo */
        .demo-link { display: block; text-align: center; margin-top: 1.5rem; color: #64748b; font-size: 0.85rem; text-decoration: none; }
        .demo-link:hover { color: #ef4444; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="visual-side">
        <h1>LOGIN <br><span class="highlight">SECURE</span></h1>
        <p>Mode Aman: Menggunakan CI4 Query Builder & Bcrypt Hashing.</p>
        <div style="margin-top: 2rem; font-size: 0.8rem; opacity: 0.5;">
            &copy; 2025 Muhammad Arroyyan Hamel
        </div>
    </div>
    <div class="form-side">
        <div class="glass-card">
            <h2 class="form-title">Login</h2>
            <p class="form-subtitle">Mode Aman</p>

            <?php if(session()->getFlashdata('msg')): ?>
                <div class="alert">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/proses_aman') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="nama_user" placeholder="Nama User" required autofocus>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-login">Login Secure &rarr;</button>

                <a href="/auth/login_rawan" class="demo-link">⚠️ Ke Halaman Login Rawan (SQL Injection Demo)</a>
            </form>
        </div>
    </div>
</body>
</html>