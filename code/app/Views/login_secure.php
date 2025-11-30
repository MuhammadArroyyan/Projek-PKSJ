<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glitch Academy /// SECURE</title>
    <style>
        body {
            background-color: #050505;
            color: #00ff41;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .container {
            width: 400px;
            border: 2px solid #0041ff; /* Ubah jadi Biru untuk membedakan mode Secure */
            padding: 20px;
            box-shadow: 0 0 10px #0041ff;
            position: relative;
        }
        h1 {
            text-transform: uppercase;
            text-shadow: 2px 0 red, -2px 0 blue;
            color: #0041ff;
        }
        input {
            width: 90%;
            background: #000;
            border: 1px solid #333;
            border-bottom: 2px solid #0041ff;
            color: #fff;
            padding: 10px;
            margin-bottom: 15px;
            font-family: inherit;
            font-size: 1.2rem;
        }
        input:focus { outline: none; background: #111; }
        button {
            width: 100%;
            padding: 10px;
            background: #0041ff;
            color: #fff;
            font-weight: bold;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
        }
        button:hover { background: #fff; color: #000; }
        .alert {
            background: #ff0000;
            color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>/// FORTRESS_MODE</h1>
        <p>SECURE CHANNEL ESTABLISHED</p>
        
        <?php if(session()->getFlashdata('msg')):?>
            <div class="alert"><?= session()->getFlashdata('msg') ?></div>
        <?php endif;?>

        <form action="/secure-login/auth" method="post">
            <label>USER_ID:</label>
            <input type="text" name="username" autocomplete="off" autofocus>
            
            <label>PASS_KEY:</label>
            <input type="password" name="password">
            
            <button type="submit">AUTHENTICATE</button>
        </form>
    </div>

</body>
</html>