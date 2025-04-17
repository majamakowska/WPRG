<?php
if (isset($_POST['basic1']) && isset( $_POST['basic2'])) {
    $basic1 = $_POST['basic1'];
    $basic2 = $_POST['basic2'];
    if (!is_numeric($basic1) || !is_numeric($basic2)) {
        $basicResult = "Wartości muszą być numeryczne.";
    } else {
        switch ($_POST['basic_operation']) {
            case 'addition':
            {
                $basicResult = $basic1 + $basic2;
                break;
            }
            case 'subtraction':
            {
                $basicResult = $basic1 - $basic2;
                break;
            }
            case 'multiplication':
            {
                $basicResult = $basic1 * $basic2;
                break;
            }
            case 'division':
            {
                if ($basic2 == 0) {
                    $basicResult = "Nie można dzielić przez 0.";
                } else {
                    $basicResult = $basic1 / $basic2;
                }
                break;
            }
        }
    }
}
if (isset($_POST['advanced'])) {
    $advanced = $_POST['advanced'];
    switch ($_POST['advanced_operation']) {
        case 'cos':
        {
            if (!is_numeric($advanced)) {
                $advancedResult = "Wartości muszą być numeryczne.";
            } else {
                $advancedResult = cos($advanced);
            }
            break;
        }
        case 'sin':
        {
            if (!is_numeric($advanced)) {
                $advancedResult = "Wartości muszą być numeryczne.";
            } else {
                $advancedResult = sin($advanced);
            }
            break;
        }
        case 'tan':
        {
            if (!is_numeric($advanced)) {
                $advancedResult = "Wartości muszą być numeryczne.";
            } else {
                $advancedResult = tan($advanced);
            }
            break;

        }
        case 'binary_to_dec':
        {
            if (!preg_match('/^[01]+$/', $advanced)) {
                $advancedResult = "Wartość musi być liczbą binarną.";
            } else {
                $advancedResult = bindec($advanced);
            }
            break;
        }
        case 'hex_to_dec':
        {
            if (!preg_match('/^[0-9a-fA-F]+$/', $advanced)) {
                $advancedResult = "Wartość musi być liczbą szesnastkową.";
            } else {
                $advancedResult = hexdec($advanced);
            }
            break;
        }
        case 'dec_to_hex':
        {
            if (!is_numeric($advanced)) {
                $advancedResult = "Wartości muszą być numeryczne.";
            } else {
                $advancedResult = strtoupper(dechex($advanced));
            }
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 4</title>
    <style>
        body {
            color: white;
            font-family: arial;
        }
        .calculator {
            background-color: black;
            border: 3px solid cornflowerblue;
            padding: 10px;
            width: 500px;
        }
        .header {
            border-bottom: 1px solid white;
        }
        .basic {
            border-bottom: 1px solid white;
            padding-bottom: 10px;
        }
        .operation {
            display: flex;
            flex-direction: row;
        }
        input {
            margin: 2px;
        }
    </style>
</head>
<body>
<div class = "calculator">
    <div class = "header">
        <h2>Kalkulator</h2>
    </div>
    <div class = "basic">
        <h4>Prosty</h4>
        <form method = "post" action="">
            <div class = "operation">
                <input type = "number" name = "basic1" step="any" required>
                <select name = "basic_operation">
                    <option value = "addition" selected>dodawanie</option>
                    <option value = "subtraction">odejmowanie</option>
                    <option value = "multiplication">mnożenie</option>
                    <option value = "division">dzielenie</option>
                </select>
                <input type = "number" name = "basic2" step="any" required>
            </div>
            <input type = "submit" value = "oblicz">
        </form>
        <?php
        if (isset($basicResult)) {
            echo "<p> $basicResult </p>";
        }
        ?>
    </div>
    <div>
        <h4>Zaawansowany</h4>
        <form method = "post" action = "">
            <div class = "operation">
                <input type = "text" name = "advanced" required>
                <select name = "advanced_operation">
                    <option value = "cos" selected>cos</option>
                    <option value = "sin">sin</option>
                    <option value = "tan">tan</option>
                    <option value = "binary_to_dec">binarne na dziesiętne</option>
                    <option value = "dec_to_hex">dziesiętne na szestnastkowe</option>
                    <option value = "hex_to_dec">szesnastkowe na dziesiętne</option>
                </select>
            </div>
            <input type = "submit" value = "oblicz">
        </form>
        <?php
        if (isset($advancedResult)) {
        echo "<p>$advancedResult</p>";
        }
        ?>
    </div>
</div>
</body>
</html>