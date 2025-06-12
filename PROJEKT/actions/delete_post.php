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

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        parse_str($_SESSION['last_query'], $queryParams);
        unset($queryParams['action'], $queryParams['post_id']);
        $cleanQuery = http_build_query($queryParams);
        if (isset($_POST["delete"])) {
            $post_id = $_POST["post_id"];
            Post::delete($db, $post_id);
        }
        header("Location: index.php" . ($cleanQuery ? "?$cleanQuery" : ""));
        exit();
    }
} ?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="pop-up_content">
            <p>Czy na pewno chcesz usunąć ten post?</p>
            <form method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <div class="options">
                    <button class="cancel" type="submit" name="cancel">Anuluj</button>
                    <button class="delete" type="submit" name="delete">Usuń</button>
                </div>
            </form>
        </div>
    </div>
</div>