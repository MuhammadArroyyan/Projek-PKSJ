<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kaprodi | THE PULSE</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #6366f1; --bg: #f8fafc; --text: #1e293b; } /* Indigo Theme */
        body { background: var(--bg); font-family: 'Outfit', sans-serif; color: var(--text); padding: 2rem; }
        
        /* Navbar */
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; }
        .logo { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
        .role-badge { background: #e0e7ff; color: #4338ca; padding: 0.2rem 0.8rem; border-radius: 5px; font-size: 0.8rem; vertical-align: middle; margin-left: 0.5rem; }
        .btn-logout { text-decoration: none; color: #ef4444; font-weight: 600; font-size: 0.9rem; }

        /* Main Layout */
        .container { display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; }

        /* Form Card */
        .card { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        h2 { margin-bottom: 1.5rem; font-size: 1.25rem; }

        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: #64748b; }
        input[type="text"] { width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; }
        
        .btn-submit { background: var(--primary); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; }
        .btn-submit:hover { background: #4f46e5; }

        /* Table Style */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { text-align: left; padding: 1rem; background: #f1f5f9; color: #475569; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 1rem; border-bottom: 1px solid #e2e8f0; }
        
        .badge { padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
        .badge-aktif { background: #dcfce7; color: #166534; }
        .badge-non { background: #f1f5f9; color: #64748b; }

        .btn-sm { text-decoration: none; font-size: 0.8rem; padding: 0.4rem 0.8rem; border-radius: 6px; background: #3b82f6; color: white; }
        .btn-sm:hover { opacity: 0.9; }
    </style>
</head>
<body>

    <div class="nav">
        <div class="logo">THE PULSE <span class="role-badge">KAPRODI</span></div>
        <div>
            <span style="margin-right: 1rem;"><?= $nama_user ?></span>
            <a href="/logout" class="btn-logout">Logout</a>
        </div>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="card">
            <h2>+ Buat Periode Baru</h2>
            <form action="/kaprodi/tambah_periode" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>Keterangan Periode</label>
                    <input type="text" name="keterangan" placeholder="Contoh: Ganjil 2025/2026" required>
                </div>
                <button type="submit" class="btn-submit">Simpan Periode</button>
            </form>
            <p style="margin-top: 1rem; font-size: 0.8rem; color: #94a3b8;">
                *Periode baru akan dibuat dalam status Non-Aktif secara default.
            </p>
        </div>

        <div class="card">
            <h2>Daftar Periode Kuisioner</h2>
            <table>
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($periode)): ?>
                        <?php foreach($periode as $p): ?>
                        <tr>
                            <td><strong><?= $p['keterangan'] ?></strong></td>
                            <td>
                                <?php if($p['status_periode'] == 'aktif'): ?>
                                    <span class="badge badge-aktif">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-non">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($p['status_periode'] == 'non-aktif'): ?>
                                    <a href="/kaprodi/aktifkan/<?= $p['id_periode'] ?>" class="btn-sm" style="background:#22c55e;">Aktifkan</a>
                                <?php else: ?>
                                    <span class="badge badge-aktif">Sedang Aktif</span>
                                <?php endif; ?>

                                <span style="margin: 0 5px; color:#cbd5e1;">|</span>

                                <a href="/kaprodi/kelola_pertanyaan/<?= $p['id_periode'] ?>" class="btn-sm" style="background:#6366f1;">
                                    ⚙️ Kelola Soal
                                </a>

                                <a href="/kaprodi/laporan/<?= $p['id_periode'] ?>" class="btn-sm" style="background:#f59e0b;">
                                    📊 Laporan
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center; color:#94a3b8;">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>