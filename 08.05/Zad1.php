<?php
$N_visits = 5;
$visitCount = 0;

if (isset($_GET["reset"])) {
setcookie("visitCount", "", time() - 3600);
header("Location: Zad1.php");
exit;
}

if (isset($_COOKIE["visitCount"])) {
$visitCount = intval($_COOKIE["visitCount"]);
}
$visitCount++;

setcookie("visitCount", $visitCount, time() + (30 * 24 * 60 * 60));
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 1</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #B370B0;
            height: 100vh;
            margin: 0;
        }
        .box {
            display: flex;
            flex-direction: column;
            font-size: x-large;
            color: #F1E4E8;
            align-items: center;
            justify-content: center;
            background: #1C1D21;
            border-radius: 15px;
            padding: 25px 50px;
        }
        .message {
            color: #C2E812;
        }
        button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #1C1D21;
            color: #D2AACC;
            padding: 15px;
            border-radius: 15px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="box">
<?php
echo "<p>Liczba Twoich odwiedzin: " . $visitCount . "</p>";
if ($visitCount >= $N_visits)
    echo "<p class='message'>🎉Odwiedziłeś naszę stronę już " . $N_visits . " razy!🎉</p>"
?>
</div>
<form method="get" action="">
    <button type="submit" name="reset">Resetuj licznik</button>
</form>
</body>
</html>