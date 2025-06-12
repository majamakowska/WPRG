<?php
$db = Database::getInstanceOf();

if (User::checkRole($db) == "guest") {
    die("<p>Zaloguj się aby uzyskać dostęp do tej strony.<p>");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    parse_str($_SESSION['last_query'], $queryParams);
    unset($queryParams['action']);
    $cleanQuery = http_build_query($queryParams);
    if (isset($_POST["post"])) {
        $user_id = $_SESSION['user_id'];
        $datetime = (new DateTime())->format('Y-m-d H:i:s');
        $category_id = $_POST['category'];
        $subject = ($_POST['subject']);
        $content = ($_POST['content']);
        $result = $db->runQuery("INSERT INTO posts (user_id, category_id, datetime, subject, content) values (?, ?, ?, ?, ?)", [$user_id, $category_id, $datetime, $subject, $content]);
    }
    header("Location: index.php" . ($cleanQuery ? "?$cleanQuery" : ""));
    exit();
} ?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="form_box">
            <h1>Nowy post</h1>
            <form class="standard_form" method="POST" action="">
                <label for="new_post_category">Kategoria:</label>
                    <select id="new_post_category" name="category" required>
                        <?php Category::echoCategorySelect($db, "") ?>
                    </select>
                <label for="new_post_subject">Temat:</label><input id="new_post_subject" type = "text" name = "subject" required>
                <label for="new_post_content"></label><textarea id="new_post_content" name = "content" required></textarea>
                <div class="options">
                    <button class="cancel" type="submit" formnovalidate name="cancel">Anuluj</button>
                    <button class="save" type="submit" name="post">Opublikuj</button>
                </div>
            </form>
        </div>
    </div>
</div>