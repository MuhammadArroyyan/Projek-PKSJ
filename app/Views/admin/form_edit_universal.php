<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data | Admin Mode</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f1f5f9; font-family: 'Outfit', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 500px; }
        h2 { margin-top: 0; color: #0f172a; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; color: #64748b; font-size: 0.9rem; font-weight: 600; }
        input, select { width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; }
        .btn-save { width: 100%; padding: 1rem; background: #3b82f6; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 1rem; }
        .btn-cancel { display: block; text-align: center; margin-top: 1rem; text-decoration: none; color: #64748b; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="card">
    <h2>Edit Data <?= ucfirst($type) ?></h2>
    
    <form action="/admin/update_data" method="post">
        <input type="hidden" name="type" value="<?= $type ?>">
        <input type="hidden" name="id_asli" value="<?= ($type == 'mahasiswa') ? $record['nim'] : array_values($record)[0] ?>">

        <?php if($type == 'user'): ?>
            <div class="form-group">
                <label>Nama User</label>
                <input type="text" name="nama_user" value="<?= $record['nama_user'] ?>" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="mahasiswa" <?= $record['role']=='mahasiswa'?'selected':'' ?>>Mahasiswa</option>
                    <option value="kaprodi" <?= $record['role']=='kaprodi'?'selected':'' ?>>Kaprodi</option>
                    <option value="pimpinan" <?= $record['role']=='pimpinan'?'selected':'' ?>>Pimpinan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Reset Password (Kosongkan jika tidak ubah)</label>
                <input type="password" name="password" placeholder="Isi password baru...">
            </div>
        <?php endif; ?>

        <?php if($type == 'fakultas'): ?>
            <div class="form-group">
                <label>Nama Fakultas</label>
                <input type="text" name="nama_fakultas" value="<?= $record['nama_fakultas'] ?>" required>
            </div>
        <?php endif; ?>

        <?php if($type == 'jurusan'): ?>
            <div class="form-group">
                <label>Nama Jurusan</label>
                <input type="text" name="nama_jurusan" value="<?= $record['nama_jurusan'] ?>" required>
            </div>
            <div class="form-group">
                <label>Fakultas</label>
                <select name="id_fakultas">
                    <?php foreach($fakultas as $f): ?>
                        <option value="<?= $f['id_fakultas'] ?>" <?= $f['id_fakultas'] == $record['id_fakultas'] ? 'selected' : '' ?>>
                            <?= $f['nama_fakultas'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if($type == 'prodi'): ?>
            <div class="form-group">
                <label>Nama Prodi</label>
                <input type="text" name="nama_prodi" value="<?= $record['nama_prodi'] ?>" required>
            </div>
            <div class="form-group">
                <label>Jurusan</label>
                <select name="id_jurusan">
                    <?php foreach($jurusan as $j): ?>
                        <option value="<?= $j['id_jurusan'] ?>" <?= $j['id_jurusan'] == $record['id_jurusan'] ? 'selected' : '' ?>>
                            <?= $j['nama_jurusan'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Kaprodi</label>
                <select name="id_user_kaprodi">
                    <option value="">-- Kosong --</option>
                    <?php foreach($users as $u): ?>
                        <option value="<?= $u['id_user'] ?>" <?= $u['id_user'] == $record['id_user_kaprodi'] ? 'selected' : '' ?>>
                            <?= $u['nama_user'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if($type == 'mahasiswa'): ?>
            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" value="<?= $record['nim'] ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Mahasiswa</label>
                <input type="text" name="nama_mahasiswa" value="<?= $record['nama_mahasiswa'] ?>" required>
            </div>
            <div class="form-group">
                <label>Linked User</label>
                <select name="id_user">
                    <option value="">-- Unlinked --</option>
                    <?php foreach($users as $u): ?>
                        <option value="<?= $u['id_user'] ?>" <?= $u['id_user'] == $record['id_user'] ? 'selected' : '' ?>>
                            <?= $u['nama_user'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn-save">Simpan Perubahan</button>
        <a href="/admin/dashboard" class="btn-cancel">Batal</a>
    </form>
</div>

</body>
</html>