<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glitch Academy /// MAINFRAME</title>
    <style>
        body {
            background-color: #0d0208;
            color: <?= ($mode == 'SECURE_MODE') ? '#0041ff' : '#00ff41' ?>; /* Hijau jika Vuln, Biru jika Secure */
            font-family: 'Courier New', Courier, monospace;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            border: 1px dashed currentColor;
            padding: 20px;
        }
        h1 { text-transform: uppercase; border-bottom: 1px solid #333; padding-bottom: 10px; }
        
        /* Form Pencarian */
        .search-box {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }
        input[type="text"] {
            background: #000;
            border: 1px solid #333;
            color: #fff;
            padding: 10px;
            flex-grow: 1;
            font-family: inherit;
        }
        button {
            background: <?= ($mode == 'SECURE_MODE') ? '#0041ff' : '#00ff41' ?>;
            color: #000;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
        }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        th { background-color: #1a1a1a; }
        .logout { float: right; text-decoration: none; color: red; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <a href="<?= ($mode == 'SECURE_MODE') ? '/secure-dashboard/logout' : '/dashboard/logout' ?>" class="logout">[ LOGOUT ]</a>
    
    <h1>/// SYSTEM_DATA: <?= $mode ?></h1>
    <p>USER: <?= $username ?> | ROLE: <?= $role ?></p>

    <div class="search-box">
        <form action="" method="get" style="width: 100%; display: flex; gap: 10px;">
            <input type="text" name="keyword" placeholder="SEARCH STUDENT NAME OR MAJOR..." value="<?= esc($keyword) ?>">
            <button type="submit">SEARCH_DB</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NIM</th>
                <th>NAMA</th>
                <th>JURUSAN</th>
                <th>ALAMAT</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($students)): ?>
                <tr><td colspan="5" style="text-align:center;">DATA NOT FOUND.</td></tr>
            <?php else: ?>
                <?php foreach($students as $mhs): ?>
                <tr>
                    <td><?= $mhs['id'] ?></td>
                    <td><?= $mhs['nim'] ?></td>
                    <td><?= $mhs['nama'] ?></td>
                    <td><?= $mhs['jurusan'] ?></td>
                    <td><?= $mhs['alamat'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>