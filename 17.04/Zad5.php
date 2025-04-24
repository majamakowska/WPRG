<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 5</title>
</head>
<body>
<form method="post" action="">
    <label for="number">Podaj liczbę:</label>
    <input type="number" step="any" name="number" required>
    <button type="submit">Wyślij</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $number = ($_POST["number"]);
    if (is_numeric($number)) {
        $f = (strlen($number) - strpos($number, ".") - 1);
        printf ("<p> Liczba <strong>$number</strong> ma <strong>$f</strong> liczb po przecinku.</p>");
    } else {
        echo "<p>Wartość musi być liczbą :)<p>";
    }
}
?>
</body>
</html>