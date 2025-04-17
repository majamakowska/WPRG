
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 4</title>
</head>
<body>
    <form method="post" action="">
        <div>
            <label>Imię:</label>
            <input type="text" name="name" required>
        </div>
        <div >
            <label>Nazwisko:</label>
            <input type="text" name="surname" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Hasło:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Powtórz hasło:</label>
            <input type="password" name="confirm" required>
        </div>
        <div>
            <labe>Wiek:</labe>
            <input type="number" name="age" required>
        </div>
        <input type="submit" value="Zarejestruj się">
    </form>
</body>
</html>
<?php
if (!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['age'])) {
    $info = [
        "Imię" => $_POST['name'],
        "Nazwisko" => $_POST['surname'],
        "Email" => $_POST['email'],
        "Hasło" => $_POST['password'],
        "Powtórz hasło" => $_POST['confirm'],
        "Wiek" => $_POST['age']
    ];
    print_r($info);
}
?>