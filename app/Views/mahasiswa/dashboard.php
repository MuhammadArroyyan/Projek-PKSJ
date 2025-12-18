<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa | THE PULSE</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2563eb; --bg: #f8fafc; --text: #1e293b; }
        body { background: var(--bg); font-family: 'Outfit', sans-serif; color: var(--text); padding: 2rem; }
        
        /* Navbar Simple */
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; }
        .logo { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
        .btn-logout { text-decoration: none; color: #ef4444; font-weight: 600; border: 2px solid #fee2e2; padding: 0.5rem 1.5rem; border-radius: 50px; transition: 0.3s; }
        .btn-logout:hover { background: #fee2e2; }

        /* Welcome Section */
        .welcome { margin-bottom: 2rem; }
        .welcome h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .welcome p { color: #64748b; }

        /* Grid System */
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }

        /* Card Design */
        .card { 
            background: white; padding: 2rem; border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;
            transition: transform 0.2s;
        }
        .card:hover { transform: translateY(-5px); border-color: var(--primary); }
        
        .status-badge { 
            display: inline-block; padding: 0.25rem 0.75rem; border-radius: 50px; 
            font-size: 0.8rem; font-weight: 600; background: #dcfce7; color: #166534; margin-bottom: 1rem;
        }
        
        .card h3 { font-size: 1.25rem; margin-bottom: 1rem; }
        .card p { color: #64748b; font-size: 0.9rem; margin-bottom: 2rem; line-height: 1.6; }

        .btn-action { 
            display: block; width: 100%; text-align: center; padding: 1rem; 
            background: var(--primary); color: white; text-decoration: none; border-radius: 12px; font-weight: 600; 
        }
        .btn-action:hover { background: #1d4ed8; }
        
        .empty-state {
            grid-column: 1 / -1; text-align: center; padding: 4rem; 
            background: white; border-radius: 20px; border: 2px dashed #cbd5e1; color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="nav">
        <div class="logo">THE PULSE</div>
        <div>
            <span style="margin-right: 1rem; font-weight: 600;"><?= $nama_user ?></span>
            <a href="/logout" class="btn-logout">Logout</a>
        </div>
    </div>

    <div class="welcome">
        <h1>Dashboard Mahasiswa</h1>
        <p>Silakan pilih periode kuisioner yang tersedia untuk diisi.</p>
    </div>

    <div class="grid">
        <?php if (!empty($periode_aktif)): ?>
            <?php foreach ($periode_aktif as $p): ?>
                <div class="card">
                    <span class="status-badge">● Aktif</span>
                    <h3><?= $p['keterangan'] ?></h3>
                    <p>Periode ini sedang berlangsung. Partisipasi Anda sangat penting untuk evaluasi mutu akademik.</p>
                    
                    <a href="/mahasiswa/isi_kuisioner/<?= $p['id_periode'] ?>" class="btn-action">
                        Mulai Pengisian &rarr;
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <h3>Belum ada Periode Aktif</h3>
                <p>Saat ini tidak ada kuisioner yang perlu diisi.</p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>