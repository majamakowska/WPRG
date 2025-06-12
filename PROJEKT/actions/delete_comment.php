<?php
$db = Database::getInstanceOf();
$role = User::checkRole($db);
if (isset($_GET["comment_id"])) {
    $comment_id = $_GET["comment_id"];
    $commentAuthorResult = $db->runQuery("SELECT user_id FROM comments WHERE id = ?", [$comment_id]);
    $commentAuthor = $commentAuthorResult->fetch_assoc()["user_id"];

    $privilegedRole  = $role === "admin" || $role === "mod";
    $isAuthor = $commentAuthor !== null && $_SESSION["user_id"] == $commentAuthor;

    if (!isset($_SESSION["user_id"]) || !($privilegedRole || $isAuthor)) {
        die("<p>Nie możesz wykonać tej akcji.</p>");
    }

    if (!($role === "admin" || $role === "mod" || $commentAuthor == $_SESSION["user_id"])) {
        die("<p>Nie możesz wykonać tej akcji.<p>");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        parse_str($_SESSION['last_query'], $queryParams);
        unset($queryParams['action'], $queryParams['comment_id']);
        $cleanQuery = http_build_query($queryParams);
        if (isset($_POST['delete'])) {
            $comment_id = $_POST['comment_id'];
            Comment::delete($db, $comment_id);
        }
        header("Location: index.php" . ($cleanQuery ? "?$cleanQuery" : ""));
        exit();
    }
} ?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="pop-up_content">
            <p>Czy na pewno chcesz usunąć ten komentarz?</p>
            <form method="POST">
                <input type = hidden value="<?php echo $comment_id; ?>" name="comment_id">
                <div class="options">
                    <button class="cancel" type="submit" name="cancel">Anuluj</button>
                    <button class="delete" type="submit" name="delete">Usuń</button>
                </div>
            </form>
        </div>
    </div>
</div>