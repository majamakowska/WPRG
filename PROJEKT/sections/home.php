<?php
$db = Database::getInstanceOf();

if (!isset($_GET['category'])) {
    $result = $db->runQuery("SELECT * FROM categories ORDER BY id DESC");
    echo "<h1>Kategorie</h1>
    <div class ='categories'>";
    if (User::checkRole($db) == "admin") {
        echo "<a class=\"category_box\" href=\"?section=admin_panel\"><h3>🛠 Zarządzaj kategoriami</h3></a>";
    }
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row["name"];
        echo"
        <a class=\"category_box\" href='index.php?section=home&category=$id'>
        <h2>$name</h2></a>";
    }
    echo "</div>";
} else {
    $category_id = $_GET['category'];
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
    $totalResult = $db->runQuery("SELECT COUNT(*) as total FROM posts WHERE category_id=?", [$category_id]);
    $total = $totalResult->fetch_assoc()["total"];
    $NameResult = $db->runQuery("SELECT name FROM categories WHERE id = ? LIMIT ?", [$category_id, $limit]);
    $name = $NameResult->fetch_assoc()["name"];
    $posts = Category::getPostsFromCategory($db, $category_id);
    Renderer::renderPosts($db, $posts, $total, $name);
} ?>