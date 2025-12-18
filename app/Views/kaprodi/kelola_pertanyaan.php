<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pertanyaan | THE PULSE</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Outfit', sans-serif; padding: 2rem; }
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        .btn-back { text-decoration: none; color: #64748b; font-weight: 600; display: inline-block; margin-bottom: 1rem; }
        input[type="text"] { width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; margin-top: 0.5rem; }
        .btn-add { background: #6366f1; color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 1rem; border-bottom: 1px solid #e2e8f0; text-align: left; }
    </style>
</head>
<body>

    <a href="/kaprodi/dashboard" class="btn-back">&larr; Kembali ke Dashboard</a>

    <div class="card">
        <h2 style="color: #4338ca;">Kelola Pertanyaan: <?= $periode['keterangan'] ?></h2>
        <p style="color: #64748b;">Tambahkan pertanyaan yang akan muncul pada kuisioner periode ini.</p>
        
        <form action="/kaprodi/simpan_pertanyaan" method="post" style="margin-top: 2rem; background: #e0e7ff; padding: 1.5rem; border-radius: 12px;">
            <input type="hidden" name="id_periode" value="<?= $periode['id_periode'] ?>">
            <input type="hidden" name="id_prodi" value="<?= $prodi['id_prodi'] ?>">
            
            <label style="font-weight: 600; color: #3730a3;">Tulis Pertanyaan Baru:</label>
            <input type="text" name="pertanyaan" placeholder="Contoh: Bagaimana kejelasan materi kuliah?" required>
            <button type="submit" class="btn-add">+ Tambahkan ke Kuisioner</button>
        </form>
    </div>

    <div class="card">
        <h3>Daftar Pertanyaan di Periode Ini</h3>
        <table>
            <thead><tr><th>No</th><th>Pertanyaan</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if(!empty($list_pertanyaan)): ?>
                    <?php foreach($list_pertanyaan as $i => $p): ?>
                    <tr>
                        <td width="5%"><?= $i + 1 ?></td>
                        <td><?= $p['pertanyaan'] ?></td>
                        <td width="15%">
                            <a href="/kaprodi/hapus_pertanyaan/<?= $p['id_pertanyaan_periode_kuisioner'] ?>/<?= $periode['id_periode'] ?>" 
                               style="color: #ef4444; text-decoration: none; font-weight: 600;"
                               onclick="return confirm('Hapus pertanyaan ini dari periode?');">
                               Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" style="text-align: center; color: #94a3b8;">Belum ada pertanyaan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>