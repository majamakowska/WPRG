<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 1</title>
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
    print ("<p>" . strtoupper($text) . "<br>"
        . strtolower($text) . "<br>"
        . ucfirst(strtolower($text)) . "<br>"
        . ucwords(strtolower($text)) . "</p>");
}
?>
</body>
</html>