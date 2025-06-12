<?php
$db = Database::getInstanceOf();

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$postsResult = $db->runQuery("SELECT posts.* FROM posts LEFT JOIN comments ON posts.id = comments.post_id GROUP BY posts.id ORDER BY COUNT(comments.id) DESC LIMIT ?", [$limit]);
$posts = [];
while ($row = $postsResult->fetch_assoc()) {
    $posts[] = new Post($db, $row);
}
$totalResult = $db->runQuery("SELECT COUNT(*) as total FROM posts");
$total = $totalResult->fetch_assoc()['total'];
Renderer::renderPosts($db, $posts, $total, "Popularne");
?>
<style>
    a {
        color: #92140C;
        text-decoration: none;
    }
</style>
