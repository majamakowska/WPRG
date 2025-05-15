<?php
setcookie("voted", "1", time() - (86400 * 30), "/");
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_COOKIE['voted'])) {
    setcookie("voted", "1", time() + (86400 * 30), "/");
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
$hasVoted = isset($_COOKIE['voted']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 2</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #1C1D21;
            height: 100vh;
            margin: 0;
        }
        .box {
            display: flex;
            flex-direction: column;
            font-size: x-large;
            color: #2B975D;
            align-items: start;
            justify-content: center;
            background: #FDFFFC;
            border: #2B975D solid 5px;
            border-radius: 15px;
            padding: 50px;
        }
        .heading {
            display: flex;
            flex-direction: column;
            align-content: center;
            justify-content: center;
            width: 100%;
        }
        .centered_heading {
            margin: auto;
        }
        .thank_you {
            margin-bottom: 25px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: start;
            justify-content: center;
            width: 100%;
        }
        .answers {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: start;
            margin: 20px 0;
            width: 100%;
        }
        .answer {
            margin: 10px 0;
        }
        .button {
            align-self: center;
            background: #DCDEE2;
            color: #767B91;
            width: 25%;
            padding: 10px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php if ($hasVoted): ?>
    <div class = "box">
    <div class = "heading">
        <h3 class = "centered_heading thank_you">Dziękujemy za Twój głos!</h3>
    </div>
        <img src="ninjago_ty.png" width="400vw">
    </div>
    <?php else: ?>
    <div class = "box">
    <div class = "heading">
        <h3 class = "centered_heading">Jaki jest twój ulubiony bohater "Ninjago"?</h3>
    </div>
    <form method="POST" action = "">
        <div class="answers">
            <label class="answer"><input type="radio" name="character" value="wu" required> Mistrz Wu</label>
            <label class="answer"><input type="radio" name="character" value="lloyd"> Lloyd</label>
            <label class="answer"><input type="radio" name="character" value="kai"> Kai</label>
            <label class="answer"><input type="radio" name="character" value="jay"> Jay</label>
            <label class="answer"><input type="radio" name="character" value="zane"> Zane</label>
            <label class="answer"><input type="radio" name="character" value="cole"> Cole</label>
            <label class="answer"><input type="radio" name="character" value="nya"> Nya</label>
            <label class="answer"><input type="radio" name="character" value="other"> Inna odpowiedź</label>
        </div>
        <input type="submit" class = "button" value = "Głosuj">
    </form>
    </div>
    <?php endif; ?>
</body>
</html>