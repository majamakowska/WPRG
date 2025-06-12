<?php
$db = Database::getInstanceOf();
if (User::checkRole($db) != "admin") {
    die("Brak dostępu.");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $name = $_POST["name"];
        $db->runQuery("INSERT INTO categories (name) VALUES (?)", [$name]);
    }
    if (isset($_POST['edit_category'])) {
        $name = $_POST["name"];
        $categoryId = $_POST["category"];
        $db->runQuery("UPDATE categories SET name = ? WHERE id = ?", [$name, $categoryId]);
    }
    if (isset($_POST['delete_category'])) {
        $categoryId = $_POST["category"];
        header("Location: index.php?section=admin_panel&action=delete_category&category_id=$categoryId");
    }
}
?>
<div class="admin_panel">
    <div class="section">
    <h2>Dodaj kategorię</h2>
    <form method="POST">
        <label for="add_category">Nowa kategoria:</label><input id="add_category" type="text" name="name" required>
        <button class="save" type="submit" name="add_category">Dodaj</button>
    </form>
    </div>
    <div class="section">
        <h2>Usuń kategorię</h2>
        <form method="POST">
            <label for="delete_category">Kategoria:</label>
                <select id="delete_category" name="category" required>
                    <?php Category::echoCategorySelect($db); ?>
                </select>
            <button class="delete" type="submit" name="delete_category">Usuń</button>
        </form>
    </div>
</div>