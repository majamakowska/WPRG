<?php
if (!file_exists("./licznik.txt")) {
    $liczbaOdwiedzin = 1;
} else {
    $liczbaOdwiedzin = (int)file_get_contents("./licznik.txt");
    $liczbaOdwiedzin++;
}
file_put_contents("./licznik.txt", $liczbaOdwiedzin);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 2</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #5158BB;
            height: 100vh;
            margin: 0;
        }
        .box {
            display: flex;
            font-family: sans-serif;
            font-size: x-large;
            color: #FAFAFF;
            align-items: center;
            justify-content: center;
            background: #1C1D21;
            border-radius: 15px;
            padding: 25px 50px;
        }
    </style>
</head>
<body>
<div class="box">
<?php
echo "<p>Liczba odwiedzin: $liczbaOdwiedzin</p>";
?>
</div>
</body>
</html>
