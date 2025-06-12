<?php
include("Database.php");
include("model/User.php");
include "Renderer.php";
include("model/Post.php");
include("model/Comment.php");
include("model/Category.php");
include("model/ProfileClass.php");
session_start();

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$db = Database::getInstanceOf();

$logged_in = isset($_SESSION['user_id']);
if ($logged_in) {
    $result = $db->runQuery("SELECT * FROM profiles WHERE user_id = ?", [$_SESSION['user_id']]);
    $row = $result->fetch_assoc();
    $username = $row['username'];
}
if (isset($_GET['section'])) {
    $section = $_GET['section'];
} else {
    $section = "home";
}
$_SESSION["section"] = $section;

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
$_SESSION["last_query"] = $_SERVER["QUERY_STRING"];
$lastQuery = $_SESSION["last_query"] ?? "";
parse_str($lastQuery, $queryArray);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <link rel="stylesheet" href="./stylesheets/home.css">
    <link rel="stylesheet" href="./stylesheets/posts_comments.css">
    <link rel="stylesheet" href="./stylesheets/profile.css">
    <link rel="stylesheet" href="./stylesheets/forms.css">
    <link rel="stylesheet" href="./stylesheets/pop-ups.css">
</head>
<body>
<header id="top_panel">
    <div class="logo">
        <img src="images/logo.png" alt="Logo">
        <a>BUGGY</a>
    </div>
    <nav>
        <ul>
            <li><a href="?section=home" class="<?= $section === "home" ? "active" : "" ?>">Strona główna</li>
            <li><a href="?section=popular" class="<?= $section === "popular" ? "active" : "" ?>">Popularne</a></li>
            <li><a href="?section=new" class="<?= $section === "new" ? "active" : "" ?>">Nowe</a></li>
        </ul>
    </nav>
    <form class="search" method="GET">
        <input type="hidden" name="section" value="search">
        <label><input list="category_names" name="search"></label>
        <?php
        Category::echoCategoryDatalist($db);
        ?>
        <button type="submit">Szukaj</button>
    </form>
</header>
<aside id="user_panel">
    <div class="user_menu">
        <?php if (!$logged_in): ?>
            <p>Hej!</p>
            <div class="buttons">
                <a class="button" href="<?php echo Renderer::buildUrlWithParams($queryArray, ["action" => "registration" ])?>">Zarejestruj się</a>
                <a class="button" href="<?php echo Renderer::buildUrlWithParams($queryArray, ["action" => "login" ])?>">Zaloguj się</a>
            </div>
        <?php else: ?>
            <p>Hej, <?= htmlspecialchars($username) ?>!</p>
            <div class="buttons">
                <a class="button" href="?section=profile&user_id=<?= $_SESSION['user_id'] ?>">Mój profil</a>
                <a class="button" href="<?php echo Renderer::buildUrlWithParams($queryArray, ["action" => "new_post" ])?>">+ Nowy post</a>
                <a class="button" href="?logout=true">Wyloguj się</a>
            </div>
        <?php endif ?>
    </div>
</aside>
<main>
    <?php
    if (isset($_GET['action'])) {
        include "actions/" . $_GET["action"] . ".php";
    }
    include "sections/$section.php"; ?>
</main>
<footer>
    <p class="copyright">&copy; 2025 Maja Makowska<br>No rights reserved</p>
</footer>
</body>
</html>