<?php
$db = Database::getInstanceOf();

$wrong_credentials = false;

parse_str($_SESSION['last_query'], $queryArray);
unset($queryArray['action']);
$cleanQuery = http_build_query($queryArray);

if (isset($_COOKIE["email"])) {
    $email = $_COOKIE["email"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $input_email = $_POST['email'];
        $input_password = $_POST['password'];

        $result = $db->runQuery("SELECT id, password FROM users WHERE email = ?", [$input_email]);

        if ($result->num_rows == 0) {
            $wrong_credentials = true;
        } else {
            $row = $result->fetch_assoc();
            $hashed_password = $row["password"];

            if (password_verify($input_password, $hashed_password)) {
                if (isset($_POST["remember"])) {
                    setcookie("email", $input_email, time() + (86400 * 30), "/");
                }
                $_SESSION['user_id'] = $row['id'];
                header("Location: index.php?" . $cleanQuery);
                exit();
            } else {
                $wrong_credentials = true;
            }
        }
    } else if (isset($_POST["redirect"])) {
        $targetURL = Renderer::buildUrlWithParams($queryArray, ["action" => "registration"]);
        header("Location: $targetURL");
        exit();
    }
    if (isset($_POST['cancel'])) {
        header("Location: index.php?" . $cleanQuery);
        exit();
    }
} ?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="form_box">
            <h1>Logowanie</h1>
            <form class="standard_form" method="POST" action="">
                <label for="login_email">E-mail:</label><input id="login_email" type="email" name="email" <?php if (isset($email)) echo "value=\"" . htmlspecialchars($email) . "\""?> required>
                <label for="login_remember" class="checkbox_label"><input id="login_remember" type="checkbox" name="remember" <?php if (isset($_COOKIE["email"])) echo "checked"?>>Zapamiętaj mnie</label>
                <label for="login_password">Hasło:</label><input id="login_password" type="password" name="password" required>
                <?php if ($wrong_credentials): ?>
                    <p><strong>*</strong> Niepoprawny e-mail lub hasło.</p>
                <?php endif; ?>
                <div class="options">
                    <button class="cancel" type="submit" formnovalidate name="cancel">Wróć</button>
                    <button class="other" type="submit" formnovalidate name="redirect">Zarejestruj się</button>
                    <button class="save" type="submit" name="login">Zaloguj się</button>
                </div>
            </form>
        </div>
    </div>
</div>