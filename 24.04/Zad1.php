<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 1</title>
</head>
<body>
<form method="get" action="">
    <label for="birthdate">Podaj swoją datę urodenia:</label>
    <input type="date" name="birthdate" max="<?= date('Y-m-d') ?>" required>
    <button type="submit">Wyślij</button>
</form>
<?php
setlocale(LC_ALL,'pl_PL.UTF-8');
if (isset($_GET["birthdate"])) {
    $birthDate = $_GET["birthdate"];
    $birthDate_time = strtotime($birthDate);
    if ($birthDate_time > time()) {
        echo "<p>Nieprawidłowa data.</p>";
    } else {
        $age =  floor((time() - $birthDate_time)/86400/365);
        $nextBirthday = mktime(0, 0, 0, date("m", $birthDate_time), date("d", $birthDate_time), date("Y", $birthDate_time) + $age + 1);
        $daysLeft = floor(($nextBirthday - time())/86400);

        echo "<p>The user was born on <strong>" . strftime("%A", $birthDate_time)
            . "</strong><br>The user is <strong>" . $age . "</strong> years old.<br>There's <strong>"
            . $daysLeft . "</strong> days left until user's next birthday.</p>";
    }
}
?>
</body>
</html>