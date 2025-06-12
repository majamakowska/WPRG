<?php
$db = Database::getInstanceOf();

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$postsResult = $db->runQuery("SELECT * FROM posts ORDER BY datetime DESC LIMIT ?", [$limit]);
$posts = [];
while ($row = $postsResult->fetch_assoc()) {
    $posts[] = new Post($db, $row);
}
$totalResult = $db->runQuery("SELECT COUNT(*) as total FROM posts");
$total = $totalResult->fetch_assoc()['total'];
Renderer::renderPosts($db, $posts, $total, "Nowe");
?>
<style>
    a {
        color: #92140C;
        text-decoration: none;
    }
</style>
