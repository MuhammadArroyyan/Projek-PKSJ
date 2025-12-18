<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Command Center | THE PULSE</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0f172a; --highlight: #3b82f6; --bg: #f8fafc; }
        body { background: var(--bg); font-family: 'Outfit', sans-serif; padding: 2rem; color: #334155; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .logo { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
        .btn-logout { color: #ef4444; text-decoration: none; font-weight: 600; }

        /* TABS NAVIGATION */
        .tabs-nav { display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem; }
        .tab-btn {
            padding: 0.8rem 1.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 8px; 
            cursor: pointer; font-weight: 600; font-family: inherit; transition: 0.3s; color: #64748b;
        }
        .tab-btn:hover { background: #f1f5f9; }
        
        /* Active Tab Style */
        .tab-btn.active {
            background: var(--primary); color: white; border-color: var(--primary); box-shadow: 0 4px 10px rgba(15, 23, 42, 0.2);
        }

        /* TAB CONTENT AREAS */
        .tab-content { display: none; animation: slideUp 0.4s ease-out; }
        .tab-content.active { display: block; }

        /* CARDS & FORMS */
        .card { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 2rem; border: 1px solid #f1f5f9; }
        h2 { font-size: 1.25rem; margin-bottom: 1.5rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.5rem; color: var(--primary); }
        
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 1rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-size: 0.85rem; color: #64748b; margin-bottom: 0.5rem; font-weight: 600; }
        input, select { width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; }
        input:focus, select:focus { border-color: var(--highlight); outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        
        .btn-save { background: var(--highlight); color: white; border: none; padding: 0.75rem 2rem; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; transition: 0.2s; }
        .btn-save:hover { background: #2563eb; transform: translateY(-2px); }

        /* DATA TABLES */
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 0.9rem; }
        th { text-align: left; padding: 1rem; background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 2px solid #e2e8f0; }
        td { padding: 1rem; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        
        .role-badge { padding: 4px 10px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .role-admin { background: #e0e7ff; color: #3730a3; }
        .role-kaprodi { background: #f3e8ff; color: #6b21a8; }
        .role-mahasiswa { background: #dcfce7; color: #166534; }
        .role-pimpinan { background: #ffedd5; color: #9a3412; }

        @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">ADMIN</div>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div style="background: #dcfce7; color: #166534; padding: 1rem; margin-bottom: 2rem; border-radius: 8px; border: 1px solid #bbf7d0;">
            ✅ <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div style="background: #fee2e2; color: #991b1b; padding: 1rem; margin-bottom: 2rem; border-radius: 8px; border: 1px solid #fecaca;">
            ⛔ <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="tabs-nav">
        <button class="tab-btn active" onclick="openTab(event, 'tab-users')">1. User & Role</button>
        <button class="tab-btn" onclick="openTab(event, 'tab-akademik')">2. Akademik (Fakultas/Prodi)</button>
        <button class="tab-btn" onclick="openTab(event, 'tab-mahasiswa')">3. Data Mahasiswa</button>
    </div>

    <div id="tab-users" class="tab-content active">
        <div class="card">
            <h2>Buat User Baru (Poin 1.a)</h2>
            <form action="/admin/tambah_user" method="post">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Username / Nama</label>
                        <input type="text" name="nama_user" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="form-group">
                        <label>Role User</label>
                        <select name="role">
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="kaprodi">Kaprodi</option>
                            <option value="pimpinan">Pimpinan</option>
                            </select>
                    </div>
                </div>
                <button type="submit" class="btn-save">Simpan User</button>
            </form>

            <h3 style="margin-top:2rem; margin-bottom:1rem; color:#475569;">Daftar User Terdaftar</h3>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>ID</th><th>Nama User</th><th>Role</th></tr></thead>
                    <tbody>
                        <?php foreach($users as $u): ?>
                            <tr>
                                <td>#<?= $u['id_user'] ?></td>
                                <td><strong><?= $u['nama_user'] ?></strong></td>
                                <td>
                                    <span class="role-badge role-<?= $u['role'] ?>"><?= $u['role'] ?></span>
                                </td>
                                <td>
                                    <a href="/admin/edit/user/<?= $u['id_user'] ?>" style="color:#2563eb; margin-right:5px;">Edit</a>
                                    <a href="/admin/hapus_user/<?= $u['id_user'] ?>" style="color:#ef4444;" onclick="return confirm('Hapus User ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tab-akademik" class="tab-content">
        <div class="form-grid">
            <div class="card">
                <h2>+ Tambah Fakultas</h2>
                <form action="/admin/tambah_fakultas" method="post">
                    <div class="form-group">
                        <label>Nama Fakultas</label>
                        <input type="text" name="nama_fakultas" required placeholder="Contoh: FTTK">
                    </div>
                    <button type="submit" class="btn-save">Simpan Fakultas</button>
                </form>
            </div>
            <div class="card">
                <h2>+ Tambah Jurusan</h2>
                <form action="/admin/tambah_jurusan" method="post">
                    <div class="form-group">
                        <label>Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" required placeholder="Contoh: Teknik Informatika">
                    </div>
                    <div class="form-group">
                        <label>Pilih Fakultas</label>
                        <select name="id_fakultas">
                            <?php foreach($fakultas as $f): ?>
                                <option value="<?= $f['id_fakultas'] ?>"><?= $f['nama_fakultas'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-save">Simpan Jurusan</button>
                </form>
            </div>
        </div>

        <div class="card">
            <h2>+ Tambah Prodi & Assign Kaprodi</h2>
            <form action="/admin/tambah_prodi" method="post">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Prodi</label>
                        <input type="text" name="nama_prodi" required placeholder="Contoh: Sistem Informasi">
                    </div>
                    <div class="form-group">
                        <label>Pilih Jurusan</label>
                        <select name="id_jurusan">
                            <?php foreach($jurusan as $j): ?>
                                <option value="<?= $j['id_jurusan'] ?>"><?= $j['nama_jurusan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Assign User Kaprodi</label>
                        <select name="id_user_kaprodi">
                            <option value="">-- Pilih User dengan Role Kaprodi --</option>
                            <?php foreach($users as $u): ?>
                                <?php if($u['role'] == 'kaprodi'): ?>
                                    <option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <small style="color: #64748b;">*Hanya user dengan role 'Kaprodi' yang muncul disini.</small>
                    </div>
                </div>
                <button type="submit" class="btn-save">Simpan Prodi</button>
            </form>

            <h3 style="margin-top:2rem; margin-bottom:1rem; color:#475569;">Data Prodi & Kaprodi</h3>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Prodi</th><th>Jurusan</th><th>Kaprodi Menjabat</th></tr></thead>
                    <tbody>
                        <?php foreach($prodi as $p): ?>
                        <tr>
                            <td><strong><?= $p['nama_prodi'] ?></strong></td>
                            <td><?= $p['nama_jurusan'] ?></td>
                            <td>
                                <?php if($p['nama_kaprodi']): ?>
                                    <span style="color: #0f172a; font-weight:600;">👤 <?= $p['nama_kaprodi'] ?></span>
                                <?php else: ?>
                                    <span style="color: #cbd5e1;">- Belum diset -</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/admin/edit/prodi/<?= $p['id_prodi'] ?>" style="color:#2563eb; margin-right:5px;">Edit</a>
                                <a href="/admin/hapus_prodi/<?= $p['id_prodi'] ?>" style="color:#ef4444;" onclick="return confirm('Hapus Prodi ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tab-mahasiswa" class="tab-content">
        <div class="card">
            <h2>Buat Data Mahasiswa (Link ke User)</h2>
            <p style="background: #eff6ff; color: #1e40af; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                <strong>Panduan:</strong> Sebelum mengisi form ini, pastikan Anda sudah membuat <strong>User Login</strong> dengan role 'Mahasiswa' di Tab 1.
            </p>
            
            <form action="/admin/tambah_mahasiswa" method="post">
                <div class="form-grid">
                    <div class="form-group">
                        <label>NIM Mahasiswa</label>
                        <input type="text" name="nim" required placeholder="Nomor Induk Mahasiswa">
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_mahasiswa" required placeholder="Sesuai KTM">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Hubungkan ke Akun User (Login)</label>
                        <select name="id_user">
                            <option value="">-- Pilih Akun User --</option>
                            <?php foreach($users as $u): ?>
                                <?php if($u['role'] == 'mahasiswa'): ?>
                                    <option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?> (ID: <?= $u['id_user'] ?>)</option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-save">Simpan Data Mahasiswa</button>
            </form>

            <h3 style="margin-top:2rem; margin-bottom:1rem; color:#475569;">Data Mahasiswa Terdaftar</h3>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>NIM</th><th>Nama Mahasiswa</th><th>Status Akun</th></tr></thead>
                    <tbody>
                        <?php foreach($mahasiswa as $m): ?>
                            <tr>
                                <td><code><?= $m['nim'] ?></code></td>
                                <td><?= $m['nama_mahasiswa'] ?></td>
                                <td>
                                    <?php if($m['nama_user']): ?>
                                        <span style="color: #166534; font-weight:600;">✅ Linked: <?= $m['nama_user'] ?></span>
                                    <?php else: ?>
                                        <span style="color: #ef4444; font-weight:600;">⚠️ Unlinked</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="/admin/edit/mahasiswa/<?= $m['nim'] ?>" style="color:#2563eb; margin-right:5px;">Edit</a>
                                    <a href="/admin/hapus_mahasiswa/<?= $m['nim'] ?>" style="color:#ef4444;" onclick="return confirm('Hapus Mahasiswa ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

</body>
</html>