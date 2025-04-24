<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 4</title>
</head>
<body>
<form method="post" action="">
    <label for="text">Podaj ciąg znaków:</label>
    <input type="text" name="text" required>
    <button type="submit">Wyślij</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $text = trim(htmlspecialchars($_POST["text"]));
    $x = preg_match_all('/[aeiou]/i', strtolower($text), $matches);
    printf ("<p>Podany ciąg znaków zawiera <strong>$x</strong> samogłosek.</p>");
}
?>
</body>
</html>
