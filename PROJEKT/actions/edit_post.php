<?php
$db = Database::getInstanceOf();
$role = User::checkRole($db);

if (isset($_GET["post_id"])) {
    $post_id = $_GET["post_id"];
    $postAuthorResult = $db->runQuery("SELECT user_id FROM posts WHERE id = ?", [$post_id]);
    $postAuthor = $postAuthorResult->fetch_assoc()["user_id"];

    $privilegedRole = $role === "admin" || $role === "mod";
    $isAuthor = $postAuthor !== null && $_SESSION["user_id"] === $postAuthor;

    if (!isset($_SESSION["user_id"]) || !($privilegedRole || $isAuthor)) {
        die("<p>Nie możesz wykonać tej akcji.<p>");
    }

    $result = $db->runQuery("SELECT * FROM posts WHERE id = ?", [ $post_id ]);
    $row = $result->fetch_assoc();
    $category_id = $row['category_id'];
    $subject = htmlspecialchars($row['subject']);
    $content = htmlspecialchars($row['content']);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        parse_str($_SESSION['last_query'], $queryParams);
        unset($queryParams['action'], $queryParams['post_id']);
        $cleanQuery = http_build_query($queryParams);
        if (isset($_POST["save"])) {
            $post_id = $_POST["post_id"];
            $new_category = $_POST["category"];
            $new_subject = $_POST["subject"];
            $new_content = $_POST["content"];
            $result = $db->runQuery("UPDATE posts SET category_id = ?, subject = ?, content = ? WHERE id = ?", [$new_category, $new_subject, $new_content, $post_id]);
        }
        header("Location: index.php" . ($cleanQuery ? "?$cleanQuery" : ""));
        exit();
    }
} ?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="form_box">
            <h1>Edytuj post</h1>
            <form class ="standard_form" method="POST" action="">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <label for="edit_post_category">Kategoria:</label>
                    <select id="edit_post_category" name="category" required>;
                        <?php Category::echoCategorySelect($db, $category_id); ?>
                    </select>
                <label for="edit_post_subject">Temat:</label><input id="edit_post_subject" type="text" name = "subject" value = "<?php echo $subject; ?>">
                <label for="edit_post_content"></label><textarea id="edit_post_content" name = "content" required><?php echo $content; ?></textarea>
                <div class="options">
                    <button class="cancel" type="submit" formnovalidate name="cancel">Anuluj</button>
                    <button class="save" type="submit" name="save">Zapisz zmiany</button>
                </div>
            </form>
        </div>
    </div>
</div>