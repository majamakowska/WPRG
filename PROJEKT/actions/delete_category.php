<?php
$db = Database::getInstanceOf();
$role = User::checkRole($db);

if ($role != "admin") {
    die("<p>Nie możesz wykonać tej akcji.<p>");
}
if (isset($_GET["category_id"])) {
    $category_id = $_GET["category_id"];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        parse_str($_SESSION['last_query'], $queryParams);
        unset($queryParams['action'], $queryParams['category_id']);
        $cleanQuery = http_build_query($queryParams);
        if (isset($_POST['delete'])) {
            $category_id = $_POST['category_id'];
            Category::delete($db, $category_id);
        }
        header("Location: index.php" . ($cleanQuery ? "?$cleanQuery" : ""));
        exit();
    }
} ?>
<div class="pop-up">
    <div class="pop-up_container">
        <div class="pop-up_content">
            <p>Czy na pewno chcesz usunąć tą kategorię?</p>
            <form method="POST">
                <input type="hidden" value="<?php echo $category_id; ?>">
                <div class="options">
                    <button class="cancel" type="submit" name="cancel">Anuluj</button>
                    <button class="delete" type="submit" name="delete">Usuń</button>
                </div>
            </form>
        </div>
    </div>
</div>