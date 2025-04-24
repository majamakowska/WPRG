<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 2</title>
    <style>
        body {
            font-family: arial, sans-serif;
            display: flex;
            height: 100vh;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 50%;
            padding: 10px;
            border: 3px solid lightseagreen;
        }
        form {
            padding: 10px 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 500px;
        }
        label {
            font-weight: bold;
        }
        input, select, button {
            padding: 10px;
        }
        p {
            overflow-y: auto;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
            border: 3px dashed lightseagreen;
            padding: 10px;
            margin: auto;
            text-align: center;
            width: 500px;
        }
    </style>
</head>
<body>
    <div class = container>
        <form method="post" action="">
            <label for="text">Podaj ciąg znaków:</label>
            <input type="text" name="text" required>
                <select name = "operation">
                    <option value = "strrev" selected>Odwrócenie ciągu znaków</option>
                    <option value = "strtoupper">ZAMIANA WSZYTSKICH LITER NA WIELKIE</option>
                    <option value = "strtolower">zamiana wszystkich liter na małe</option>
                    <option value = "strlen">Liczenie liczby znaków</option>
                    <option value = "trim">Usuwanie białych znaków z początku i końca ciągu</option>
                </select>
            <button type="submit">Wykonaj</button>
        </form>
<?php
if (isset($_POST["text"])) {
    $newText = $_POST["text"];
    switch ($_POST["operation"]) {
        case "strrev":
            $newText = strrev($newText);
            break;
        case "strtoupper":
            $newText = strtoupper($newText);
            break;
        case "strtolower":
            $newText = strtolower($newText);
            break;
        case "strlen":
            $newText = strlen($newText);
            break;
        case "trim":
            $newText = trim($newText);
            break;
    }
    echo "<p>" . htmlspecialchars($newText) . "</p>";
}
?>
    </div>
</body>
</html>