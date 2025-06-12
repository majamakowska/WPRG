<?php
$db = Database::getInstanceOf();

$user_id = $_GET['user_id'];

$username = htmlspecialchars(ProfileClass::getUsername($db, $user_id));
$pfp = ProfileClass::getPfp($db, $user_id);

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$postsResult = $db->runQuery("SELECT * FROM posts WHERE user_id = ? LIMIT ?", [$user_id, $limit]);
$posts = [];
while ($row = $postsResult->fetch_assoc()) {
    $posts[] = new Post($db, $row);
}
$totalResult = $db->runQuery("SELECT COUNT(*) as total FROM posts WHERE user_id = ?", [$user_id]);
$total = $totalResult->fetch_assoc()["total"];
?>
<div class = top_profile>
<img class="pfp" src='<?php echo $pfp; ?>' alt="Zdjęcie profilowe"><h2><?php echo $username; if (ProfileClass::ownProfile()) :?> <a class="edit" title="Edytuj profil" href="../index.php?<?php echo $_SESSION['last_query'];?>&action=edit_profile">⚙</a><?php endif;?></h2>
</div>
<?php Renderer::renderPosts($db, $posts, $total,"");?>
