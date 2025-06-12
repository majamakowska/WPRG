<?php
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $search_input = htmlspecialchars($_GET["search"]);
    $search =  '%' . $_GET["search"] . '%';
    $db = Database::getInstanceOf();
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
    $postsResult = $db->runQuery("SELECT posts.*, categories.name AS category_name FROM posts JOIN categories ON posts.category_id = categories.id WHERE categories.name LIKE ? OR subject LIKE ? OR content LIKE ? LIMIT ?", [$search, $search, $search, $limit]);
    if ($postsResult->num_rows > 0) {
        while ($row = $postsResult->fetch_assoc()) {
            $posts[] = new Post($db, $row);
        }
        $totalResult = $db->runQuery("SELECT COUNT(*) AS total FROM posts JOIN categories ON posts.category_id = categories.id WHERE categories.name LIKE ? OR subject LIKE ? OR content LIKE ?", [$search, $search, $search]);
        $total = $totalResult->fetch_assoc()["total"];
        Renderer::renderPosts($db, $posts, $total, "Wyniki dla: '$search_input'");
    } else {
        echo "<h1>Brak wyników dla: '$search_input'</h1>";
    }
} ?>