<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Kuisioner | THE PULSE</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2563eb; --bg: #f8fafc; --text: #1e293b; }
        body { background: var(--bg); font-family: 'Outfit', sans-serif; color: var(--text); padding-bottom: 5rem; }
        
        /* Header Sticky */
        .header { 
            position: sticky; top: 0; background: rgba(255,255,255,0.9); 
            backdrop-filter: blur(10px); padding: 1.5rem; border-bottom: 1px solid #e2e8f0; z-index: 100;
            display: flex; justify-content: space-between; align-items: center;
        }
        .btn-back { text-decoration: none; color: #64748b; font-weight: 600; }
        .progress-title { font-weight: 700; color: var(--primary); }

        /* Container */
        .container { max-width: 700px; margin: 3rem auto; padding: 0 1.5rem; }

        /* Question Card */
        .q-card { 
            background: white; padding: 2.5rem; border-radius: 20px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 2rem;
            border: 1px solid #f1f5f9;
        }
        .q-number { 
            text-transform: uppercase; letter-spacing: 2px; font-size: 0.75rem; 
            color: #94a3b8; font-weight: 700; margin-bottom: 1rem; display: block;
        }
        .q-text { font-size: 1.35rem; font-weight: 600; margin-bottom: 2rem; line-height: 1.4; }

        /* Custom Radio Options */
        .options-grid { display: grid; gap: 1rem; }
        .option-label { 
            display: flex; align-items: center; padding: 1.2rem; border: 2px solid #e2e8f0; 
            border-radius: 12px; cursor: pointer; transition: all 0.2s; position: relative; overflow: hidden;
        }
        .option-label:hover { border-color: #bfdbfe; background: #eff6ff; }
        
        /* Hidden Radio Input */
        .option-input { position: absolute; opacity: 0; }
        
        /* Active State */
        .option-input:checked + .option-content { color: var(--primary); font-weight: 700; }
        .option-input:checked ~ .option-bg { opacity: 1; }
        
        /* Fake Border for Checked */
        .option-label:has(.option-input:checked) { border-color: var(--primary); background: #eff6ff; }

        .btn-submit {
            display: block; width: 100%; max-width: 700px; margin: 0 auto;
            padding: 1.5rem; background: var(--primary); color: white; border: none;
            border-radius: 16px; font-size: 1.1rem; font-weight: 700; cursor: pointer;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3); transition: transform 0.2s;
        }
        .btn-submit:hover { transform: translateY(-3px); background: #1d4ed8; }

    </style>
</head>
<body>

    <div class="header">
        <a href="/mahasiswa/dashboard" class="btn-back">&larr; Batal</a>
        <div class="progress-title">FORMULIR EVALUASI</div>
        <div style="width: 50px;"></div> </div>

    <form action="/mahasiswa/simpan_jawaban" method="post" class="container">
        <?= csrf_field() ?>
        <input type="hidden" name="id_periode" value="<?= $id_periode ?>">

        <?php if(!empty($pertanyaan)): ?>
            <?php foreach($pertanyaan as $index => $p): ?>
                <div class="q-card">
                    <span class="q-number">Pertanyaan <?= $index + 1 ?></span>
                    <h3 class="q-text"><?= $p['pertanyaan'] ?></h3>
                    
                    <div class="options-grid">
                        <?php foreach($p['pilihan'] as $opt): ?>
                            <?php 
                                $isChecked = (isset($existing_answers[$p['id_pertanyaan']]) && $existing_answers[$p['id_pertanyaan']] == $opt['id_pilihan_jawaban']) ? 'checked' : '';
                            ?>
                            <label class="option-label">
                                <input type="radio" name="jawaban[<?= $p['id_pertanyaan'] ?>]" value="<?= $opt['id_pilihan_jawaban'] ?>" class="option-input" required <?= $isChecked ?>>
                                <span class="option-content"><?= $opt['deskripsi_pilihan'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <button type="submit" class="btn-submit">Kirim Jawaban</button>
        <?php else: ?>
            <div class="q-card" style="text-align: center;">
                <h3>Tidak ada pertanyaan untuk Prodi Anda.</h3>
                <p>Silakan hubungi Kaprodi.</p>
            </div>
        <?php endif; ?>
    </form>

</body>
</html>