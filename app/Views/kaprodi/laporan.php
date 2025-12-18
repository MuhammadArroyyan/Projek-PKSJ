<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil | THE PULSE</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Outfit', sans-serif; padding: 2rem; }
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        h2 { margin-top: 0; color: #0f172a; }
        .tag { background: #f59e0b; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; }
        
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th { background: #f1f5f9; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #e2e8f0; }
        
        .stat-box { display: inline-block; margin-right: 15px; background: #f0f9ff; padding: 5px 10px; border-radius: 6px; border: 1px solid #bae6fd; font-size: 0.85rem; }
    </style>
</head>
<body>

    <a href="/kaprodi/dashboard" style="text-decoration: none; color: #64748b; font-weight: 600;">&larr; Kembali</a>
    
    <div style="margin: 1.5rem 0;">
        <h2>Laporan Hasil Kuisioner <span class="tag">Periode: <?= $periode['keterangan'] ?></span></h2>
    </div>

    <div class="card">
        <h3>1. Summary Jawaban (Statistik)</h3>
        <?php foreach($summary as $s): ?>
            <div style="margin-bottom: 1.5rem; border-bottom: 1px dashed #e2e8f0; padding-bottom: 1rem;">
                <p style="font-weight: 700; margin-bottom: 0.5rem;"><?= $s['soal'] ?></p>
                <div>
                    <?php if(!empty($s['stats'])): ?>
                        <?php foreach($s['stats'] as $st): ?>
                            <span class="stat-box">
                                <?= $st['deskripsi_pilihan'] ?>: <strong><?= $st['total'] ?></strong>
                            </span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span style="color: #94a3b8; font-size: 0.8rem;">Belum ada data.</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card">
        <h3>2. Detail Pengisian Mahasiswa</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($detail)): ?>
                    <?php foreach($detail as $d): ?>
                    <tr>
                        <td><strong><?= $d['nama_mahasiswa'] ?></strong></td>
                        <td><?= $d['nim'] ?></td>
                        <td><?= $d['pertanyaan'] ?></td>
                        <td><span style="color: #0369a1; font-weight: 600;"><?= $d['deskripsi_pilihan'] ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align: center; padding: 2rem;">Belum ada mahasiswa yang mengisi.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>