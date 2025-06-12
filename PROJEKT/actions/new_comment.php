<?php
$logged_in = isset($_SESSION['user_id']);
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    parse_str($_SESSION['last_query'], $queryParams);
    unset($queryParams['action'], $queryParams['post_id']);
    $cleanQuery = http_build_query($queryParams);
    if (isset($_POST['post'])) {
        $db = Database::getInstanceOf();
        $post_id = ($_POST['post_id']);
        if ($logged_in) {
            $user_id = $_SESSION['user_id'];
            $author_id = null;
        } else {
            $user_id = null;
            $author = $_POST['author'];
        }
        $datetime = (new DateTime())->format('Y-m-d H:i');
        $content = $_POST['content'];
        $db->runQuery("INSERT INTO comments (post_id, user_id, author, datetime, content) values (?, ?, ?, ?, ?)", [$post_id, $user_id, $author, $datetime, $content]);
    }
    header("Location: index.php" . ($cleanQuery ? "?$cleanQuery" : ""));
    exit();
} ?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="form_box">
            <h1>Dodaj komentarz</h1>
            <form class="standard_form" method="POST">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <?php if(!$logged_in): ?>
                    <label for="new_comment_author">Pseudonim:</label><input id="new_comment_author" name="author" required>
                <?php endif; ?>
                <label for="new_comment_content"></label><textarea id="new_comment_content" name="content" required></textarea>
                <div class="options">
                    <button class="cancel" type="submit" formnovalidate name="cancel">Anuluj</button>
                    <button class="save" type="submit" name="post">Opublikuj</button>
                </div>
            </form>
        </div>
    </div>
</div>