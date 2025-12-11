<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glitch Academy /// MAINFRAME</title>
    <?php 
        // Tentukan warna tema di sini agar konsisten
        $themeColor = ($mode == 'SECURE_MODE') ? '#0041ff' : '#00ff41'; 
    ?>
    <style>
        /* --- RESET & BASE --- */
        * { box-sizing: border-box; }
        body {
            background-color: #0d0208;
            color: <?= $themeColor ?>; /* Warna Teks Utama */
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        /* --- CONTAINER UTAMA --- */
        .container {
            width: 100%;
            max-width: 900px;
            border: 2px solid <?= $themeColor ?>;
            padding: 20px;
            box-shadow: 0 0 15px <?= $themeColor ?>;
            position: relative;
            background: #0d0208;
        }

        /* --- HEADER AREA --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
            font-size: 1.8rem;
            text-transform: uppercase;
            text-shadow: 2px 2px #000;
            animation: glitch 1s infinite alternate;
        }

        .logout-btn {
            text-decoration: none;
            color: #fff;
            background-color: #ff0055;
            padding: 5px 10px;
            font-weight: bold;
            border: 1px solid #ff0055;
            font-size: 0.9rem;
        }
        .logout-btn:hover {
            background-color: #000;
            color: #ff0055;
        }

        /* --- INFO USER --- */
        .user-info p { margin: 5px 0; font-size: 0.9rem;}
        
        /* --- FORM PENCARIAN --- */
        .search-box {
            margin: 20px 0;
            display: flex;
            gap: 0; /* Rapatkan gap agar menyatu */
        }
        input[type="text"] {
            flex-grow: 1;
            background: #000;
            border: 1px solid #333;
            border-left: 4px solid <?= $themeColor ?>;
            color: #fff;
            padding: 15px;
            font-family: inherit;
            font-size: 1.1rem;
            outline: none;
        }
        input[type="text"]:focus {
            background: #111;
            border-color: <?= $themeColor ?>;
        }
        
        /* PERBAIKAN TOMBOL DI SINI */
        button {
            padding: 0 25px;
            background-color: <?= $themeColor ?>; /* Warna background eksplisit */
            color: #000; /* Warna teks tombol hitam */
            border: none;
            font-weight: 900;
            font-size: 1rem;
            cursor: pointer;
            font-family: inherit;
            text-transform: uppercase;
            transition: all 0.3s;
        }
        button:hover { 
            background-color: #fff; 
            box-shadow: 0 0 10px #fff;
        }

        /* --- TABEL DATA --- */
        h3 { border-top: 1px dashed #333; padding-top: 15px; margin-top: 20px; font-size: 1rem;}
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #333;
        }
        th, td {
            border: 1px solid #333;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #1a1a1a;
            color: #fff;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        tr:nth-child(even) { background-color: #0a0a0a; }
        tr:hover { background-color: #111; color: #fff; }

        /* --- ANIMASI --- */
        @keyframes glitch {
            0% { text-shadow: 2px 0 red, -2px 0 blue; }
            100% { text-shadow: -2px 0 red, 2px 0 blue; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <h1>/// SYSTEM_DATA: <?= $mode ?></h1>
            <div class="user-info" style="margin-top: 10px;">
                <p>USER: <strong><?= $username ?></strong> | ROLE: <strong><?= $role ?></strong></p>\
                <p><a href="<?= site_url($mode == 'SECURE_MODE' ? 'secure-dashboard/profile' : 'dashboard/profile') ?>" style="color: yellow; font-size: 0.9em;">[ EDIT_PROFILE ]</a></p>
            </div>
        </div>
        <a href="<?= site_url(($mode == 'SECURE_MODE') ? 'secure-dashboard/logout' : 'dashboard/logout') ?>" class="logout-btn">[ TERMINATE_SESSION ]</a>
    </div>

    <div class="search-box">
        <form action="" method="get" style="width: 100%; display: flex;">
            <input type="text" name="keyword" placeholder="SEARCH STUDENT NAME OR MAJOR..." value="<?= esc($keyword) ?>" autocomplete="off">
            <button type="submit">SEARCH_DB</button>
        </form>
    </div>

    <h3>[ DATABASE_DUMP: TABLE_MAHASISWA ]</h3>
    
    <table>
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">NIM</th>
                <th>NAMA</th>
                <th>JURUSAN</th>
                <th>ALAMAT</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($students)): ?>
                <tr><td colspan="5" style="text-align:center; padding: 20px; color: #666;">// DATA NOT FOUND.</td></tr>
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