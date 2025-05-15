<?php
session_start();

$login = "s32828";
$password = "123";

$wrong_credentials = false;
$logged_in = false;

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["login"] === $login && $_POST["password"] === $password) {
        $_SESSION['logged_in'] = true;
    } else {
        $wrong_credentials = true;
    }
}

$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 4</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #E2B4BD;
            height: 100vh;
            margin: 0;
        }
        .box {
            display: flex;
            flex-direction: column;
            color: #FFFFFF;
            align-items: center;
            justify-content: center;
            background: #424B54;
            border: solid #93A8AC 5px;
            border-radius: 15px;
            padding: 25px 50px;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 100%;
            align-items: center;
            justify-content: center;
        }
        input {
            background: #FFFFFF;
            border: none;
            border-radius: 5px;
            margin: 20px 0;
            width: 200px;
            height: 20px;
        }
        .button {
            color: #FFFF82;
            background: #93A8AC;
            padding: 15px;
            border-radius: 15px;
            border: none;
        }
        .yellow_a {
            color: #FFFF82;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php if ($logged_in): ?>
    <div class="box">
        <h1>Jesteś zalogowany</h1>
        <a href="?logout=true"><button class="button" type="button"><strong>Wyloguj się</strong></button></a>
    </div>
    <?php else: ?>
    <div class="box">
        <h1>Logowanie</h1>
        <form method="POST" action="">
            <label>Login: <input type="text" name="login" required></label>
            <label>Hasło: <input type="password" name="password" required></label>
            <?php if ($wrong_credentials): ?>
                <p><span class="yellow_a">* </span>Niepoprawny login lub hasło.</p>
            <?php endif; ?>
            <button class="button"><strong>Zaloguj się</strong></button>
        </form>
    </div>
    <?php endif; ?>
</body>
</html>