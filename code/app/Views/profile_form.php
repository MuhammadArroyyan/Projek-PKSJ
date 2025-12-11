<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glitch Academy /// PROFILE_EDIT</title>
    <?php 
        // Tentukan warna tema di sini
        $themeColor = ($mode == 'SECURE_MODE') ? '#0041ff' : '#00ff41'; 
    ?>
    <style>
        /* CSS yang sama dengan Dashboard untuk konsistensi */
        * { box-sizing: border-box; }
        body {
            background-color: #0d0208;
            color: <?= $themeColor ?>;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 600px;
            border: 2px solid <?= $themeColor ?>;
            padding: 30px;
            box-shadow: 0 0 15px <?= $themeColor ?>;
            background: #0d0208;
        }
        h1 { font-size: 1.5rem; text-transform: uppercase; margin-bottom: 20px; border-bottom: 1px dashed #333; padding-bottom: 10px;}
        .alert { background: #ff0041; color: #000; padding: 10px; margin-bottom: 20px; font-weight: bold; }
        .success { background: #00ff41; color: #000; padding: 10px; margin-bottom: 20px; font-weight: bold; }

        label { display: block; margin-bottom: 5px; font-size: 0.9rem; }
        input[type="text"], input[type="email"] {
            width: 100%;
            background: #000;
            border: 1px solid #333;
            border-left: 4px solid <?= $themeColor ?>;
            color: #fff;
            padding: 12px;
            margin-bottom: 15px;
            font-family: inherit;
            font-size: 1rem;
        }
        input:focus { outline: none; background: #111; }

        button {
            padding: 10px 20px;
            background-color: <?= $themeColor ?>;
            color: #000;
            border: none;
            font-weight: 900;
            font-size: 1rem;
            cursor: pointer;
            font-family: inherit;
            text-transform: uppercase;
            transition: all 0.3s;
        }
        .back-link {
            display: inline-block;
            margin-left: 20px;
            color: #fff;
            text-decoration: none;
            border: 1px dashed #fff;
            padding: 10px 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>/// USER_PROFILE_EDIT: <?= $mode ?></h1>

    <?php if(session()->getFlashdata('error')):?>
        <div class="alert">[ ERROR ] <?= session()->getFlashdata('error') ?></div>
    <?php endif;?>
    <?php if(session()->getFlashdata('success')):?>
        <div class="success">[ OK ] <?= session()->getFlashdata('success') ?></div>
    <?php endif;?>
    
    <form action="<?= site_url($mode == 'SECURE_MODE' ? 'secure-dashboard/profile/update' : 'dashboard/profile/update') ?>" method="post">
        
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

        <label for="username">USERNAME:</label>
        <input type="text" id="username" name="username" value="<?= $user['username'] ?>" required>

        <label for="email">EMAIL:</label>
        <input type="text" id="email" name="email" value="<?= $user['email'] ?>" required>
        
        <button type="submit">UPDATE_ACCESS_KEY</button>
        <a href="<?= site_url($mode == 'SECURE_MODE' ? 'secure-dashboard' : 'dashboard') ?>" class="back-link">← CANCEL / BACK</a>
    </form>
</div>

</body>
</html>