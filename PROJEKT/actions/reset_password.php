<?php
if (!isset($_SESSION['user_id'])) {
    die("Zaloguj się, aby uzyskać dostęp do tej strony.");
}
$wrong_password = false;
$mismatched_password = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["save"])) {
        $db = Database::getInstanceOf();
        $password = $_POST["old_password"];
        $input_new_password = $_POST["new_password"];
        $input_new_password_confirm = $_POST["new_password_confirm"];
        $resultPassword=$db->runQuery("SELECT password FROM users WHERE id=?", [$_SESSION['user_id']]);
        if(!password_verify($password, $resultPassword->fetch_assoc()["password"])) {
            $wrong_password = true;
        } else if ($input_new_password != $input_new_password_confirm) {
            $mismatched_password = true;
        } else {
            $new_password = password_hash($input_new_password, PASSWORD_DEFAULT);
            $db->runQuery("UPDATE users SET password=? WHERE id=?", [$new_password, $_SESSION['user_id']]);
        }
    }
    header("Location: index.php?section=support");
    exit();
}
?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="form_box">
            <h1>Zresetuj hasło</h1>
            <form class="standard_form" method="POST">
                <label for="reset_old_password">Stare hasło:</label><input id="reset_old_password" type="password" name="old_password" required>
                <?php if ($wrong_password) :?>
                <p><strong>*<strong> Nieprawidłowe hasło.</p>
                <?php endif; ?>
                <label for="reset_new_password">Nowe hasło:</label><input id="reset_new_password" type="password" name="new_password" required>
                <label for="reset_new_password_confirm">Powtórz nowe hasło:</label><input id="reset_new_password_confirm" type="password" name="new_password_confirm" required>
                <?php if ($mismatched_password) :?>
                <p><strong>*<strong> Hasła muszą być takie same.</p>
                <?php endif; ?>
                <div class="options">
                    <button class="cancel" type="submit" name="cancel" formnovalidate>Anuluj</button>
                    <button class="save" type="submit" name="save">Zapisz</button>
                </div>
            </form>
        </div>
    </div>
</div>
