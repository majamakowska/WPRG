<?php
$db = Database::getInstanceOf();
$role = User::checkRole($db);

if (isset($_GET["comment_id"])) {
    $comment_id = $_GET["comment_id"];
    $commentAuthorResult = $db->runQuery("SELECT user_id FROM comments WHERE id = ?", [$comment_id]);
    $commentAuthor = $commentAuthorResult->fetch_assoc()["user_id"];

    $privilegedRole = $role === "admin" || $role === "mod";
    $isAuthor = $commentAuthor !== null && $_SESSION["user_id"] === $commentAuthor;

    if (!isset($_SESSION["user_id"]) || !($privilegedRole || $isAuthor)) {
        die("<p>Nie możesz wykonać tej akcji.<p>");
    }

    $result = $db->runQuery("SELECT * FROM comments WHERE id = ?", [$comment_id]);
    $row = $result->fetch_assoc();
    $content = htmlspecialchars($row["content"]);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        parse_str($_SESSION['last_query'], $queryParams);
        unset($queryParams['action'], $queryParams['comment_id']);
        $cleanQuery = http_build_query($queryParams);
        if (isset($_POST["save"])) {
            $comment_id = $_POST["comment_id"];
            $new_content = $_POST["content"];
            $result = $db->runQuery("UPDATE comments SET content = ? WHERE id = ?", [$new_content, $comment_id]);
        }
        header("Location: index.php" . ($cleanQuery ? "?$cleanQuery" : ""));
        exit();
    }
} ?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="form_box">
            <h1>Edytuj post</h1>
            <form class = standard_form method='POST' action=''>
                <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                <label for="edit_comment_content"></label><textarea id="edit_comment_content" name = "content" required><?php echo $content; ?></textarea>
                <div class="options">
                    <button class="cancel" type="submit" formnovalidate name="cancel">Anuluj</button>
                    <button class="save" type="submit" name="save">Zapisz zmiany</button>
                </div>
            </form>
        </div>
    </div>
</div>