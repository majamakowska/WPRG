<?php
$db = Database::getInstanceOf();

$email_already_exists = false;
$username_already_exists = false;
$mismatch_password = false;

parse_str($_SESSION['last_query'], $queryArray);
unset($queryArray['action']);
$cleanQuery = http_build_query($queryArray);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["register"])) {
        $username = ($_POST['username']);
        $email = ($_POST['email']);
        $input_password = $_POST['password'];
        $input_password_confirm = $_POST['password_confirm'];

        $emailResult = $db->runQuery("SELECT id FROM users WHERE email = ?", [$email]);
        if ($emailResult->num_rows > 0) {
            $email_already_exists = true;
        }

        $usernameResult = $db->runQuery("SELECT user_id FROM profiles WHERE username = ?", [$username]);
        if ($usernameResult->num_rows > 0) {
            $username_already_exists = true;
        }

        if ($input_password !== $input_password_confirm) {
            $mismatch_password = true;
        } else {
            $password = password_hash($input_password, PASSWORD_DEFAULT);
        }

        if (!$email_already_exists && !$username_already_exists && !$mismatch_password) {
            $db->runQuery("INSERT INTO users (email, password) VALUES (?, ?)", [$email, $password]);
            $user_id = $db->getLastInsertedId();
            $db->runQuery("INSERT INTO profiles (user_id, username) VALUES (?, ?)", [$user_id, $username]);

            $_SESSION['user_id'] = $user_id;
            $_SESSION['section'] = "home";
            header("Location: index.php?" . $cleanQuery);
            exit();
        }
    } else if (isset($_POST["redirect"])) {
        $targetURL = Renderer::buildUrlWithParams($queryArray, ["action" => "login"]);
        header("Location: $targetURL");
        exit();
    } else if (isset($_POST['cancel'])) {
        header("Location: index.php?" . $cleanQuery);
        exit();
    }
} ?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="form_box">
            <h1>Rejestracja</h1>
            <form class="standard_form" method="POST" action="">
                <label for="register_username">Nazwa użytkownika:</label><input id="register_username" type="text" name="username" required>
                <?php if ($username_already_exists): ?>
                    <p><strong>*<strong> Ta nazwa jest już zajęta.</p>
                <?php endif; ?>
                <label for="register_email">E-mail:</label><input id="register_email" type="email" name="email" required>
                <?php if ($email_already_exists): ?>
                    <p><strong>*<strong> Ten adres e-mail jest już przypisany do konta.</p>
                <?php endif; ?>
                <label for="register_password">Hasło:</label><input id="register_password" type="password" name="password" required>
                <label for="register_password_confirm">Hasło:</label><input id="register_password_confirm" type="password" name="password_confirm" required>
                <?php if ($mismatch_password): ?>
                    <p><strong>*<strong> Hasła muszą być takie same.</p>
                <?php endif; ?>
                <div class="options">
                    <button class="cancel" type="submit" formnovalidate name="cancel">Wróć</button>
                    <button class="other" type="submit" formnovalidate name="redirect">Zaloguj się</button>
                    <button class="save" type="submit" name="register">Zarejestruj się</button>
                </div>
            </form>
        </div>
    </div>
</div>