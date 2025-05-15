<?php
session_start();

$wrong_credentials = false;
$logged_in = false;

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_email = $_POST['email'];
    $input_password = $_POST['password'];

    $konta = file("Zad4_konta.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($konta as $konto) {
        list($name, $lastname, $email, $password) = explode(",", $konto);

        if ($email === $input_email && $password === $input_password) {
            $_SESSION['logged_in'] = true;
            break;
        }
    }
    $logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];

    if (!$logged_in) {
        $wrong_credentials = true;
    }
} ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 4</title>
    <link rel="stylesheet" href="Zad4.css">
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
        <label>E-mail: <input type="email" name="email" required></label>
        <label>Hasło: <input type="password" name="password" required></label>
        <?php if ($wrong_credentials): ?>
            <p><span class = blue_a>* </span>Niepoprawny e-mail lub hasło.</p>
        <?php endif; ?>
        <div class="buttons">
            <a href="Zad4_rejestracja.php"><button class="button gray" type="button"><strong>Zarejestruj się</strong></button></a>
            <button class="button blue"><strong>Zaloguj się</strong></button>
        </div>
    </form>
    </div>
    <?php endif; ?>
</body>
</html>