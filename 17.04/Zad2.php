<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 2</title>
</head>
<body>
<form method="post" action="">
    <label for="text">Podaj ciąg znaków:</label>
    <input type="text" name="text" required>
    <button type="submit">Wyślij</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $text = trim($_POST["text"]);
    $newText = preg_replace('/[\\\\\/:*?"<>|+\-\.]/', '', $text);
    printf("<p>$newText</p>");
}
?>
</body>
</html>
