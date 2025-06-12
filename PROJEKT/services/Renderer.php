<?php
class Renderer
{
    public static function renderPosts($db, array $posts, $total, $heading)
    {
        echo "<div class = 'posts'>";
        if ($heading != "") {
        echo "<h1>$heading</h1>";}
        if (empty($posts)) {
            echo "<p>Nie ma tu jeszcze żadnych postów.</p>";
        } else foreach ($posts as $post) {
            self::renderPost($db, $post);
            if (isset($_GET["showComments"]) && $post->getId() == $_GET["showComments"]) {
                $comments = Comment::getComments($db, $post->getId());
                self::renderComments($db, $comments);
            }
        }
        self::renderShowMoreLink($total);
        echo "</div>";
    }
    public static function renderComments($db, array $comments)
    {
        echo "<div class = 'comments'>";
        if (empty($comments)) {
            echo "<p>Ten post nie ma jeszcze komentarzy.<p>";
        } else foreach ($comments as $comment) {
            self::renderComment($db, $comment);
        }
        echo "</div>";
    }
    public static function renderShowMoreLink($total) {
        if ($total > 0) {
            if (isset($_GET["limit"])) {
                $limit = $_GET["limit"];
            } else
                $limit = 5;
            if ($total >= $limit) {
                echo "<p><a href='index.php?" . $_SESSION['last_query'] . "&limit=" . ($limit + 5) . "' id='show-more'>Pokaż więcej...</a></p>";
            } else {
                echo "<p>To już wszystko tutaj.</p>";
            }
        }
    }
    public static function renderPost($db, $post)
    {
        $lastQuery = $_SESSION["last_query"] ?? "";
        parse_str($lastQuery, $queryArray);

        $isActive = isset($_GET['showComments']) && $_GET['showComments'] == $post->getId();

        if ($isActive) {
            unset($queryArray['showComments']);
            $baseURL = self::buildUrlWithParams($queryArray);
        } else {
            $baseURL = self::buildUrlWithParams($queryArray, ["showComments" => $post->getId()]);
        }

        $postId = $post->getId();
        $userId = $post->getUserId();
        $username = htmlspecialchars(ProfileClass::getUsername($db, $userId));
        $datetime = $post->getDatetime();
        $categoryId = $post->getCategoryId();
        $categoryName = Category::getCategoryName($db, $categoryId);
        $subject = htmlspecialchars($post->getSubject());
        $content = htmlspecialchars($post->getContent());

        echo "
         <div class=\"post_box\">
            <div class=\"post_header\" role=\"button\" onclick=\"window.location.href='$baseURL'\">
                <a href=\"index.php?section=profile&user_id=$userId\">$username</a>
                <p class=\"date\">$datetime</p>
            </div>
            <div class=\"post_content\" role=\"button\" onclick=\"window.location.href='$baseURL'\">
                <h4 class=\"subject\"><a href='index.php?section=home&category=$categoryId'>$categoryName</a>: $subject</h4>
                <p class=\"post_text\">$content</p>
            </div>
            <div class=\"post_footer\">
                <a href=\"" . self::buildUrlWithParams($queryArray, ['action' => 'new_comment', 'post_id' => $postId]) . "\">↩ Odpowiedz</a>";
        if ((isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->getUserId()) || User::checkRole($db) == "admin" || User::checkRole($db) == "mod") {
            echo " <a href=\"" . self::buildUrlWithParams($queryArray, ['action' => 'edit_post', 'post_id' => $postId]) . "\">🖊 Edytuj</a>
                <a href=\"" . self::buildUrlWithParams($queryArray, ['action' => 'delete_post', 'post_id' => $postId]) . "\">🗑 Usuń</a>";
        }
            echo "</div></div>";
    }

    public
    static function renderComment($db, $comment)
    {
        $commentId = $comment->getId();
        $userId = $comment->getUserId();
        if ($userId != null) {
            $author = htmlspecialchars(ProfileClass::getUsername($db, $userId));
        } else {
            $author = htmlspecialchars($comment->getAuthor());
        }
        $role = User::checkRolebyId($db, $userId);
        $datetime = $comment->getDatetime();
        $content = htmlspecialchars($comment->getContent());

        $lastQuery = $_SESSION["last_query"] ?? "";
        parse_str($lastQuery, $queryArray);

        if ($role === 'user') {
            $icon = '🐞';
            $title = 'Zarejestrowany użytkownik';
        } else if ($role === 'admin') {
            $icon = '🦋';
            $title = "Admin";
        } else if ($role === 'mod') {
            $icon = '🐝️';
            $title = "Moderator";
        } else {
            $icon = '🪰';
            $title = 'Gość';
        }

        echo "
            <div class=\"comment_box\"> 
            <div class=\"comment_header\">
                <p><span title=\"$title\">$icon</span> $author</p>
                <p class='date'>$datetime</p>
            </div>
            <div class=\"comment_content\">
                <p class=\"comment_text\">$content</p>
            </div>
            <div class=\"comment_footer\">";
        if ((isset($_SESSION['user_id']) && $_SESSION['user_id'] == $userId) || User::checkRole($db) == "admin" || User::checkRole($db) == "mod") {
            echo "<a href=\"" . self::buildUrlWithParams($queryArray, ['action' => 'edit_comment', 'comment_id' => $commentId]) . "\">🖊 Edytuj</a>
                      <a href=\"" . self::buildUrlWithParams($queryArray, ['action' => 'delete_comment', 'comment_id' => $commentId]) . "\">🗑 Usuń</a>";
        } else {
            echo "<br>";
        }
        echo "</div></div>";
    }
    public static function buildUrlWithParams($baseQueryArray, $extraParams = []) : string {
        $combined = array_merge($baseQueryArray, $extraParams);
        $queryString = http_build_query($combined);
        return "index.php" . ($queryString ? "?$queryString" : "");
    }
} ?>