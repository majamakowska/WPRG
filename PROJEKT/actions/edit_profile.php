<?php
$db = Database::getInstanceOf();
if (!isset($_SESSION['user_id'])) {
    die("<p>Zaloguj się, aby uzyskać dostęp do tej strony.</p>");
}
$user_id = $_SESSION['user_id'];
$profileResult = $db->runQuery("SELECT * FROM profiles WHERE user_id = ?", [$user_id]);
$profile = $profileResult->fetch_assoc();
$username = htmlspecialchars($profile['username']);
$pfp = $profile['pfp'];

$pfpDirectory = "profilePicturesDir";

$username_already_exists = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    parse_str($_SESSION['last_query'], $queryParams);
    unset($queryParams['action'], $queryParams['post_id']);
    $cleanQuery = http_build_query($queryParams);
    if (isset($_POST["save"])) {
        $newUsername = $_POST['username'];

        if ($newUsername !== $username) {
            $usernameResult = $db->runQuery("SELECT user_id FROM profiles WHERE username = ?", [$newUsername]);
            if ($usernameResult->num_rows > 0) {
                $username_already_exists = true;
            } else {
                $db->runQuery("UPDATE profiles SET username = ? WHERE user_id = ?", [$newUsername, $user_id]);
            }
        }
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $pfpTempPath = $_FILES['profile_picture']['tmp_name'];
            $timestamp = (new DateTime())->format('Ymd-His');
            $newPfpName = "pfp_$user_id" . $timestamp . ".png";
            $newPfpPath = $pfpDirectory . $newPfpName;

            if (!is_dir($pfpDirectory)) {
                mkdir($pfpDirectory, 0755, true);
            }

            move_uploaded_file($pfpTempPath, $newPfpPath);

            $db->runQuery("UPDATE profiles SET pfp = ?, username = ? WHERE user_id = ?", [$newPfpPath, $user_id]);
        } else if (!$username_already_exists) {
            header("Location:index.php?section=profile&user_id=$user_id");
            exit();
        }
    }
    if (isset($_POST["cancel"])) {
        header("Location:index.php?section=profile&user_id=$user_id");
        exit();
    }
}
?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="form_box">
            <h1>Edytuj profil</h1>
            <form class="standard_form" method="POST" enctype="multipart/form-data">
                <label for="edit_profile_pfp">Zdjęcie profilowe:</label>
                <input class="file_input" id="edit_profile_pfp" type="file" name="profile_picture" accept="image/*">
                <label for="edit_profile_username"> Nazwa użytkownika:</label>
                <input id="edit_profile_username" type="text" name="username" value="<?php echo $username; ?>" required>
                <?php if ($username_already_exists): ?>
                    <p><strong>*<strong> Ta nazwa jest już zajęta.</p>
                <?php endif; ?>
                <p class="reset_message">Kliknij tutaj, żeby zresetować hasło ➜ <a class="reset_link" href="index.php?section=profile&user_id=<?php echo $user_id ?>&action=reset_password">Zresetuj hasło</a></p>
                <div class="options">
                    <button class="cancel" type="submit" name="cancel">Anuluj</button>
                    <button class="save" type="submit" name="save">Zapisz zmiany</button>
                </div>
            </form>
        </div>
    </div>
</div>