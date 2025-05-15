<?php
$registered = false;
$email_already_exists = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input_name = htmlspecialchars($_POST['name']);
    $input_lastname = htmlspecialchars($_POST['lastname']);
    $input_email = htmlspecialchars($_POST['email']);
    $input_password = $_POST['password'];

$konta = file("Zad4_konta.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($konta as $konto) {
    list($name, $lastname, $email, $password) = explode(",", $konto);

    if ($input_email === $email) {
        $email_already_exists = true;
        break;
    }
}
if (!$email_already_exists) {
    file_put_contents("Zad4_konta.txt", "$input_name,$input_lastname,$input_email,$input_password\n", FILE_APPEND);
        $registered = true;
}} ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 4</title>
    <link rel="stylesheet" href="Zad4.css">
</head>
<body>
    <?php if ($registered): ?>
    <div class="box">
        <h1>Rejestracja zakończona sukcesem!</h1>
        <a href="Zad4_logowanie.php"><button class="button blue" type="button"><strong>Zaloguj się</strong></button></a>
    </div>
    <?php else: ?>
    <div class="box">
        <h1>Rejestracja</h1>
        <form method="POST" action="">
            <label>Imię: <input type="text" name="name" required></label>
            <label>Nazwisko: <input type="text" name="lastname" required></label>
            <label>E-mail: <input type="email" name="email" required></label>
            <?php if ($email_already_exists): ?>
                <p>Ten adres e-mail jest już przypisany do konta.<p>
            <?php endif; ?>
            <label>Hasło: <input type="password" name="password" required></label>
            <div class="buttons">
                <a href="Zad4_logowanie.php"><button class="button gray" type="button"><strong>Zaloguj się</strong></button></a>
                <button class="button blue"><strong>Zarejestruj się</strong></button>
            </div>
        </form>
    </div>
    <?php endif; ?>
</body>
</html>