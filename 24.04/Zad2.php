<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 2</title>
</head>
<body>
    <form method="post" action="">
        <label for="path">Podaj ścieżkę katalogu: </label>
        <input type="text" name="path" required>
        <label for="name">Podaj nazwę katalogu: </label>
        <input type="text" name="name">
        <select name = "operation">
            <option value = "read" selected>Odczytaj elementy katalogu</option>
            <option value = "delete">Usuń wskazany katalog</option>
            <option value = "create">Utwórz katalog</option>
        </select>
        <button type="submit">Wykonaj</button>
    </form>
    <?php
    if (isset($_POST['path'])) {
        $path = $_POST['path'];
        $name = $_POST['name'];
        $operation = $_POST['operation'];
        if (empty($name) && ($operation == "delete" || $operation == "create")) {
            echo "<p>Do wykonania operacji potrzebna jest nazwa katalogu.</p>";
        } else {
            manageDirectory($path, $name, $operation);
        }
    }
    ?>
</body>
</html>
<?php
function manageDirectory($path, $name, $operation = "read") {
    if (substr($path, -1) !== '/') {
        $fullPath = $path . "/" . $name;
    } else {
        $fullPath = $path . $name;
    }
    switch ($operation) {
        case "read":
            if (!file_exists($fullPath)) {
                echo "<p>Katalog '$fullPath' nie istnieje</p>";
            } else {
                $files = scandir($fullPath);
                echo "<ul>";
                foreach ($files as $file) {
                    if ($file != "." && $file != "..") {
                        echo "<li>$file</li>";
                    }
                }
                echo "</ul>";
            }
            break;
        case "delete":
            if (!file_exists($fullPath)) {
                echo "<p>Katalog nie istnieje</p>";
            } else {
                $contents = array_diff(scandir($fullPath), ['.', '..']);
                if (!empty($contents)) {
                    echo "<p>Nie można usunąć katalogu '$fullPath', ponieważ nie jest pusty.</p>";
                } else {
                    if (rmdir($fullPath)) {
                        echo "<p>Katalog '$fullPath' został usunięty.</p>";
                    } else {
                        echo "<p>Usunięcie katalogu '$fullPath' nie powiodło się.</p>";
                    }
                }
            }
            break;
        case "create":
            if (file_exists($fullPath)) {
                echo "<p>Katalog '$fullPath' już istnieje</p>";
            } else {
                if (mkdir($fullPath)) {
                    echo "<p>Katalog '$fullPath' został utworzony.</p>";
                } else {
                    echo "<p>Utworzenie katalogu '$fullPath' nie powiodło się.</p>";
                }
            }
            break;
    }
}
?>