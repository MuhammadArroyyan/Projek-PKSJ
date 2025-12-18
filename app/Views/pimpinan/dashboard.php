<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Executive Summary | THE PULSE</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --primary: #0f172a; --bg: #f8fafc; }
        body { background: var(--bg); font-family: 'Outfit', sans-serif; padding: 2rem; color: #334155; }

        /* Header & Nav */
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.2rem 2rem; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
        .logo { font-size: 1.4rem; font-weight: 700; color: var(--primary); }
        .badge { background: #ffedd5; color: #9a3412; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; letter-spacing: 1px; margin-left: 8px; }
        .btn-logout { text-decoration: none; color: #ef4444; font-weight: 600; font-size: 0.9rem; }

        /* Filter Control */
        .controls { background: white; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; border: 1px solid #e2e8f0; }
        select { padding: 0.7rem 1rem; border-radius: 8px; border: 1px solid #cbd5e1; font-family: inherit; min-width: 250px; }
        .btn-filter { background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; }

        /* Report Layout */
        .report-grid { display: grid; gap: 2rem; }
        
        .report-card { 
            background: white; border-radius: 16px; overflow: hidden; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
            border: 1px solid #f1f5f9;
            display: grid; grid-template-columns: 300px 1fr; /* Kiri Grafik, Kanan Data */
        }

        .chart-area { 
            padding: 2rem; background: #f8fafc; border-right: 1px solid #e2e8f0; 
            display: flex; align-items: center; justify-content: center;
        }
        .data-area { padding: 2rem; }

        .prodi-tag { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #64748b; font-weight: 700; display: block; margin-bottom: 0.5rem; }
        h3 { margin: 0 0 1.5rem 0; font-size: 1.25rem; color: var(--primary); line-height: 1.4; }

        /* Data Bars */
        .bar-row { display: flex; align-items: center; margin-bottom: 0.8rem; font-size: 0.9rem; }
        .bar-label { width: 120px; font-weight: 600; }
        .bar-track { flex: 1; height: 8px; background: #f1f5f9; border-radius: 10px; margin: 0 15px; overflow: hidden; }
        .bar-fill { height: 100%; background: #3b82f6; border-radius: 10px; }
        .bar-value { width: 40px; text-align: right; color: #64748b; }

        .total-respondents { margin-top: 1.5rem; padding-top: 1rem; border-top: 1px dashed #e2e8f0; font-size: 0.9rem; color: #64748b; }

        @media (max-width: 768px) {
            .report-card { grid-template-columns: 1fr; }
            .chart-area { border-right: none; border-bottom: 1px solid #e2e8f0; height: 250px; }
        }
    </style>
</head>
<body>

    <div class="nav">
        <div class="logo">THE PULSE <span class="badge">EXECUTIVE DASHBOARD</span></div>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>

    <div class="controls">
        <form action="" method="get" style="display: flex; align-items: center; gap: 1rem; width: 100%;">
            <label style="font-weight: 600; color: #475569;">Pilih Periode Laporan:</label>
            <select name="periode">
                <?php foreach($all_periode as $p): ?>
                    <option value="<?= $p['id_periode'] ?>" <?= ($p['id_periode'] == $selected_id) ? 'selected' : '' ?>>
                        <?= $p['keterangan'] ?> (<?= strtoupper($p['status_periode']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-filter">Tampilkan Data</button>
        </form>
    </div>

    <div class="report-grid">
        <?php if(!empty($laporan)): ?>
            <?php foreach($laporan as $item): ?>
                <div class="report-card">
                    <div class="chart-area">
                        <div style="width: 100%; max-width: 200px;">
                            <canvas id="chart-<?= $item['id_pertanyaan'] ?>"></canvas>
                        </div>
                    </div>

                    <div class="data-area">
                        <span class="prodi-tag"><?= $item['prodi'] ?></span>
                        <h3><?= $item['soal'] ?></h3>

                        <?php foreach($item['opsi'] as $op): ?>
                            <?php 
                                // Hitung Persentase
                                $percent = ($item['total_responden'] > 0) ? ($op['total_pilih'] / $item['total_responden']) * 100 : 0;
                            ?>
                            <div class="bar-row">
                                <div class="bar-label"><?= $op['deskripsi_pilihan'] ?></div>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width: <?= $percent ?>%;"></div>
                                </div>
                                <div class="bar-value">
                                    <strong><?= $op['total_pilih'] ?></strong> <span style="font-size:0.7em; opacity:0.6;">(<?= round($percent) ?>%)</span>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="total-respondents">
                            Total Responden: <strong><?= $item['total_responden'] ?> Mahasiswa</strong>
                        </div>
                    </div>
                </div>

                <script>
                    new Chart(document.getElementById('chart-<?= $item['id_pertanyaan'] ?>'), {
                        type: 'doughnut',
                        data: {
                            labels: <?= json_encode($item['chart_labels']) ?>,
                            datasets: [{
                                data: <?= json_encode($item['chart_data']) ?>,
                                backgroundColor: [
                                    '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1'
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            plugins: { legend: { display: false } },
                            cutout: '70%',
                            responsive: true
                        }
                    });
                </script>

            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 4rem; background: white; border-radius: 12px; color: #94a3b8; border: 2px dashed #e2e8f0;">
                <h3 style="color: #cbd5e1;">Tidak Ada Data</h3>
                <p>Pilih periode lain atau tunggu mahasiswa mengisi kuisioner.</p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>